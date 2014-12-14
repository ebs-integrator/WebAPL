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
 
class UploaderController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    public function filemanager() {
        User::onlyHas('file-manage');
        
        return View::make('layout.main', array(
                    'content' => View::make('sections.file.filemanager')
        ));
    }

    /**
     * Get filelist
     */
    public function filelist() {
        $files = Files::file_list(Input::get('module_name'), Input::get('module_id'));

        $data = array();
        $data['html'] = View::make('sections.file.file_list')->with(array(
                    'module_name' => Input::get('module_name'),
                    'module_id' => Input::get('module_id'),
                    'num' => Input::get('num'),
                    'files' => $files
                ))->render();

        return $data;
    }

    /**
     * Upload file
     * @return array
     */
    public function start() {
        $data = array(
            'module_id' => Input::get('module_id'),
            'module_name' => Input::get('module_name'),
            'num' => Input::get('num'),
            'path' => urigen(Input::get('upath'))
        );
        if (Input::hasFile('upload_file')) {
            $file = Input::file('upload_file');

            $extension = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();

            $filename = $name;

            $uploadDir = Files::$upload_dir . ($data['path'] ? "/" . $data['path'] : '');

            $fileType = Files::getType($extension);

            if (!file_exists(Files::fullDir($uploadDir))) {
                @mkdir(Files::fullDir($uploadDir), 0777);
            }

            if (!file_exists(Files::fullDir($uploadDir))) {
                $uploadDir = Files::$upload_dir;
            }

            if (file_exists(Files::fullDir($uploadDir) . "/" . $filename)) {
                $filename = urigen($name) . '-' . uniqid() . "." . $extension;
            }
            
            $uploadSuccess = $file->move(Files::fullDir($uploadDir), $filename);

            $uploadFile = $uploadDir . "/" . $filename;
            
            if ($uploadSuccess) {
                $fid = Files::register($name, $uploadFile, $extension, $data['module_name'], $data['module_id']);

                if ($fileType === 'image') {
                    Files::resizeImage($uploadFile, $data['module_name']);
                }

                $data['error'] = '0';
                $data['succes'] = 'Uploaded!';

                Log::info("File uploaded #{$fid} - '{$filename}'");
            } else {
                $data['error'] = '1';
                $data['succes'] = 'Error!';

                Log::warning("Error upload file {$name}");
            }
        } else {
            $data['error'] = '1';
            $data['succes'] = 'Upload file not found';
        }
        return $data;
    }

    /**
     * Upload file
     * @return array
     */
    public function add() {
        $data = array(
            'module_id' => Input::get('module_id'),
            'module_name' => Input::get('module_name'),
            'num' => Input::get('num'),
            'filepath' => Input::get('path')
        );

        $filename = ltrim($data['filepath'], '/');
        $name = basename($filename);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $dbfile = Files::where('path', 'like', "%{$name}")->first();

        if ($dbfile) {
            $filename = $dbfile->path;
            $name = $dbfile->name;
            $extension = $dbfile->extension;
        }

        $fid = Files::register($name, $filename, $extension, $data['module_name'], $data['module_id']);

        $data['error'] = '0';
        $data['succes'] = 'Uploaded!';

        Log::info("File added #{$fid} - '{$filename}'");

        return $data;
    }

    /**
     * Ajax delete file
     * @return array
     */
    public function delete() {
        User::onlyHas('file-delete');

        $id = Input::get('id');
        $data = array(
            'deleted' => 0
        );
        if ($id) {
            $data['deleted'] = Files::drop($id);
        }
        return $data;
    }

    public function editname() {
        $id = Input::get('id');
        $name = Input::get('name');

        $file = Files::find($id);

        if ($file) {
            $file->name = $name;
            $file->save();
        } else {
            throw new Exception("File not found #{$id}");
        }
    }

}
