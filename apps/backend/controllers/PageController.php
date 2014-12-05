<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 
class PageController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });

        $this->taxonomy = Taxonomy::get('page');

        Event::listen('page_attachment', function ($page) {
            echo View::make('sections.feed.attachment-page', array(
                'post' => $page->toArray(),
                'list' => Feed::orderBy('name', 'asc')->get()
            ));
        });
    }

    protected $taxonomy;
    protected $layout = 'layout.main';

    /**
     * Page form
     * @param int $page_id
     */
    public function getIndex($page_id = 0) {
        User::onlyHas("page-view");

        if ($page_id) {
            $this->data['page'] = Post::findTax($page_id, $this->taxonomy->id);
            if ($this->data['page']) {
                $this->data['view_mods'] = Template::getViewMethodList('page');
                $this->data['page_langs'] = $this->data['page']->langs()->get();
                $this->data['page_properties_all'] = PostProperty::where('taxonomy_id', 1)->orderBy('name', 'asc')->get();

                $properties = PostPropertyRel::where('post_id', $page_id)->get();
                $this->data['page_properties'] = [];
                foreach ($properties as $property) {
                    $this->data['page_properties'][] = $property->post_property_id;
                }
            }
        }

        $this->data['tree_pages'] = Post::tree($this->taxonomy->id);

        View::share($this->data);
        $this->layout->content = View::make('sections.page.layout');
    }

    /**
     * Create new page
     * @return Redirect
     */
    public function postCreate() {
        User::onlyHas("page-create");

        $parent = Input::get('parent');

        $page = new Post;
        $page->parent = $parent;
        $page->author_id = Auth::user()->id;
        $page->taxonomy_id = $this->taxonomy->id;
        $page->save();

        foreach (Language::getList() as $lang) {
            $pageLang = new PostLang;
            $pageLang->lang_id = $lang->id;
            $pageLang->post_id = $page->id;
            $pageLang->save();
        }

        $page->ord_num = $page->id;
        $page->save();

        Log::info("Create page #{$page->id}");

        return Redirect::to('page/index/' . $page->id);
    }

    /**
     * Save page changes
     * @return type
     */
    public function postSave() {
        User::onlyHas("page-edit");

        $page_id = Input::get('id');
        $page = Input::get('page');
        $page_lang = Input::get('lang');

        $post = Post::find($page_id);
        if ($post && $page) {
            $post->created_at = $page['created_at'];
            $post->updated_at = date('Y-m-d G:i:s');
            if (User::has('page-move')) {
                if ($page['parent'] != $page_id) {
                    $post->parent = $page['parent'];
                }
            }
            $post->clone_id = $page['clone_id'];
            $post->redirect_to = $page['redirect_to'];
            $post->view_mod = $page['view_mod'];
            $post->general_node = isset($page['general_node']) ? 1 : 0;
            $post->is_home_page = isset($page['is_home_page']) ? 1 : 0;
            $post->have_socials = isset($page['have_socials']) ? 1 : 0;
            $post->have_comments = isset($page['have_comments']) ? 1 : 0;
            if ($post->is_home_page) {
                DB::table(Post::getTableName())->where('is_home_page', 1)->where(Post::getField('id'), '<>', $page_id)->update(array('is_home_page' => 0));
            }
            $post->save();
        }

        if ($page_lang) {
            foreach ($page_lang as $page_lang_id => $page_lang) {
                $post_lang = PostLang::find($page_lang_id);
                $post_lang->title = $page_lang['title'];
                $post_lang->text = $page_lang['text'];
                $post_lang->enabled = isset($page_lang['enabled']) && $page_lang ? 1 : 0;
                if ($page_lang['uri']) {
                    $post_lang->uri = PostLang::uniqURI($page_lang_id, $page_lang['uri']);
                } else {
                    $post_lang->uri = PostLang::uniqURI($page_lang_id, $page_lang['title']);
                }
                $post_lang->save();
            }
        }

        if ($page) {
            $properties = Input::get('properties');
            PostPropertyRel::where('post_id', $page_id)->delete();
            if (is_array($properties)) {
                foreach ($properties as $property) {
                    $prop = PostProperty::find($property);
                    if ($prop) {
                        if ($prop->is_unique) {
                            PostPropertyRel::where('post_property_id', $prop->id)->delete();
                        }

                        $newproperty = new PostPropertyRel;
                        $newproperty->post_id = $page_id;
                        $newproperty->post_property_id = $property;
                        $newproperty->save();
                    }
                }
            }
        }

        if (isset($post->clone_id) && $post->clone_id) {
            $this->clonePageLangData($post->clone_id, $post->id);
        }
        
        $clones = Post::where('clone_id', $post->id)->get();
        foreach ($clones as $clone) {
            $this->clonePageLangData($post->id, $clone->id);
        }

        Log::info("Edit page #{$page_id}");

        return array(
        );
    }

    public function postSavefilesdata() {
        User::onlyHas("page-edit");

        $page_id = Input::get('id');
        $post = Post::find($page_id);
        $post->show_files = Input::has('data.show_files') ? 1 : 0;
        $post->show_file_search = Input::has('data.show_file_search') ? 1 : 0;
        $post->save();

        Log::info("Edit page file settings #{$page_id}");

        return array();
    }

    private function clonePageLangData($source_id, $target_id) {
        //echo 'run cloning';
        foreach (WebAPL\Language::getList() as $lang) {

            $source = PostLang::where(array(
                        'lang_id' => $lang->id,
                        'post_id' => $source_id
                    ))->get()->first();
            $target = PostLang::where(array(
                        'lang_id' => $lang->id,
                        'post_id' => $target_id
                    ))->get()->first();

            if ($source && $target) {
                $target->title = $source->title;
                $target->uri = PostLang::uniqURI($source_id, $source->uri);
                $target->save();
            } else {
                throw new Exception("Undefined source or target on cloning: source#{$source_id}, target#{$target_id}");
            }
        }
    }

    public function getMove($page_id, $up) {
        User::onlyHas("page-order");

        $page = Post::find($page_id);

        if ($page) {

            $spage = Post::where(Post::getField('parent'), $page->parent)->where(Post::getField("ord_num"), $up ? '<' : '>', $page->ord_num)->orderBy('ord_num', $up ? 'desc' : 'asc')->first();

            if ($spage) {
                $ord_num = $page->ord_num;

                $page->ord_num = $spage->ord_num;
                $page->save();

                $spage->ord_num = $ord_num;
                $spage->save();

                Log::info("Move page ord,  #{$page->id} - #{$spage->id}");
            }

            return Redirect::back();
        } else {
            throw new Exception("Page not found #{$page_id}, move action");
        }
    }

    public function getDelete($id) {
        User::onlyHas("page-delete");

        $trash_folder = 270;

        if ($id != $trash_folder) {
            PostLang::where('post_id', $id)->update(['enabled' => 0]);
            $page = Post::find($id);
            $page->parent = $trash_folder;
            $page->save();
        }

        return Redirect::back();
    }

    public function getClear() {

        return '---';

        $parent = 270;

        $pages = Post::where('parent', $parent)->get();

        echo "<pre>";

        foreach ($pages as $page) {
            $pagelang = PostLang::where('post_id', $page->id)->get();
            echo "#{$page->id}\n";
            foreach ($pagelang as $pagel) {
                echo "   #{$pagel->id}\n";
                $pagel->delete();
            }
            $page->delete();
        }

        return [];
    }

    public function getExport() {

        $buffer = "";

        $pages = Post::where('taxonomy_id', 1)->get();

        foreach ($pages as $page) {
            $langs = PostLang::where('post_id', $page->id)->get();
            foreach ($langs as $plang) {
                $langname = WebAPL\Language::getItem($plang->lang_id)->name;
                $buffer .= "{$plang->id},{$langname},\"{$plang->title}\"\n";
            }
            $buffer .= "\n";
        }

        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=Customers_Export.csv');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        return $buffer;
    }

    public function getImport() {
        $xsdstring = $_SERVER['DOCUMENT_ROOT'] . "/import.xml";



        $excel = new XML2003Parser($xsdstring);

        $table = $excel->getTableData();

        function mb_ucfirst($str, $enc = 'utf-8') {
            return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc) . mb_substr($str, 1, mb_strlen($str, $enc), $enc);
        }

        foreach ($table["table_contents"] as $row) {
            if (isset($row["row_contents"][2]) && isset($row["row_contents"][0])) {
                $id = $row["row_contents"][0]['value'];
                $value = trim(mb_ucfirst(mb_strtolower(($row["row_contents"][2]['value']))));
                $postlang = PostLang::find($id);
                if ($postlang) {
                    $postlang->title = $value;
                    $postlang->uri = PostLang::uniqURI($id, $value);
                    $postlang->save();
                } else {
                    echo "undefined {$id} <br>";
                }

                //echo  "$id  $value<br><br><br>";
            }
        }
        return [];
    }

}
