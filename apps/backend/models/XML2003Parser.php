<?php

class XML2003Parser {

    private $table_arr;

    public function __construct($url = NULL, $escape = TRUE) {
        if (isset($url))
            $this->loadXMLFile($url, $escape);
    }

    private function getAttributes($attrs_obj) {
        $attrs_arr = array();
        foreach ($attrs_obj as $attrs) {
            $attrs = (array) $attrs;
            foreach ($attrs as $attr) {
                $attr_keys = array_keys($attr);
                $attrs_arr[$attr_keys[0]] = $attr[$attr_keys[0]];
            }
        }
        return $attrs_arr;
    }

    public function getCellData($row_num, $col_num) {

        // check whether the cell exists
        if (!isset($this->table_arr['table_contents'][$row_num - 1]['row_contents'][$col_num - 1])) {
            return FALSE;
        }
        return $this->table_arr['table_contents'][$row_num - 1]['row_contents'][$col_num - 1];
    }

    public function getColumnData($col_num) {
        $col_arr = array();

        if (!isset($this->table_arr['table_contents'])) {
            return FALSE;
        }

        // get the specified column within every row
        foreach ($this->table_arr['table_contents'] as $row) {
            array_push($col_arr, $row['row_contents'][$col_num - 1]);
        }

        // return the array, if empty then return FALSE
        return $col_arr;
    }

    public function getRowData($row_num) {
        if (!isset($this->table_arr['table_contents'][$row_num - 1]['row_contents'])) {
            return FALSE;
        }
        $row = $this->table_arr['table_contents'][$row_num - 1]['row_contents'];
        $row_arr = array();

        // get the specified column within every row 
        foreach ($row as $cell) {
            array_push($row_arr, $cell);
        }

        // return the array, if empty then return FALSE			
        return $row_arr;
    }

    public function getTableData() {
        return isset($this->table_arr) ? $this->table_arr : FALSE;
    }

    public function loadXMLFile($url, $escape = TRUE) {
        $this->table_arr = array(
            'doc_props' => array(),
            'table_contents' => array()
        );

        // assign simpleXML object
        if ($simplexml_table = simplexml_load_file($url)) {

            // check XML namespace and return if the loaded file isn't a valid XML 2003 spreadsheet					
            $xmlns = $simplexml_table->getDocNamespaces();
            if ($xmlns['ss'] != 'urn:schemas-microsoft-com:office:spreadsheet') {
                return FALSE;
            }
        } else {

            // when error loading file
            return FALSE;
        }

        // extract document properties
        $doc_props = (array) $simplexml_table->DocumentProperties;
        $this->table_arr['doc_props'] = $doc_props;

        $rows = $simplexml_table->Worksheet->Table->Row;
        $row_num = 1;

        // loop through all rows		
        foreach ($rows as $row) {

            $cells = $row->Cell;
            $row_attrs = $row->xpath('@ss:*');
            $row_attrs_arr = $this->getAttributes($row_attrs);
            $row_arr = array();
            $col_num = 1;

            // loop through all row's cells
            foreach ($cells as $cell) {

                // check whether ss:Index attribute exist
                $cell_index = $cell->xpath('@ss:Index');

                // if exist, push empty value until the specified index
                if (count($cell_index) > 0) {
                    $gap = $cell_index[0] - count($row_arr);
                    for ($i = 1; $i < $gap; $i++) {
                        array_push($row_arr, array(
                            'row_num' => $row_num,
                            'col_num' => $col_num,
                            'datatype' => '',
                            'value' => '',
                                //'cell_attrs' => '',
                                //'data_attrs' => ''
                        ));
                        $col_num += 1;
                    }
                }

                // get all cell and data attributes				
//                $cell_attrs = $cell->xpath('@ss:*');
//                $cell_attrs_arr = $this->getAttributes($cell_attrs);
//                $data_attrs = $cell->Data->xpath('@ss:*');
//                $data_attrs_arr = $this->getAttributes($data_attrs);
//                $cell_datatype = $data_attrs_arr['Type'];

                // extract data from cell
                $cell_value = (string) $cell->Data;

                // filter from any HTML tags
                if ($escape)
                    $cell_value = htmlspecialchars($cell_value);

                // push column array
                array_push($row_arr, array(
                    'row_num' => $row_num,
                    'col_num' => $col_num,
                    //'datatype' => $cell_datatype,
                    'value' => $cell_value,
                        //'cell_attrs' => $cell_attrs_arr,
                        //'data_attrs' => $data_attrs_arr
                ));
                $col_num += 1;
            }

            // push row array
            array_push($this->table_arr['table_contents'], array(
                'row_num' => $row_num,
                'row_contents' => $row_arr,
                    //'row_attrs' => $row_attrs_arr
            ));
            $row_num += 1;
        }

        // load succeed :)
        return TRUE;
    }

}