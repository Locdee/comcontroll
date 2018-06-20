<?php

if (!function_exists('ajaxResponse')) {
    function ajaxResponse($message = '', $status = 0, $data = [])
    {

        return ['status' => $status, 'message' => $message, 'data' => $data];

    }
}

if (!function_exists('node_merge')) {
    function node_merge($node, $pid = 0)
    {
        $arr = array();
        foreach ($node as $v) {
            if ($v['pid'] == $pid) {
                $v['child'] = node_merge($node, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }
}

if (!function_exists('cate_merge')) {
    function cate_merge($cate, $html = '', $pid = 0, $level = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                if (!isset($v['level'])) {
                    $v['level'] = 0;
                } else {
                    $v['level'] == $level + 1;
                }
                if ($level > 0) {
                    $html = str_repeat(' &nbsp;&nbsp;&nbsp;&nbsp;|', $level - 1);
                    $v['html'] = $html . '—';
                } else {
                    $v['html'] = $html;
                }
                $arr[] = $v;
                $arr = array_merge($arr, cate_merge($cate, $html, $v['id'], $level + 1));
            }
        }
        return $arr;
    }
}

if (!function_exists('setConfig')) {
    function  setConfig($store){
        $temp="<?php \n return [ \n";
        foreach ($store as $key => $value) {
            if(is_numeric($value))
            {
                $temp.="'".$key."'=>".$value.",\n";
            } else if(is_array($value))
            {
                $temp.="'".$key."'=>".var_export($value,true).",\n";
            }else{
                $temp.="'".$key."'=>"."'".$value."',\n";
            }
        }
        $temp.="];\n";
        return $temp;
    }
}
/*
 * rbac判断
 * model:模型名称
 * action：进行的操作 增-create 删-delete 改-update 查-view
 */
if (!function_exists('rbac_determine')) {
    function rbac_determine($model,$action){
        return App\Policies\AdminRbackPolicy::determine($model,$action);
    }
}
