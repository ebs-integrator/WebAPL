<?php

/**
 * jqgrid model
 * analog codeigniter gpanel model
 * https://github.com/ngodina/GPanel/blob/master/application/backend/models/jqgrid_model.php
 */
class jQgrid {

    protected $table = '';
    protected $pk = '';
    
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
        return DB::table($this->table)->insert($params);
    }

    /**
     * jqgrid update
     * @param array $params
     * @param int $id
     * @return int
     */
    public function update($params, $id) {
        return DB::table($this->table)
                        ->where($this->pk, $id)
                        ->update($params);
    }

    /**
     * jqgrid delete
     * @param str $id
     */
    public function delete($id) {
        $idx = explode(",", $id);
        foreach ($idx as $id) {
            DB::table($this->table)->where($this->pk, $id)->delete();
        }
    }

    /**
     * select operation
     * @param str $oper
     * @param array $params
     * @param int $id
     * @return mixed
     */
    public function operation($params) {
        $id = Input::get('id');
        $oper = Input::get('oper');
        
        switch ($oper) {
            case 'add' : {
                    $result = $this->insert($params);
                }
                break;

            case 'edit' : {
                    $result = $this->update($params, $id);
                }
                break;

            case 'del' : {
                    $result = $this->delete($id);
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
        
        $count = $this->getCount();
        $start = $this->start($count, $page, $limit);
        
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
                $responce->rows[$i]['id'] = $row->{$this->pk};
                $responce->rows[$i]['cell'] = array_values((array)$row);
                $i++;
            }
        }

        return json_encode($responce);
    }

}
