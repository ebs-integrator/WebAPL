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
 
namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    PollModel,
    Input,
    PollAnswerModel,
    PollQuestionModel,
    PollAnswerLangModel,
    PollVotesModel,
    Language,
    Redirect,
    User,
    Route,
    Event,
    jQgrid;

class Poll extends \WebAPL\ExtensionController {

    protected $module_name = 'poll';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PollModel', 'PollAnswerLangModel', 'PollVotesModel'));

        Route::get('poll/list', array('before' => 'auth', array($this, 'poll_list')));
        Route::post('poll/getlist', array('before' => 'auth', array($this, 'getlist')));
        Route::get('poll/form', array('before' => 'auth', array($this, 'form')));
        Route::get('poll/form/{id}', array('before' => 'auth', array($this, 'form')));
        Route::post('poll/save', array('before' => 'auth', array($this, 'save')));
        Route::post('poll/save_lang', array('before' => 'auth', array($this, 'save_lang')));
        Route::post('poll/edititem', array('before' => 'auth', array($this, 'edititem')));
        Route::post('poll/edititem/{poll_lang_id}', array('before' => 'auth', array($this, 'edititem')));
        Route::post('poll/add', array('before' => 'auth', array($this, 'poll_add')));

        Route::get('poll/del', array('before' => 'auth', array($this, 'poll_del')));
        Route::get('poll/del/{id}', array('before' => 'auth', array($this, 'poll_del')));

        Route::post('poll/list/answer', array('before' => 'auth', array($this, 'getlist_answer')));
        Route::post('poll/list/answer/{poll_lang_id}', array('before' => 'auth', array($this, 'getlist_answer')));

        Route::get('poll/anwser/create/{id}', array('before' => 'auth', array($this, 'create_answer')));
        Route::get('poll/answer/edit/{id}', array('before' => 'auth', array($this, 'edit_answer')));
        Route::post('poll/answer/save', array('before' => 'auth', array($this, 'save_answer')));
        Route::get('poll/answer/delete/{id}', array('before' => 'auth', array($this, 'delete_answer')));
        Route::post('poll/answer/jqsave', array('before' => 'auth', array($this, 'jqsave_answer')));

        Event::listen('construct_left_menu', array($this, 'left_menu_item'));
        Event::listen('language_created', array($this, 'language_created'));
        Event::listen('language_deleted', array($this, 'language_deleted'));

        Template::registerViewMethod('page', 'pollList', 'Lista de sondaje', null, true);

        $this->layout = Template::mainLayout();
    }

    /**
     * jqgrid view with polls list
     * @return layout
     */
    public function poll_list() {
        User::onlyHas('poll-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    /**
     * get list of polls for jqgrid
     * @return json
     */
    public function getlist() {
        User::onlyHas('poll-view');

        $jqgrid = new jQgrid('apl_poll');
        return $jqgrid->populate(function($start, $limit) {
                    return PollModel::select('apl_poll.id', 'apl_poll_question.title', 'date_created', 'enabled')
                                    ->skip($start)
                                    ->take($limit)
                                    ->leftjoin('apl_poll_question', 'apl_poll.id', '=', 'apl_poll_question.poll_id')
                                    ->where('lang_id', Language::getId())
                                    ->orderBy('date_created', 'desc')
                                    ->get();
                });
    }

    /**
     * Get list of answers jqgrid
     * @param int $poll_id
     * @param int $lang_id
     * @return json
     */
    public function getlist_answer($poll_lang_id) {
        User::onlyHas('poll-view');

        $jqgrid = new jQgrid('apl_poll_answer');
        return $jqgrid->populate(function($start, $limit) use($poll_lang_id) {
                    $answers = PollAnswerModel::select(PollAnswerModel::getField('id'), PollAnswerModel::getField('poll_id'), PollAnswerModel::getField('ord'), PollAnswerLangModel::getField('title'))
                            ->join(\PollAnswerLangModel::getTableName(), PollAnswerModel::getField('id'), '=', \PollAnswerLangModel::getField('answer_id'))
                            ->where(array(\PollAnswerLangModel::getField('lang_id') => \WebAPL\Language::getId()))
                            ->skip($start)
                            ->take($limit)
                            ->where(array('poll_id' => $poll_lang_id))
                            ->orderBy('ord', 'asc')
                            ->get();
                    $list = [];
                    foreach ($answers as $answer) {
                        $list[] = array( 
                            'id' => $answer->id,
                            'title' => $answer->title,
                            'count' => PollVotesModel::where(array(
                                'poll_id' => $answer->poll_id,
                                'answer_id' => $answer->id
                            ))->count(),
                            'ord' => $answer->ord
                        );
                    }
                    return $list;
                });
    }

    public function jqsave_answer() {
        \User::onlyHas('poll-edit');

        $jqgrid = new jQgrid(\PollAnswerModel::getTableName());
        $jqgrid->operation(array(
            'ord' => Input::get('ord')
        ));
    }

    public function create_answer($id) {

        $answer = new \PollAnswerModel();
        $answer->poll_id = $id;
        $answer->save();

        foreach (\WebAPL\Language::getList() as $lang) {
            $answerLang = new \PollAnswerLangModel();
            $answerLang->answer_id = $answer->id;
            $answerLang->lang_id = $lang->id;
            $answerLang->save();
        }

        return \Illuminate\Support\Facades\Redirect::to('poll/answer/edit/' . $answer->id);
    }

    public function edit_answer($id) {
        User::onlyHas('poll-edit');

        $data = array(
            'answer' => PollAnswerModel::find($id),
            'answer_langs' => PollAnswerLangModel::where('answer_id', $id)->get(),
            'module' => $this->module_name
        );

        $this->layout->content = Template::moduleView($this->module_name, 'views.answerform', $data);
        return $this->layout;
    }

    public function save_answer() {
        $answers = Input::get('answer');
        $answer_id = Input::get('answer_id');
        $general = Input::get('general');

        if ($general) {
            $answ = PollAnswerModel::find($answer_id);
            if ($answ) {
                $answ->ord = $general['ord'];
                $answ->save();
            }
        }

        foreach ($answers as $anl_id => $ans) {
            $anw = PollAnswerLangModel::find($anl_id);
            if ($anw->answer_id == $answer_id) {
                $anw->title = $ans;
                $anw->save();
            }
        }

        return [];
    }

    public function delete_answer($id) {
        $answer = PollAnswerModel::find($id);
        $answer_id = 0;
        if ($answer) {
            $answer_id = $answer->poll_id;
            $answer->delete();
            PollAnswerLangModel::where('answer_id', $id)->delete();
            PollVotesModel::where('answer_id', $id)->delete();
        }

        return \Illuminate\Support\Facades\Redirect::to('poll/form/' . $answer_id);
    }

    /**
     * Edit / create poll
     * @param int $id
     * @return layout
     */
    public function form($id = 0) {
        User::onlyHas('poll-edit');

        if ($id === 0) {
            $poll = new PollModel;
            $poll->save();
            $id = $poll->id;

            foreach (\WebAPL\Language::getList() as $lang) {
                $pollLang = new PollQuestionModel;
                $pollLang->poll_id = $id;
                $pollLang->lang_id = $lang->id;
                $pollLang->save();
            }

            return \Illuminate\Support\Facades\Redirect::to('poll/form/' . $id);
        }

        $data = array(
            'poll' => PollModel::find($id),
            'poll_question' => array(),
            'module' => $this->module_name
        );

        if ($data['poll']) {
            $pollLangs = PollModel::find($id)->langs()->get();
            foreach ($pollLangs as $pollLang) {
                $data['poll_question'][$pollLang->lang_id] = $pollLang;
            }
        }


        $this->layout->content = Template::moduleView($this->module_name, 'views.form', $data);
        return $this->layout;
    }

    /**
     * Save changes
     * @return array/json
     */
    public function save() {
        User::onlyHas('poll-edit');

        $id = Input::get('id');

        if ($id) {
            // if poll exists, find
            $poll = PollModel::find($id);
            if (!$poll) {
                throw Exception('Poll not found #' . $ic);
            }
        } else {
            // if poll does not exists, create new
            $poll = new PollModel();
        }

        $poll->enabled = (Input::get('enabled') == 'on') ? 1 : 0;
        $poll->active = (Input::get('active') == 'on') ? 1 : 0;
        $poll->save();

        if ($id) {
            return array(
                'error' => 0
            );
        } else {
            // if poll has been created, refresh page
            return array(
                'redirect_to' => url('poll/form/' . $poll->id)
            );
        }
    }

    /**
     * Save language changes
     * @return array/json
     */
    public function save_lang() {
        User::onlyHas('poll-edit');

        $poll_id = Input::get('poll_id');
        $poll_question_id = Input::get('poll_question_id');

        $redirect_to = '';

        if ($poll_question_id) {
            // if the poll-question exist, find
            $poll_question = PollQuestionModel::find($poll_question_id);
        } else {
            if (!$poll_id) {
                // if the poll does not exist, create empty poll record
                $poll = new PollModel();
                $poll->save();
                $new_poll_id = $poll->id;
                $redirect_to = url('poll/form/' . $new_poll_id);
            }

            // if the poll-question does not exist, create new
            $poll_question = new PollQuestionModel;
            $redirect_to = url('poll/form/' . $poll_id);
        }

        $poll_question->title = Input::get('question');
        $poll_question->poll_id = Input::get('poll_id');
        $poll_question->lang_id = Input::get('lang_id');
        $poll_question->save();

        if ($redirect_to) {
            // if poll has been created, refresh page
            return array(
                'redirect_to' => $redirect_to
            );
        }
    }

    /**
     * Edit item jqgrid
     */
    public function edititem($poll_question_id = 0) {
        User::onlyHas('poll-edit');

        $jqgrid = new jQgrid('apl_poll_answer');
        $jqgrid->operation(array(
            'title' => Input::get('answer'),
            'poll_question_id' => $poll_question_id
        ));
    }

    /**
     * Action for left menu
     */
    public function left_menu_item() {
        if (User::has('poll-view')) {
            echo Template::moduleView($this->module_name, 'views.poll-menu');
        }
    }

    public function poll_del($id = 0) {
        User::onlyHas('poll-edit');

        PollModel::where(array('id' => $id))->delete();
        PollQuestionModel::where(array('poll_id' => $id))->delete();
        PollAnswerModel::where(array('poll_id' => $id))->delete();

        return Redirect::to('poll/list');
    }

    public function language_created($lang_id) {
        $list = \PollModel::all();
        foreach ($list as $ent) {
            $item = new PollQuestionModel;
            $item->poll_id = $ent->id;
            $item->lang_id = $lang_id;
            $item->save();
        }
    }

    public function language_deleted($lang_id) {
        $list = PollQuestionModel::where('lang_id', $lang_id);
        foreach ($list as $item) {
            \PollAnswerModel::where('poll_question_id', $item->id);
            $item->delete();
        }
    }

}
