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

        return View::make('sections.feed.fields.dinamic', $data)->render();
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
