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
    public static $defaultImageLimit = array(900, 1000);
    public static $imageLimit = array(
        'page_icon_big' => array(200, 200),
        'page_icon' => array(200, 200),
        'page_icon_active' => array(200, 200)
    );
    public static $imageLimitDisable = array(
        'page_bg'
    );
    
    public static function widget($module_name, $module_id, $num = 0, $path = '') {
        if (empty($accept)) {
            $accept = Files::$default_accept_extensions;
        }
        return View::make('sections.file.widget')->with(array(
                    'module_name' => $module_name,
                    'module_id' => $module_id,
                    'num' => $num,
                    'path' => $path
        ));
    }

    public static function file_list($module_name, $module_id) {
        return Files::where('module_name', $module_name)->where('module_id', intval($module_id))->get();
    }

    public static function getType($extension) {
        $types = array(
            'image' => array('jpg', 'png', 'jpeg', 'gif'),
            'document' => array('doc', 'docx', 'xls', 'xlsx', 'pdf'),
            'favicon' => array('ico')
        );

        foreach ($types as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                return $type;
            }
        }

        return 'undefined';
    }

    public static function fullDir($file = '') {
        return $_SERVER['DOCUMENT_ROOT'] . '/' . $file;
    }

    public static function path($filename) {
        if (!$filename) {
            return Files::$upload_dir . "/";
        } elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $filename)) {
            return $filename;
        } else {
            return Files::$upload_dir . "/" . $filename;
        }
    }

    public static function register($name, $filepath, $extension, $module_name, $module_id) {
        $file = new Files;
        $file->name = $name;
        $file->path = $filepath;
        $file->extension = $extension;
        $file->type = Files::getType($extension);
        $file->module_name = $module_name;
        $file->module_id = $module_id;
        $file->size = filesize(Files::fullDir($filepath));
        $file->save();
        return $file->id;
    }

    public static function dropFile($path, $id = 0) {
        $used = Files::where('path', 'like', "%{$path}")->where('id', '<>', $id)->count();
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $path) && $used == 0) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
        }
    }

    public static function drop($id) {
        $file = Files::find($id);
        if ($file) {
            Files::dropFile($file->path, $id);

            Log::warning("Drop file #{$id} - {$file->path}");
        }
        return Files::destroy($id);
    }

    public static function dropMultiple($module_name, $module_id) {
        foreach (Files::file_list($module_name, $module_id) as $file) {
            Files::dropFile($file->path, $file->id);
            Files::destroy($file->id);
        }
    }

    public static function resizeImage($image, $module_name) {
        $width = null;
        $heigth = null;

        if (in_array($module_name, Files::$imageLimitDisable) === FALSE) {
            $width = isset(Files::$defaultImageLimit[0]) ? Files::$defaultImageLimit[0] : null;
            $heigth = isset(Files::$defaultImageLimit[1]) ? Files::$defaultImageLimit[1] : null;

            if (!empty(Files::$imageLimit[$module_name]) && !empty(Files::$imageLimit[$module_name])) {
                $width = isset(Files::$imageLimit[$module_name][0]) ? Files::$imageLimit[$module_name][0] : null;
                $heigth = isset(Files::$imageLimit[$module_name][1]) ? Files::$imageLimit[$module_name][1] : null;
            }
        }

        if ($width === null && $heigth === null) {
            return null;
        } else {
            return Image::make(Files::fullDir($image))
                            ->resize($width, $heigth, function ($constraint) {
                                $constraint->aspectRatio();
                            })
                            ->save(Files::fullDir($image));
        }
    }

}
