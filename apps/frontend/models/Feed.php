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
 
class Feed extends Eloquent {

    protected $table = 'apl_feed';
    public $timestamps = false;
    protected static $cache_feed = array();

    public function rposts() {
        return $this->hasMany('FeedPost', 'feed_id', 'id');
    }

    public static function getFeed($feed_id) {
        if (isset(static::$cache_feed[$feed_id])) {
            $feed = static::$cache_feed[$feed_id];
        } else {
            $feed = Feed::where('id', $feed_id)
                    ->where('enabled', 1)
                    ->get()
                    ->first();
            static::$cache_feed[$feed_id] = $feed;
        }

        return $feed;
    }

    public static function getYears($feed_id) {
        return Post::join(FeedPost::getTableName(), FeedPost::getField('post_id'), '=', Post::getField('id'))
                ->distinct()
                ->orderBy(Post::getField('created_at'), 'desc')
                ->select(DB::raw("YEAR(" . Post::getField('created_at') . ") as year"))
                ->where(FeedPost::getField('feed_id'), '=', $feed_id)
                ->get();
    }
    
    public static function getMonths($feed_id, $year) {
        
    }

}
