<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function tree_data($tbl, $col, $elem, $parent, $position) {
    $CI = & get_instance();
    $CI->load->model('Tree_hierarchy');
    if ($parent == '') {
        $data3 = $CI->Tree_hierarchy->getElementRgtByLft($tbl);
        if (count($data3) == 0) {
            $data = array(
                $col => $elem,
                'left' => 1,
                'right' => 2
            );
            $insert = $CI->Tree_hierarchy->insert_left_right($tbl, $data);
            return $insert;
        } else {
            foreach ($data3 as $rgt) {
                $result = make_tree_for_insert($CI, $tbl, $col, $elem, 1, $rgt['right'], 'beside');
                return $result;
            }
        }
    } else {
        $data2 = $CI->Tree_hierarchy->getElementLftRgt($tbl, $col, $parent);
        foreach ($data2 as $parent_lft_rgt) {
            $result = make_tree_for_insert($CI, $tbl, $col, $elem, $parent_lft_rgt['left'], $parent_lft_rgt['right'], $position);
        }
        return $result;
    }
}

function make_tree_for_insert($ci, $tbl, $col, $element_id, $ref_lft, $ref_rgt, $position) {
    $res = false;
    if ($position == 'beside') {
        $elem_left = $ref_rgt + 1;
        $elem_right = $ref_rgt + 2;
    }

    if ($position == 'below') {
        $elem_left = $ref_lft + 1;
        $elem_right = $ref_lft + 2;
    }
    
    $data = array(
        $col => $element_id,
        'left' => $elem_left,
        'right' => $elem_right
    );
    
    $data2 = $ci->Tree_hierarchy->update_parent_left_right($tbl, $elem_left, $elem_right);
    $data3 = $ci->Tree_hierarchy->update_left_right($tbl, $elem_left, $elem_right);
    $data1 = $ci->Tree_hierarchy->insert_left_right($tbl, $data);
    if ($data1 && $data2 && $data3) {
        $res = true;
    }
    return true;
}

function tree_get_all_parents($tbl, $col, $id) {
    $CI = & get_instance();
    $CI->load->model('Tree_hierarchy');
    //echo $tbl. $col. $id;
    $data2 = $CI->Tree_hierarchy->getElementLftRgt($tbl, $col, $id);
    foreach ($data2 as $parent_lft_rgt) {
        $result = $CI->Tree_hierarchy->getParentIds($tbl, $col, $parent_lft_rgt['left'], $parent_lft_rgt['right']);
        //var_dump($result);
        return $result;
    }
}

function tree_get_immediate_parent($tbl, $col, $id) {
    $CI = & get_instance();
    $CI->load->model('Tree_hierarchy');
    //echo $tbl. $col. $id;
    $data2 = $CI->Tree_hierarchy->getElementLftRgt($tbl, $col, $id);
    foreach ($data2 as $parent_lft_rgt) {
        $result = $CI->Tree_hierarchy->getImmediateParentId($tbl, $col, $parent_lft_rgt['left'], $parent_lft_rgt['right']);
        return $result;
    }
}

function tree_get_all_children($tbl, $col, $id) {
    $CI = & get_instance();
    $CI->load->model('Tree_hierarchy');
    //echo $tbl. $col. $id;
    $data2 = $CI->Tree_hierarchy->getElementLftRgt($tbl, $col, $id);
    foreach ($data2 as $child_lft_rgt) {
        $result = $CI->Tree_hierarchy->getChildrenIds($tbl, $col, $child_lft_rgt['left'], $child_lft_rgt['right']);
        //var_dump($result);
    }
    return $result;
}


function tree_get_immediate_child($tbl, $col, $id) {
    $CI = & get_instance();
    $CI->load->model('Tree_hierarchy');
    //echo $tbl. $col. $id;
    $data2 = $CI->Tree_hierarchy->getElementLftRgt($tbl, $col, $id);
    foreach ($data2 as $child_lft_rgt) {
        $result = $CI->Tree_hierarchy->getImmediateChildId($tbl, $col, $child_lft_rgt['left'], $child_lft_rgt['right']);
        //var_dump($result);
    }
    return $result;
}