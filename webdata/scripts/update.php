<?php

include(__DIR__ . '/../init.inc.php');
Pix_Table::$_save_memory = true;
// 如果已經抓過 final 了，就不需要再更新了
if (VoteData::find('final-time')->data) {
    exit;
}
Vote::updateData('running', 'time');
Vote::updateData('final', 'final-time');
