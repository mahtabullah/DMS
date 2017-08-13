<?php

class Tree_hierarchy extends CI_Model {

    public function insert_left_right($tbl, $data) {
        $this->db->insert($tbl, $data);
    }

    public function update_left_right($tbl, $lft, $rgt) {
        $query = mysql_query("update $tbl set `left`=`left`+2,`right`=`right`+2 where `left`>=$lft");
    }

    public function update_parent_left_right($tbl, $lft, $rgt) {
        $query = mysql_query("update $tbl set `right`=`right`+2 where `left`<$lft and `right`>=$rgt-1");
    }

    public function getElementLftRgt($tbl, $cond_col, $elem) {
        $this->db->where($cond_col, $elem);
        $this->db->select('left,right');
        $this->db->from($tbl);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getElementRgtByLft($tbl) {
        $this->db->where('left', 1);
        $this->db->select('right');
        $this->db->from($tbl);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getParentIds($tbl, $col, $left, $right) {
        $query = mysql_query("select $col from $tbl where `left`<$left and `right`>$right");
        $row = array();
        while ($res = mysql_fetch_array($query)) {
            $row[] = array($res[$col]);
        }
        return $row;
    }

    public function getImmediateParentId($tbl, $col, $left, $right) {
        $query = mysql_query("select `$col`,`left`,`right` from `$tbl` where `left` < $left and `right` > $right");
        $row = array();
        while ($res = mysql_fetch_array($query)) {
            $lft[] = $res['left'];
            $rgt[] = $res['right'];
            $id_val[] = $res[$col];
        }

        for ($i = 0; $i < count($id_val); $i++) {
            if ($lft[$i] == max($lft) && $rgt[$i] == min($rgt)) {
                $row[] = $id_val[$i];
            }
        }
        return $row;
    }

    public function getChildrenIds($tbl, $col, $left, $right) {
        $query = mysql_query("select $col from $tbl where `left`>$left and `right`<$right");
        $row = array();
        while ($res = mysql_fetch_array($query)) {
            $row[] = array($res[$col]);
        }
        return $row;
    }

    public function getImmediateChildId($tbl, $col, $left, $right) {
        $query = mysql_query("select `$col`,`left`,`right` from `$tbl` where `left`>$left and `right`<$right");
        $row = array();
        while ($res = mysql_fetch_array($query)) {
            $lft[] = $res['left'];
            $rgt[] = $res['right'];
            $id_val[] = $res[$col];
        }

        for ($i = 0; $i < count($id_val); $i++) {
            if (($rgt[$i] - $lft[$i]) == 1) {
                $row[] = $id_val[$i];
            }
        }
        return $row;
    }

}