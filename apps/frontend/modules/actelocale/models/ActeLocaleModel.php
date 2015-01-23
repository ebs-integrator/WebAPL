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
 
class ActeLocaleModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_acte';
    public $timestamps = false;
    public static $filesDir = "actelocale";
    public static $filesModule = "actelocale";

    public static function getYears() {
        return ActeLocaleModel::distinct()
                        ->orderBy(ActeLocaleModel::getField('date_upload'), 'desc')
                        ->select(DB::raw("YEAR(" . ActeLocaleModel::getField('date_upload') . ") as year"))
                        ->get();
    }

    public static function prepare() {
        return ActeLocaleModel::join(Files::getTableName(), Files::getField('module_id'), '=', ActeLocaleModel::getField('id'))
                        ->where(Files::getField('module_name'), ActeLocaleModel::$filesModule)
                        ->select(ActeLocaleModel::getField("*"), Files::getField('path'), DB::raw("MONTH(" . ActeLocaleModel::getField('date_upload') . ") as date_month"))
                        ->orderBy(ActeLocaleModel::getField('date_upload'), 'asc');
    }

    public static function extract($year) {
        $list = ActeLocaleModel::prepare()
                ->where(DB::raw("YEAR(" . ActeLocaleModel::getField('date_upload') . ")"), intval($year))
                ->get();

        $groups = [];

        foreach ($list as $item) {
            if (isset($groups[$item->date_month])) {
                $groups[$item->date_month][] = $item;
            } else {
                $groups[$item->date_month] = [$item];
            }
        }

        return $groups;
    }
    
    public static function last($year) {
        return ActeLocaleModel::prepare()
                ->where(ActeLocaleModel::getField('date_upload'), '<=', DB::raw("CURRENT_TIMESTAMP"))
                ->orderBy(ActeLocaleModel::getField('date_upload'), 'desc')
                ->where(DB::raw("YEAR(" . ActeLocaleModel::getField('date_upload') . ")"), intval($year))
                ->first();
    }
    
}
