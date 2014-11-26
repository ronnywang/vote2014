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
        case 'T1':
        case 'T2':
            return sprintf("T1%03d%02d", substr($id, 2, 3), substr($id, 5, 2));
        }
    }
}
