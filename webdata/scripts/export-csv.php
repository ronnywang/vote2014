<?php

include(__DIR__ . '/../init.inc.php');
Pix_Table::addStaticResultSetHelper('Pix_Array_Volume');

$columns = null;
$vote_type = null;

function array_walk_new($data, $callback, $prefix = '') {
    foreach ($data as $k => $v) {
        if (is_array($v) or is_object($v)) {
            array_walk_new($v, $callback, trim($prefix . '/' . $k, '/'));
        } else {
            $callback($v, trim($prefix . '/' . $k, '/'));
        }
    }
}

$i = 0;
$total = VoteData::search(1)->count();
foreach (VoteData::search(1)->order('id')->volumemode(100) as $data) {
    $id = $data->id;
    $info = json_decode($data->data);
    if (!$info->{'投票種類'}) {
        continue;
    }
    $i ++;
    error_log("{$i} / {$total}");

    $values = array();
    array_walk_new($info, function($v, $k) use (&$values){ 
        $k = preg_replace('#^rows/#', '', $k);
        if ('投票種類' == $k) {
            return;
        }
        $values[$k] = $v;
    });

    if ($info->{'投票種類'} != $vote_type) {
        $columns = array_keys($values);
        $vote_type = $info->{'投票種類'};
        $fp = fopen(__DIR__ . '/../outputs/' . $vote_type . '.csv', 'w');
        fputcsv($fp, $columns);
    }

    $rows = array();
    foreach ($columns as $k) {
        $rows[] = $values[$k];
    }
    fputcsv($fp, $rows);

    if (is_null($columns)) {

        foreach ($info as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    $columns[] = $k . '/' . $v;
                }
            } else {
                $columns[] = $k;
            }
        }
        exit;
    }


}
