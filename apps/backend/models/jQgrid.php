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
 
class jQgrid {

    protected $table = '';
    protected $pk = '';
    
    public $row_id = 0;
    public $where = array();

    /**
     * TRUE - use populate select for count
     * FALSE - use table count
     * @var bool 
     */
    public $use_populate_count = false;

    public function __construct($table, $pk = 'id') {
        $this->table = $table;
        $this->pk = $pk;
    }

    /**
     * get row
     * @param int $id
     * @return array
     */
    public function get($id) {
        return DB::table($this->table)->where($this->pk, $id)->first();
    }

    /**
     * jqgrid insert
     * @param array $params
     * @return int
     */
    public function insert($params) {
        return DB::table($this->table)->insertGetId($params);
    }

    /**
     * jqgrid update
     * @param array $params
     * @param int $id
     * @return int
     */
    public function update($params) {
        return DB::table($this->table)
                        ->where($this->where)
                        ->update($params);
    }

    /**
     * jqgrid delete
     * @param str $id
     */
    public function delete() {
        DB::table($this->table)->where($this->where)->delete();
    }

    /**
     * select operation
     * @param str $oper
     * @param array $params
     * @param int $id
     * @return mixed
     */
    public function operation($params) {
        // if defined custom id
        if ($this->row_id) {
            $id = $this->row_id;
        } else {
            $id = Input::get('id');
        }
        
        if (empty($this->where)) {
            $this->where = array($this->pk => $id);
        }
        
        $oper = Input::get('oper');

        switch ($oper) {
            case 'add' : {
                    $result = $this->insert($params);
                }
                break;

            case 'edit' : {
                    $result = $this->update($params);
                }
                break;

            case 'del' : {
                    $result = $this->delete();
                }
                break;
        }
        return $result;
    }

    /**
     * return start limit
     * @param int $count
     * @param int $page
     * @param int $limit
     * @return int
     */
    public function start($count, $page, $limit) {
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages) {
            $page = $total_pages;
        }
        if ($page == 0) {
            $page = 1;
        }

        $start = $limit * $page - $limit;

        return $start;
    }

    public function getCount() {
        return DB::table($this->table)->count();
    }

    /**
     * json for jqgrid
     * @param array $list
     * @param int $count
     * @param int $page
     * @return json
     */
    public function populate($query) {
        $page = Input::get('page');
        $limit = Input::get('rows');
        $sord = Input::get('sord');
        $sidx = Input::get('sidx');

        // get total count
        if ($this->use_populate_count) {
            $count = count($query(null, null, $sord, $sidx));
        } else {
            $count = $this->getCount();
        }

        // get offset
        $start = $this->start($count, $page, $limit);

        // get list
        $list = $query($start, $limit, $sord, $sidx);

        $responce = new stdClass();

        if ($count == 0) {
            $total_pages = 0;
            $responce->page = 0;
            $responce->total = 0;
            $responce->records = 0;
        } else {
            $total_pages = ceil($count / $limit);
            $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;
            $i = 0;
            
            $responce->rows = array();
            foreach ($list as $row) {
                $responce->rows[$i]['id'] = is_array($row) ? $row[$this->pk] : $row->{$this->pk};

                // convert row to simple array
                if (is_a($row, 'stdClass')) {
                    $cell = (array) $row;
                } elseif (is_array($row)) {
                    $cell = $row;
                } else {
                    $cell = $row->toArray();
                }
                
                $responce->rows[$i]['cell'] = array_values($cell);
                $i++;
            }
        }

        return json_encode($responce);
    }

}
