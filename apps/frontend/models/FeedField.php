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
 
class FeedField extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_feed_field';
    public $timestamps = false;

    public static function get($feed_id, $post_id, $lang_id = 0, $in_form = 1) {

        $stmt = FeedField::join('apl_feed_rel', 'apl_feed_field.id', '=', 'apl_feed_rel.feed_field_id')
                ->leftJoin('apl_feed_field_value', function($join) use ($post_id, $lang_id) {
                            $join->on('apl_feed_field_value.feed_field_id', '=', 'apl_feed_field.id');
                            $join->where('apl_feed_field_value.post_id', '=', (int)$post_id);
                            if ($lang_id) {
                                $join->where('apl_feed_field_value.lang_id', '=', (int)$lang_id);
                            }
                        })
                ->select('apl_feed_field.*', 'apl_feed_field_value.value');

        if (is_array($feed_id)) {
            $stmt = $stmt->whereIn('apl_feed_rel.feed_id', $feed_id);
        } else {
            $stmt = $stmt->where('apl_feed_rel.feed_id', $feed_id);
        }
        
        if ($lang_id) {
            $stmt = $stmt->where('apl_feed_field.lang_dependent', 1);
        } else {
            $stmt = $stmt->where('apl_feed_field.lang_dependent', 0);
        }
        
        $stmt = $stmt->where('apl_feed_field.in_form', $in_form);

        return $stmt->distinct()->get();
    }

}