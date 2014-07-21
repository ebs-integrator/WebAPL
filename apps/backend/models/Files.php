<?php

class Files extends Eloquent {

    protected $table = 'apl_file';
    public $timestamps = false;
    public static $default_accept_extensions = array(
        'jpg',
        'png',
        'jpeg'
    );
    public static $upload_dir = 'upload';

    public static function widget($module_name, $module_id, $num = 0, $accept = array()) {
        if (empty($accept)) {
            $accept = Files::$default_accept_extensions;
        }
        return View::make('sections.file.widget')->with(array(
                    'module_name' => $module_name,
                    'module_id' => $module_id,
                    'num' => $num
        ));
    }

    public static function file_list($module_name, $module_id) {
        return Files::where('module_name', $module_name)->where('module_id', intval($module_id))->get();
    }

    public static function getType($extension) {
        $types = array(
            'image' => array('jpg', 'png', 'jpeg', 'gif'),
            'document' => array('doc', 'docx', 'xls', 'xlsx', 'pdf')
        );

        foreach ($types as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                return $type;
            }
        }

        return 'undefined';
    }

    public static function fullDir($file = '') {
        return $_SERVER['DOCUMENT_ROOT'] . '/' . Files::$upload_dir . "/" . $file;
    }

    public static function register($name, $filename, $extension, $module_name, $module_id) {
        $file = new Files;
        $file->name = $name;
        $file->path = Files::$upload_dir . "/" . $filename;
        $file->extension = $extension;
        $file->type = Files::getType($extension);
        $file->module_name = $module_name;
        $file->module_id = $module_id;
        $file->size = filesize(Files::fullDir($filename));
        $file->save();
        return $file->id;
    }

    public static function dropFile($path) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $path)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
            }
    }
    
    public static function drop($id) {
        $file = Files::find($id);
        if ($file) {
            Files::dropFile($file->path);
        }
        return Files::destroy($id);
    }
    
    public static function dropMultiple($module_name, $module_id) {
        foreach (Files::file_list($module_name, $module_id) as $file) {
            Files::dropFile($file->path);
            Files::destroy($file->id);
        }
    }

}
