<?php

include(__DIR__ . '/../init.inc.php');

$fp = fopen(__DIR__ . '/../data/village.csv', 'r');
$counties = array();
$towns = array();
$villages = array();
while ($line = fgets($fp)) {
    list($county_id, $county_name, $town_id, $town_name, $village_name, $village_id) = explode(' ', $line);
    $counties[$county_id] = $county_name;
    $counties[$county_name] = $county_id;
    $towns[$county_name . $town_name] = sprintf("%03d%02d", $county_id, $town_id);
    $villages[$county_name . $town_name . $village_name] = sprintf("%03d%02d%04d", $county_id, $town_id, $village_id);
}

// T1 開票結果及選舉概況-區域縣市議員
$fp = fopen(__DIR__ . '/../data/T1.csv', 'r');
$columns = fgetcsv($fp);
array_shift($columns);
$candidates = array();
while ($rows = fgetcsv($fp)) {
    $area = array_shift($rows);
    if (!preg_match('#(...)第([0-9]*)選舉區#u', $area, $matches)) {
        throw new Exception($area);
    }
    if (!$counties[$matches[1]]) {
        throw new Exception($matches[1]);
    }
    $id = sprintf('T1%03d%02d', $counties[$matches[1]], intval($matches[2]));
    if (!$candidates[$id]) {
        $candidates[$id] = array();
    }
    $candidates[$id][] = array_combine($columns, $rows);
}
fclose($fp);
foreach ($candidates as $id => $data) {
    if ($c = Candidate::find($id)) {
        $c->update(array('data' => json_encode($data)));
    } else {
        Candidate::insert(array(
            'id' => $id,
            'data' => json_encode($data),
        ));
    }
}

// TC 縣市長
$fp = fopen(__DIR__ . '/../data/TC.csv', 'r');
$columns = fgetcsv($fp);
array_shift($columns);
$candidates = array();
while ($rows = fgetcsv($fp)) {
    $area = array_shift($rows);
    if (!$counties[$area]) {
        throw new Exception($area);
    }
    $id = sprintf('TC%03d', $counties[$area]);
    if (!$candidates[$id]) {
        $candidates[$id] = array();
    }
    $candidates[$id][] = array_combine($columns, $rows);
}
fclose($fp);
foreach ($candidates as $id => $data) {
    if ($c = Candidate::find($id)) {
        $c->update(array('data' => json_encode($data)));
    } else {
        Candidate::insert(array(
            'id' => $id,
            'data' => json_encode($data),
        ));
    }
}

// TD 鄉鎮市(原住民區)長
$fp = fopen(__DIR__ . '/../data/TD.csv', 'r');
$columns = fgetcsv($fp);
array_shift($columns);
$candidates = array();
while ($rows = fgetcsv($fp)) {
    $area = array_shift($rows);
    if (!$towns[$area]) {
        throw new Exception($area);
    }
    $id = "TD" . $towns[$area];
    if (!$candidates[$id]) {
        $candidates[$id] = array();
    }
    $candidates[$id][] = array_combine($columns, $rows);
}
fclose($fp);
foreach ($candidates as $id => $data) {
    if ($c = Candidate::find($id)) {
        $c->update(array('data' => json_encode($data)));
    } else {
        Candidate::insert(array(
            'id' => $id,
            'data' => json_encode($data),
        ));
    }
}

// T4 鄉鎮市區民代表
$fp = fopen(__DIR__ . '/../data/T4.csv', 'r');
$columns = fgetcsv($fp);
array_shift($columns);
$candidates = array();
while ($rows = fgetcsv($fp)) {
    $area = array_shift($rows);
    if (!preg_match('#(.*)第([0-9]*)選舉區#', $area, $matches)) {
        throw new Exception($area);
    }
    if (!$towns[$matches[1]]) {
        throw new Exception($area);
    }
    $id = sprintf("T4%05d%02d", $towns[$matches[1]], $matches[2]);
    if (!$candidates[$id]) {
        $candidates[$id] = array();
    }
    $candidates[$id][] = array_combine($columns, $rows);
}
fclose($fp);
foreach ($candidates as $id => $data) {
    if ($c = Candidate::find($id)) {
        $c->update(array('data' => json_encode($data)));
    } else {
        Candidate::insert(array(
            'id' => $id,
            'data' => json_encode($data),
        ));
    }
}

// TODO: T5
//
// T6 原住民區民代表
$fp = fopen(__DIR__ . '/../data/T6.csv', 'r');
$columns = fgetcsv($fp);
array_shift($columns);
$candidates = array();
while ($rows = fgetcsv($fp)) {
    $area = array_shift($rows);
    if (!preg_match('#(.*)第([0-9]*)選舉區#', $area, $matches)) {
        throw new Exception($area);
    }
    if (!$towns[$matches[1]]) {
        throw new Exception($area);
    }
    $id = sprintf("T6%05d%02d", $towns[$matches[1]], $matches[2]);
    if (!$candidates[$id]) {
        $candidates[$id] = array();
    }
    $candidates[$id][] = array_combine($columns, $rows);
}
fclose($fp);
foreach ($candidates as $id => $data) {
    if ($c = Candidate::find($id)) {
        $c->update(array('data' => json_encode($data)));
    } else {
        Candidate::insert(array(
            'id' => $id,
            'data' => json_encode($data),
        ));
    }
}

// TV 村里長
$fp = fopen(__DIR__ . '/../data/TV.csv', 'r');
$columns = fgetcsv($fp);
array_shift($columns);
$candidates = array();
while ($rows = fgetcsv($fp)) {
    $area = array_shift($rows);
    if (!$villages[$area]) {
        throw new Exception($area);
    }
    $id = sprintf("TV%09d", $villages[$area]);
    if (!$candidates[$id]) {
        $candidates[$id] = array();
    }
    if (count($columns) != count($rows)) {
        error_log($rows[1]);
    }
    $candidates[$id][] = array_combine($columns, $rows);
}
fclose($fp);
foreach ($candidates as $id => $data) {
    if ($c = Candidate::find($id)) {
        $c->update(array('data' => json_encode($data)));
    } else {
        Candidate::insert(array(
            'id' => $id,
            'data' => json_encode($data),
        ));
    }
}
