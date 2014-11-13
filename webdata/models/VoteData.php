<?php

class VoteData extends Pix_Table
{
    public function init()
    {
        $this->_name = 'vote_data';
        $this->_primary = 'id';

        $this->_columns['id'] = array('type' => 'char', 'size' => 13);
        $this->_columns['data'] = array('type' => 'text');
    }

    public static function getVoteIds($type, $value)
    {
        if (!$keys = Vote::getVoteKeys()[$type]) {
            throw new Exception("$type not found");
        }
        $size = array('省市別' => 1, '縣市別' => 2, '選區別' => 2, '鄉鎮市區' => 2, '投開票所編號' => 4, '村里別' => 4);
        $key_pos = array();
        $pos = 2;
        foreach ($keys as $key) {
            if (!$size[$key]) {
                throw new Exception("找不到 $key 的大小");
            }
            $key_pos[$key] = $pos;
            $pos += $size[$key];
        }

        $data = array();
        foreach (VoteData::search("id LIKE '{$type}{$value}%'")->toArray('id') as $id) {
            $d = new StdClass;
            $d->name = '';
            foreach ($key_pos as $key => $pos) {
                $d->{$key} = $v = substr($id, $pos, $size[$key]);
                switch ($key) {
                case '省市別':
                case '縣市別':
                    break;
                case '選區別':
                    $d->name .= "第{$v}選區";
                    break;
                case '鄉鎮市區':
                    $d->name .= Vote::getTownName($d->{'省市別'} . $d->{'縣市別'}, $v);
                    break;
                case '投開票所編號':
                    $d->name .= "{$v}號開票所";
                    break;
                case '村里別':
                    $d->name .= Vote::getVillageName($d->{'省市別'} . $d->{'縣市別'} . $d->{'鄉鎮市區'}, $v);
                    break;
                default:
                    throw new Exception("不知道的 $key");
                    break;
                }
            }
            $d->id = $id;
            $data[] = $d;
        }

        return $data;
    }
}
