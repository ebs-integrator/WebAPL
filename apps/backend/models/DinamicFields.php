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

    public static function addFieldsValue($value, $entry, $lang_dependent, $field) {
        $data = ['field' => $field, 'fvalue' => $value];

        return View::make('sections.feed.fields.dinamic', $data);
    }

    public static function addFieldsPrepare() {
        $fields = Input::get('field');

        $pattern = array('name', 'lang_id', 'value');
        $rows = array();

        $i = 0;
        $ri = 0;
        $fcount = count($fields);
        while ($i < $fcount) {
            foreach ($pattern as $point) {
                $rows[$ri][$point] = $fields[$i][$point];
                $i++;
            }
            $ri++;
        }

        // unset last rows
        if ($rows)
            unset($rows[count($rows) - 1]);

        $result = serialize($rows);

        return $result;
    }

}
