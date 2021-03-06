<?php

class Vote
{
    protected static $pos = 0;

    protected static $parties = null;
    public static function getParties()
    {
        if (is_null(self::$parties)) {
            $fp = fopen(__DIR__ . '/../data/party.csv', 'r');
            self::$parties = array();
            while ($rows = fgetcsv($fp)) {
                self::$parties[] = $rows;
            }
        }
        return self::$parties;
    }

    public static function getVoteKeys()
    {
        return array(
            'T1' => array('省市別', '縣市別', '選區別', '鄉鎮市區', '投開票所編號'),
            'T2' => array('省市別', '縣市別', '選區別', '鄉鎮市區', '投開票所編號'),
            'T3' => array('省市別', '縣市別', '選區別', '鄉鎮市區', '投開票所編號'),
            'T4' => array('省市別', '縣市別', '鄉鎮市區', '選區別', '投開票所編號'),
            'T5' => array('省市別', '縣市別', '鄉鎮市區', '選區別', '投開票所編號'),
            'T6' => array('省市別', '縣市別', '鄉鎮市區', '選區別', '投開票所編號'),
            'TC' => array('省市別', '縣市別', '鄉鎮市區', '投開票所編號'),
            'TD' => array('省市別', '縣市別', '鄉鎮市區', '投開票所編號'),
            'TV' => array('省市別', '縣市別', '鄉鎮市區', '村里別', '投開票所編號'),
            'PT' => array('省市別', '縣市別'),
            'PC' => array('省市別', '縣市別'),
            'PD' => array('省市別', '縣市別'),
            'PR' => array('省市別', '縣市別', '鄉鎮市區'),
            'PV' => array('省市別', '縣市別', '鄉鎮市區'),
            'FT' => array('省市別', '縣市別'),
            'FC' => array('省市別', '縣市別'),
            'FD' => array('省市別', '縣市別'),
            'FR' => array('省市別', '縣市別', '鄉鎮市區'),
            'FV' => array('省市別', '縣市別', '鄉鎮市區'),
        );
    }

    public static function getCounties()
    {
        return array(
            array('0', '00', '全國'),
            array('1', '00', '臺北市'),
            array('2', '00', '新北市'),
            array('3', '00', '桃園市'),
            array('4', '00', '臺中市'),
            array('5', '00', '臺南市'),
            array('6', '00', '高雄市'),
            array('7', '01', '新竹縣'),
            array('7', '02', '苗栗縣'),
            array('7', '03', '彰化縣'),
            array('7', '04', '南投縣'),
            array('7', '05', '雲林縣'),
            array('7', '06', '嘉義縣'),
            array('7', '07', '屏東縣'),
            array('7', '08', '宜蘭縣'),
            array('7', '09', '花蓮縣'),
            array('7', '10', '臺東縣'),
            array('7', '11', '澎湖縣'),
            array('7', '12', '基隆市'),
            array('7', '13', '新竹市'),
            array('7', '14', '嘉義市'),
            array('8', '01', '金門縣'),
            array('8', '02', '連江縣'),
        );

    }

    protected static $village_map = null;
    public static function getVillageName($id, $village_id)
    {
        if (is_null(self::$village_map)) {
            self::$village_map = array();
            $fp = fopen(__DIR__ . '/../data/village.csv', 'r');
            while ($line = fgets($fp)) {
                list($provence_county, $county_name, $town, $town_name, $village_name, $village) = explode(' ', trim($line));
                self::$village_map[$provence_county . $town . $village] = $village_name;
            }
        }

        return self::$village_map[$id . $village_id];
    }

    public static function getTownName($id, $town_id)
    {
        $provence = substr($id, 0, 1);
        $county = substr($id, 1, 2);

        if ($town_id == 0) {
            return '全區';
        }

        foreach (self::getTowns() as $town) {
            if ($town[0] == $provence and $town[1] == $county and $town[2] == $town_id) {
                return $town[3];
            }
        }
    }

    public static function getTowns()
    {
        return array(
            array('1', '00', '01', '北投區'),
            array('1', '00', '02', '士林區'),
            array('1', '00', '03', '內湖區'),
            array('1', '00', '04', '南港區'),
            array('1', '00', '05', '松山區'),
            array('1', '00', '06', '信義區'),
            array('1', '00', '07', '中山區'),
            array('1', '00', '08', '大同區'),
            array('1', '00', '09', '中正區'),
            array('1', '00', '10', '萬華區'),
            array('1', '00', '11', '大安區'),
            array('1', '00', '12', '文山區'),
            array('2', '00', '01', '石門區'),
            array('2', '00', '02', '三芝區'),
            array('2', '00', '03', '淡水區'),
            array('2', '00', '04', '八里區'),
            array('2', '00', '05', '林口區'),
            array('2', '00', '06', '五股區'),
            array('2', '00', '07', '泰山區'),
            array('2', '00', '08', '新莊區'),
            array('2', '00', '09', '蘆洲區'),
            array('2', '00', '10', '三重區'),
            array('2', '00', '11', '板橋區'),
            array('2', '00', '12', '中和區'),
            array('2', '00', '13', '永和區'),
            array('2', '00', '14', '樹林區'),
            array('2', '00', '15', '鶯歌區'),
            array('2', '00', '16', '土城區'),
            array('2', '00', '17', '三峽區'),
            array('2', '00', '18', '新店區'),
            array('2', '00', '19', '深坑區'),
            array('2', '00', '20', '石碇區'),
            array('2', '00', '21', '坪林區'),
            array('2', '00', '22', '烏來區'),
            array('2', '00', '23', '平溪區'),
            array('2', '00', '24', '瑞芳區'),
            array('2', '00', '25', '雙溪區'),
            array('2', '00', '26', '貢寮區'),
            array('2', '00', '27', '金山區'),
            array('2', '00', '28', '萬里區'),
            array('2', '00', '29', '汐止區'),
            array('3', '00', '01', '桃園區'),
            array('3', '00', '02', '龜山區'),
            array('3', '00', '03', '八德區'),
            array('3', '00', '04', '蘆竹區'),
            array('3', '00', '05', '大園區'),
            array('3', '00', '06', '大溪區'),
            array('3', '00', '07', '復興區'),
            array('3', '00', '08', '中壢區'),
            array('3', '00', '09', '平鎮區'),
            array('3', '00', '10', '楊梅區'),
            array('3', '00', '11', '龍潭區'),
            array('3', '00', '12', '新屋區'),
            array('3', '00', '13', '觀音區'),
            array('4', '00', '01', '大甲區'),
            array('4', '00', '02', '大安區'),
            array('4', '00', '03', '外埔區'),
            array('4', '00', '04', '清水區'),
            array('4', '00', '05', '梧棲區'),
            array('4', '00', '06', '沙鹿區'),
            array('4', '00', '07', '龍井區'),
            array('4', '00', '08', '大肚區'),
            array('4', '00', '09', '烏日區'),
            array('4', '00', '10', '后里區'),
            array('4', '00', '11', '豐原區'),
            array('4', '00', '12', '神岡區'),
            array('4', '00', '13', '大雅區'),
            array('4', '00', '14', '潭子區'),
            array('4', '00', '15', '西屯區'),
            array('4', '00', '16', '南屯區'),
            array('4', '00', '17', '北屯區'),
            array('4', '00', '18', '北區'),
            array('4', '00', '19', '中區'),
            array('4', '00', '20', '西區'),
            array('4', '00', '21', '東區'),
            array('4', '00', '22', '南區'),
            array('4', '00', '23', '太平區'),
            array('4', '00', '24', '大里區'),
            array('4', '00', '25', '霧峰區'),
            array('4', '00', '26', '東勢區'),
            array('4', '00', '27', '石岡區'),
            array('4', '00', '28', '新社區'),
            array('4', '00', '29', '和平區'),
            array('5', '00', '01', '後壁區'),
            array('5', '00', '02', '白河區'),
            array('5', '00', '03', '東山區'),
            array('5', '00', '04', '鹽水區'),
            array('5', '00', '05', '新營區'),
            array('5', '00', '06', '柳營區'),
            array('5', '00', '07', '北門區'),
            array('5', '00', '08', '學甲區'),
            array('5', '00', '09', '將軍區'),
            array('5', '00', '10', '下營區'),
            array('5', '00', '11', '六甲區'),
            array('5', '00', '12', '麻豆區'),
            array('5', '00', '13', '官田區'),
            array('5', '00', '14', '七股區'),
            array('5', '00', '15', '佳里區'),
            array('5', '00', '16', '西港區'),
            array('5', '00', '17', '善化區'),
            array('5', '00', '18', '安定區'),
            array('5', '00', '19', '大內區'),
            array('5', '00', '20', '山上區'),
            array('5', '00', '21', '新化區'),
            array('5', '00', '22', '楠西區'),
            array('5', '00', '23', '南化區'),
            array('5', '00', '24', '玉井區'),
            array('5', '00', '25', '左鎮區'),
            array('5', '00', '26', '新市區'),
            array('5', '00', '27', '永康區'),
            array('5', '00', '28', '安南區'),
            array('5', '00', '29', '北區'),
            array('5', '00', '30', '中西區'),
            array('5', '00', '31', '安平區'),
            array('5', '00', '32', '東區'),
            array('5', '00', '33', '南區'),
            array('5', '00', '34', '仁德區'),
            array('5', '00', '35', '歸仁區'),
            array('5', '00', '36', '關廟區'),
            array('5', '00', '37', '龍崎區'),
            array('6', '00', '01', '桃源區'),
            array('6', '00', '02', '那瑪夏區'),
            array('6', '00', '03', '甲仙區'),
            array('6', '00', '04', '六龜區'),
            array('6', '00', '05', '杉林區'),
            array('6', '00', '06', '內門區'),
            array('6', '00', '07', '旗山區'),
            array('6', '00', '08', '美濃區'),
            array('6', '00', '09', '茂林區'),
            array('6', '00', '10', '茄萣區'),
            array('6', '00', '11', '湖內區'),
            array('6', '00', '12', '路竹區'),
            array('6', '00', '13', '阿蓮區'),
            array('6', '00', '14', '田寮區'),
            array('6', '00', '15', '永安區'),
            array('6', '00', '16', '岡山區'),
            array('6', '00', '17', '燕巢區'),
            array('6', '00', '18', '彌陀區'),
            array('6', '00', '19', '梓官區'),
            array('6', '00', '20', '橋頭區'),
            array('6', '00', '21', '楠梓區'),
            array('6', '00', '22', '左營區'),
            array('6', '00', '23', '大社區'),
            array('6', '00', '24', '仁武區'),
            array('6', '00', '25', '鳥松區'),
            array('6', '00', '26', '大樹區'),
            array('6', '00', '27', '鼓山區'),
            array('6', '00', '28', '鹽埕區'),
            array('6', '00', '29', '旗津區'),
            array('6', '00', '30', '三民區'),
            array('6', '00', '31', '前金區'),
            array('6', '00', '32', '新興區'),
            array('6', '00', '33', '苓雅區'),
            array('6', '00', '34', '鳳山區'),
            array('6', '00', '35', '前鎮區'),
            array('6', '00', '36', '小港區'),
            array('6', '00', '37', '大寮區'),
            array('6', '00', '38', '林園區'),
            array('7', '01', '01', '竹北市'),
            array('7', '01', '02', '竹東鎮'),
            array('7', '01', '03', '新埔鎮'),
            array('7', '01', '04', '關西鎮'),
            array('7', '01', '05', '湖口鄉'),
            array('7', '01', '06', '新豐鄉'),
            array('7', '01', '07', '芎林鄉'),
            array('7', '01', '08', '橫山鄉'),
            array('7', '01', '09', '北埔鄉'),
            array('7', '01', '10', '寶山鄉'),
            array('7', '01', '11', '峨眉鄉'),
            array('7', '01', '12', '尖石鄉'),
            array('7', '01', '13', '五峰鄉'),
            array('7', '02', '01', '苗栗市'),
            array('7', '02', '02', '公館鄉'),
            array('7', '02', '03', '頭屋鄉'),
            array('7', '02', '04', '銅鑼鄉'),
            array('7', '02', '05', '三義鄉'),
            array('7', '02', '06', '西湖鄉'),
            array('7', '02', '07', '通霄鎮'),
            array('7', '02', '08', '苑裡鎮'),
            array('7', '02', '09', '後龍鎮'),
            array('7', '02', '10', '造橋鄉'),
            array('7', '02', '11', '竹南鎮'),
            array('7', '02', '12', '頭份鎮'),
            array('7', '02', '13', '三灣鄉'),
            array('7', '02', '14', '南庄鄉'),
            array('7', '02', '15', '大湖鄉'),
            array('7', '02', '16', '獅潭鄉'),
            array('7', '02', '17', '卓蘭鎮'),
            array('7', '02', '18', '泰安鄉'),
            array('7', '03', '01', '彰化市'),
            array('7', '03', '02', '花壇鄉'),
            array('7', '03', '03', '芬園鄉'),
            array('7', '03', '04', '鹿港鎮'),
            array('7', '03', '05', '福興鄉'),
            array('7', '03', '06', '秀水鄉'),
            array('7', '03', '07', '和美鎮'),
            array('7', '03', '08', '伸港鄉'),
            array('7', '03', '09', '線西鄉'),
            array('7', '03', '10', '員林鎮'),
            array('7', '03', '11', '大村鄉'),
            array('7', '03', '12', '永靖鄉'),
            array('7', '03', '13', '溪湖鎮'),
            array('7', '03', '14', '埔鹽鄉'),
            array('7', '03', '15', '埔心鄉'),
            array('7', '03', '16', '田中鎮'),
            array('7', '03', '17', '社頭鄉'),
            array('7', '03', '18', '二水鄉'),
            array('7', '03', '19', '北斗鎮'),
            array('7', '03', '20', '田尾鄉'),
            array('7', '03', '21', '埤頭鄉'),
            array('7', '03', '22', '溪州鄉'),
            array('7', '03', '23', '二林鎮'),
            array('7', '03', '24', '大城鄉'),
            array('7', '03', '25', '芳苑鄉'),
            array('7', '03', '26', '竹塘鄉'),
            array('7', '04', '01', '南投市'),
            array('7', '04', '02', '埔里鎮'),
            array('7', '04', '03', '草屯鎮'),
            array('7', '04', '04', '竹山鎮'),
            array('7', '04', '05', '集集鎮'),
            array('7', '04', '06', '名間鄉'),
            array('7', '04', '07', '鹿谷鄉'),
            array('7', '04', '08', '中寮鄉'),
            array('7', '04', '09', '魚池鄉'),
            array('7', '04', '10', '國姓鄉'),
            array('7', '04', '11', '水里鄉'),
            array('7', '04', '12', '信義鄉'),
            array('7', '04', '13', '仁愛鄉'),
            array('7', '05', '01', '麥寮鄉'),
            array('7', '05', '02', '臺西鄉'),
            array('7', '05', '03', '東勢鄉'),
            array('7', '05', '04', '褒忠鄉'),
            array('7', '05', '05', '土庫鎮'),
            array('7', '05', '06', '虎尾鎮'),
            array('7', '05', '07', '四湖鄉'),
            array('7', '05', '08', '元長鄉'),
            array('7', '05', '09', '口湖鄉'),
            array('7', '05', '10', '水林鄉'),
            array('7', '05', '11', '北港鎮'),
            array('7', '05', '12', '崙背鄉'),
            array('7', '05', '13', '二崙鄉'),
            array('7', '05', '14', '西螺鎮'),
            array('7', '05', '15', '莿桐鄉'),
            array('7', '05', '16', '林內鄉'),
            array('7', '05', '17', '斗六市'),
            array('7', '05', '18', '大埤鄉'),
            array('7', '05', '19', '斗南鎮'),
            array('7', '05', '20', '古坑鄉'),
            array('7', '06', '01', '太保市'),
            array('7', '06', '02', '鹿草鄉'),
            array('7', '06', '03', '水上鄉'),
            array('7', '06', '04', '民雄鄉'),
            array('7', '06', '05', '新港鄉'),
            array('7', '06', '06', '大林鎮'),
            array('7', '06', '07', '溪口鄉'),
            array('7', '06', '08', '梅山鄉'),
            array('7', '06', '09', '朴子市'),
            array('7', '06', '10', '六腳鄉'),
            array('7', '06', '11', '東石鄉'),
            array('7', '06', '12', '布袋鎮'),
            array('7', '06', '13', '義竹鄉'),
            array('7', '06', '14', '中埔鄉'),
            array('7', '06', '15', '竹崎鄉'),
            array('7', '06', '16', '番路鄉'),
            array('7', '06', '17', '大埔鄉'),
            array('7', '06', '18', '阿里山鄉'),
            array('7', '07', '01', '屏東市'),
            array('7', '07', '02', '潮州鎮'),
            array('7', '07', '03', '東港鎮'),
            array('7', '07', '04', '恆春鎮'),
            array('7', '07', '05', '萬丹鄉'),
            array('7', '07', '06', '長治鄉'),
            array('7', '07', '07', '麟洛鄉'),
            array('7', '07', '08', '九如鄉'),
            array('7', '07', '09', '里港鄉'),
            array('7', '07', '10', '鹽埔鄉'),
            array('7', '07', '11', '高樹鄉'),
            array('7', '07', '12', '萬巒鄉'),
            array('7', '07', '13', '內埔鄉'),
            array('7', '07', '14', '竹田鄉'),
            array('7', '07', '15', '新埤鄉'),
            array('7', '07', '16', '枋寮鄉'),
            array('7', '07', '17', '新園鄉'),
            array('7', '07', '18', '崁頂鄉'),
            array('7', '07', '19', '林邊鄉'),
            array('7', '07', '20', '南州鄉'),
            array('7', '07', '21', '佳冬鄉'),
            array('7', '07', '22', '琉球鄉'),
            array('7', '07', '23', '車城鄉'),
            array('7', '07', '24', '滿州鄉'),
            array('7', '07', '25', '枋山鄉'),
            array('7', '07', '26', '三地門鄉'),
            array('7', '07', '27', '霧臺鄉'),
            array('7', '07', '28', '瑪家鄉'),
            array('7', '07', '29', '泰武鄉'),
            array('7', '07', '30', '來義鄉'),
            array('7', '07', '31', '春日鄉'),
            array('7', '07', '32', '獅子鄉'),
            array('7', '07', '33', '牡丹鄉'),
            array('7', '08', '01', '宜蘭市'),
            array('7', '08', '02', '羅東鎮'),
            array('7', '08', '03', '蘇澳鎮'),
            array('7', '08', '04', '頭城鎮'),
            array('7', '08', '05', '礁溪鄉'),
            array('7', '08', '06', '壯圍鄉'),
            array('7', '08', '07', '員山鄉'),
            array('7', '08', '08', '冬山鄉'),
            array('7', '08', '09', '五結鄉'),
            array('7', '08', '10', '三星鄉'),
            array('7', '08', '11', '大同鄉'),
            array('7', '08', '12', '南澳鄉'),
            array('7', '09', '01', '花蓮市'),
            array('7', '09', '02', '新城鄉'),
            array('7', '09', '03', '秀林鄉'),
            array('7', '09', '04', '吉安鄉'),
            array('7', '09', '05', '壽豐鄉'),
            array('7', '09', '06', '鳳林鎮'),
            array('7', '09', '07', '光復鄉'),
            array('7', '09', '08', '豐濱鄉'),
            array('7', '09', '09', '萬榮鄉'),
            array('7', '09', '10', '瑞穗鄉'),
            array('7', '09', '11', '玉里鎮'),
            array('7', '09', '12', '富里鄉'),
            array('7', '09', '13', '卓溪鄉'),
            array('7', '10', '01', '臺東市'),
            array('7', '10', '02', '成功鎮'),
            array('7', '10', '03', '關山鎮'),
            array('7', '10', '04', '卑南鄉'),
            array('7', '10', '05', '鹿野鄉'),
            array('7', '10', '06', '池上鄉'),
            array('7', '10', '07', '東河鄉'),
            array('7', '10', '08', '長濱鄉'),
            array('7', '10', '09', '太麻里鄉'),
            array('7', '10', '10', '大武鄉'),
            array('7', '10', '11', '綠島鄉'),
            array('7', '10', '12', '海端鄉'),
            array('7', '10', '13', '延平鄉'),
            array('7', '10', '14', '金峰鄉'),
            array('7', '10', '15', '達仁鄉'),
            array('7', '10', '16', '蘭嶼鄉'),
            array('7', '11', '01', '馬公市'),
            array('7', '11', '02', '湖西鄉'),
            array('7', '11', '03', '白沙鄉'),
            array('7', '11', '04', '西嶼鄉'),
            array('7', '11', '05', '望安鄉'),
            array('7', '11', '06', '七美鄉'),
            array('7', '12', '01', '中正區'),
            array('7', '12', '02', '信義區'),
            array('7', '12', '03', '仁愛區'),
            array('7', '12', '04', '中山區'),
            array('7', '12', '05', '安樂區'),
            array('7', '12', '06', '暖暖區'),
            array('7', '12', '07', '七堵區'),
            array('7', '13', '01', '東區'),
            array('7', '13', '02', '北區'),
            array('7', '13', '03', '香山區'),
            array('7', '14', '01', '東區'),
            array('7', '14', '02', '西區'),
            array('8', '01', '01', '金城鎮'),
            array('8', '01', '02', '金寧鄉'),
            array('8', '01', '03', '烈嶼鄉'),
            array('8', '01', '04', '烏坵鄉'),
            array('8', '01', '05', '金湖鎮'),
            array('8', '01', '06', '金沙鎮'),
            array('8', '02', '01', '南竿鄉'),
            array('8', '02', '02', '北竿鄉'),
            array('8', '02', '03', '莒光鄉'),
            array('8', '02', '04', '東引鄉'),
        );
    }

    public static function getVoteTypes()
    {
        return array(
            'T1' => '開票結果及選舉概況-區域縣市議員',
            'T2' => '開票結果及選舉概況-平地原住民縣市議員',
            'T3' => '開票結果及選舉概況-山地原住民縣市議員',
            'TC' => '開票結果及選舉概況-縣市長',
            'TD' => '開票結果及選舉概況-鄉鎮市(原住民區)長',
            'T4' => '開票結果及選舉概況-鄉鎮市區民代表',
            'T5' => '開票結果及選舉概況-鄉鎮市平地原住民代表',
            'T6' => '開票結果及選舉概況-原住民區民代表',
            'TV' => '開票結果及選舉概況-村里長',
            'PT' => '政黨得票率-縣市議員',
            'PC' => '政黨得票率-縣市長',
            'PD' => '政黨得票率-鄉鎮市(原住民區)長',
            'PR' => '政黨得票率-鄉鎮市(原住民區民)代表',
            'PV' => '政黨得票率-村里長',
            'FT' => '當選人分析-縣市議員',
            'FC' => '當選人分析-縣市長',
            'FD' => '當選人分析-鄉鎮市(原住民區)長',
            'FR' => '當選人分析-鄉鎮市(原住民區民)代表',
            'FV' => '當選人分析-村里長',
        );
    }

    public static function strShift($data, $size)
    {
        $type = substr($data, self::$pos, $size);
        self::$pos += $size;
        return $type;
    }

    public function parseData($data, $cb)
    {
        $data = preg_replace("#\s+#", "", $data);
        self::$pos = 0;

        $columns = array(
            'T1' => array('省市別' => 1, '縣市別' => 2, '選區別' => 2, '鄉鎮市區' => 2, '投開票所編號' => 4),
            'T2' => array('省市別' => 1, '縣市別' => 2, '選區別' => 2, '鄉鎮市區' => 2, '投開票所編號' => 4),
            'T3' => array('省市別' => 1, '縣市別' => 2, '選區別' => 2, '鄉鎮市區' => 2, '投開票所編號' => 4),
            'T4' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '選區別' => 2, '投開票所編號' => 4),
            'T5' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '選區別' => 2, '投開票所編號' => 4),
            'T6' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '選區別' => 2, '投開票所編號' => 4),
            'TC' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '投開票所編號' => 4),
            'TD' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '投開票所編號' => 4),
            'TV' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '村里別' => 4, '投開票所編號' => 4),
            'PT' => array('省市別' => 1, '縣市別' => 2, '政黨總得票數' => 8, '政黨總得票率' => 7, '政黨數' => 2),
            'PC' => array('省市別' => 1, '縣市別' => 2, '政黨總得票數' => 8, '政黨總得票率' => 7, '政黨數' => 2),
            'PD' => array('省市別' => 1, '縣市別' => 2, '政黨總得票數' => 8, '政黨總得票率' => 7, '政黨數' => 2),
            'PR' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '政黨總得票數' => 8, '政黨總得票率' => 7, '政黨數' => 2),
            'PV' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2, '政黨總得票數' => 8, '政黨總得票率' => 7, '政黨數' => 2),
            'FT' => array('省市別' => 1, '縣市別' => 2),
            'FC' => array('省市別' => 1, '縣市別' => 2),
            'FD' => array('省市別' => 1, '縣市別' => 2),
            'FR' => array('省市別' => 1, '縣市別' => 2),
            'FV' => array('省市別' => 1, '縣市別' => 2, '鄉鎮市區' => 2),
        );
        $vote_persons = array(
            'T1' => 30,
            'T2' => 20,
            'T3' => 20,
            'TC' => 10,
            'TD' => 10,
            'T4' => 20,
            'T5' => 20,
            'T6' => 10,
            'TV' => 10,
            'PT' => 25,
            'PC' => 25,
            'PD' => 25,
            'PR' => 25,
            'PV' => 25,
        );

        while (true) {
            $type = self::strShift($data, 2);
            if ($type == '') {
                break;
            }

            switch ($type) {
            case 'ST':
                $time = self::strShift($data, 10);
                list($mm, $dd, $hh, $ii, $ss) = str_split($time, 2);
                if (!$cb('time', mktime($hh, $ii, $ss, $mm, $dd))) {
                    return;
                }
                break;
            case 'T1':
            case 'T2':
            case 'T3':
            case 'TC':
            case 'TD':
            case 'T4':
            case 'T5':
            case 'T6':
            case 'TV':
                $d = new StdClass;
                $d->{'投票種類'} = $type;
                foreach ($columns[$type] as $col => $size) {
                    $d->{$col} = self::strShift($data, $size);
                }

                $d->rows = array();
                for ($i = 0; $i < $vote_persons[$type]; $i ++) {
                    $row = new StdClass;
                    $row->{'候選人得票數'} = intval(self::strShift($data, 8));
                    $mark = self::strShift($data, 1);
                    if (in_array($mark, array('*', '!', '-', '<', '?'))) {
                        $row->{'當選註記'} = $mark;
                        $row->{'得票率'} = floatval(self::strShift($data, 5) / 100);
                    } elseif (preg_match('#[0-9]#', $mark)) {
                        $row->{'得票率'} = floatval($mark . self::strShift($data, 4) / 100);
                    } else {
                        throw new exception("Unknown mark {$mark}");
                    }
                    $d->rows[] = $row;
                }
                $d->{'有效票數'} = intval(self::strShift($data, 8));
                $d->{'無效票數'} = intval(self::strShift($data, 8));
                $d->{'投票數'} = intval(self::strShift($data, 8));
                $d->{'已領未投票數'} = intval(self::strShift($data, 8));
                $d->{'發出票數'} = intval(self::strShift($data, 8));
                $d->{'用餘票數'} = intval(self::strShift($data, 8));
                $d->{'選舉人數'} = intval(self::strShift($data, 8));
                $d->{'投票率'} = floatval(self::strShift($data, 5) / 100);
                if (!in_array($type, array('TD', 'T4', 'T5', 'T6', 'TV'))) {
                    $d->{'應送達鄉鎮市區數'} = intval(self::strShift($data, 3));
                    $d->{'已送達鄉鎮市區數'} = intval(self::strShift($data, 3));
                }
                $d->{'應送投開票所數'} = intval(self::strShift($data, 5));
                $d->{'已送投開票所數'} = intval(self::strShift($data, 5));
                $cb('data', $d);
                break;

            case 'PT':
            case 'PC':
            case 'PD':
            case 'PR':
            case 'PV':
                $d = new StdClass;
                $d->{'投票種類'} = $type;
                foreach ($columns[$type] as $col => $size) {
                    $d->{$col} = self::strShift($data, $size);
                }

                $d->rows = array();
                for ($i = 0; $i < $vote_persons[$type]; $i ++) {
                    $row = new StdClass;
                    $row->{'政黨代碼'} = intval(self::strShift($data, 2));
                    $row->{'得票數'} = intval(self::strShift($data, 8));
                    $row->{'得票率'} = floatval(self::strShift($data, 7) / 100);
                    $d->rows[] = $row;
                }
                $cb('data', $d);
                break;

            case 'SZ':
                $sign = self::strShift($data, 128);
                break;

            case 'FT':
            case 'FC':
            case 'FD':
            case 'FR':
            case 'FV':
                $d = new StdClass;
                $d->{'投票種類'} = $type;
                foreach ($columns[$type] as $col => $size) {
                    $d->{$col} = self::strShift($data, $size);
                }

                $types = array(
                    '性別-男',
                    '性別-女',
                    '教育程度-博士',
                    '教育程度-碩士',
                    '教育程度-大學',
                    '教育程度-專科',
                    '教育程度-高中',
                    '教育程度-其他',
                );

                $d->{'平均年齡'} = floatval(self::strShift($data, 5) / 100);
                foreach ($types as $name) {
                    list($type, $value) = explode('-', $name);
                    if (!$d->{$type}) {
                        $d->{$type} = new StdClass;
                    }
                    $d->{$type}->{$value} = new StdClass;
                    $d->{$type}->{$value}->{'人數'} = intval(self::strShift($data, 4));
                    $d->{$type}->{$value}->{'比率'} = floatval(self::strShift($data, 5) / 100);
                }

                $d->{'政黨數'} = intval(self::strShift($data, 2));

                $d->{'黨籍資料'} = array();
                for ($i = 0; $i < 25; $i ++) {
                    $row = new StdClass;
                    $row->{'政黨代碼'} = intval(self::strShift($data, 2));
                    $row->{'當選名額'} = intval(self::strShift($data, 4));
                    $row->{'當選比率'} = floatval(self::strShift($data, 5) / 100);
                    $d->{'黨籍資料'}[] = $row;
                }

                $cb('data', $d);
                break;

            default:
                var_dump($d);
                throw new Exception("Unknown $type on " . self::$pos);
            }
        }
    }

    public function updateData($file, $time_key)
    {
        $curl = curl_init('http://download.vote2014.nat.gov.tw/' . $file . '.dat');
        curl_setopt($curl, CURLOPT_USERPWD, getenv('USER') . ':' . getenv('PASSWORD'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($curl);
        $info = curl_getinfo($curl);
        if ($info["http_code"] != 200) {
            throw new Exception("update data failed");
        }
        curl_close($curl);
        error_log('parse start');

        $insert_data = array();
        $data_time = null;
        Vote::parseData($content, function($k, $v) use (&$insert_data, &$data_time, $time_key) {
            if ($k == 'time') {
                if ($v == VoteData::find($time_key)->data) {
                    error_log("資料未變 {$v}");
                    return false;
                }
                $data_time = $v;
                return true;
            }
            $id = $v->{'投票種類'};
            foreach (Vote::getVoteKeys()[$id] as $col) {
                $id .= $v->{$col};
            }
            $insert_data[] = sprintf("('%s', '%s', %d)", addslashes($id), addslashes(json_encode($v)), $data_time);
            if (count($insert_data) > 1000) {
                VoteData::getDb()->query("INSERT INTO vote_data (id, data, time) VALUES " . implode(',', $insert_data) . " ON DUPLICATE KEY UPDATE data = VALUES(data), time = VALUES(time)");
                $insert_data = array();
            }

            return true;
        });
        if (getenv('DATA_DIR') and $data_time) {
            file_put_contents(getenv('DATA_DIR') . "/{$file}-{$data_time}", $content);
        }

        if (!$insert_data) {
            return;
        }
        VoteData::getDb()->query("INSERT INTO vote_data (id, data, time) VALUES " . implode(',', $insert_data) . " ON DUPLICATE KEY UPDATE data = VALUES(data), time = VALUES(time)");

        try {
            VoteData::insert(array(
                'id' => $time_key,
                'data' => $data_time,
            ));
        } catch (Pix_Table_DuplicateException $e) {
            VoteData::find($time_key)->update(array('data' => $data_time));
        }
    }
}
