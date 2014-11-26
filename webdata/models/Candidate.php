<?php

class Candidate extends Pix_Table
{
    public function init()
    {
        $this->_name = 'candidate';
        $this->_primary = 'id';

        $this->_columns['id'] = array('type' => 'char', 'size' => 13);
        $this->_columns['data'] = array('type' => 'text');
    }

    public static function findCandidateByVoteId($id)
    {
        if (!$id = self::findIdByVoteId($id)) {
            return null;
        }

        return json_decode(self::find($id)->data);
    }

    public static function findIdByVoteId($id)
    {
        $type = substr($id, 0, 2);
        switch ($type) {
        case 'T1': // 區域縣市議員
        case 'T2': // 平地原住民縣市議員
        case 'T3': // 山地原住民縣市議員
            return sprintf("T1%03d%02d", substr($id, 2, 3), substr($id, 5, 2));

        case 'TC': // 縣市長
            return sprintf("TC%03d", substr($id, 2, 3));

        case 'TD': // 鄉鎮市(原住民區)長
            return sprintf("TD%03d%02d", substr($id, 2, 3), substr($id, 5, 2));

        case 'T4': // 鄉鎮市區民代表
        case 'T5': // 鄉鎮市區民代表
            return sprintf("T4%05d%02d", substr($id, 2, 5), substr($id, 7, 2));

        case 'T6': // 鄉鎮市區民代表
            return sprintf("T6%05d%02d", substr($id, 2, 5), substr($id, 7, 2));

        case 'TV': // 村里長
            return sprintf("TV%09d", substr($id, 2, 9));
        }
    }
}
