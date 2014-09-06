<?php

class DinamicFields {
    
    public static function fileListPrepare($field, $post) {
        return Files::where(array(
            'module_name' => 'doc_post_lang',
            'module_id' => $post->post_lang_id,
            'type' => 'document'
        ))->get();
    }
    
}