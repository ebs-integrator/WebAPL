<?php

class DinamicFields {

    public static function checkCheckbox($value) {
        return $value ? 1 : 0;
    }

    public static function valueCheckbox($value) {
        return $value ? 'checked' : '';
    }

    public static function fileListValue($value, $entry, $lang_dependent, $field) {

        if ($lang_dependent) {
            $data = array(
                'post_id' => $entry->post_id,
                'feed_field_id' => $field->id,
                'lang_id' => $entry->lang_id
            );
        } else {
            $data = array(
                'post_id' => $entry->id,
                'feed_field_id' => $field->id,
                'lang_id' => 0,
                'value' => 0
            );
        }
        
        FeedFieldValue::where($data)->delete();
        FeedFieldValue::insert($data);

        return Files::widget($lang_dependent ? 'doc_post_lang' : 'doc_post', $entry->id);
    }

}
