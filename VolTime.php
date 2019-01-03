<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2019/1/3
 * Time: 0:53
 */

class VolTime
{
    private $url = 'http://www.zycq.org/app/user/query.php';
    private $name;
    private $id_number;

    public function __construct($name, $id_number)
    {
        $this->name = $name;
        $this->id_number = $id_number;
    }

    public function httpGet()
    {
        $params = ['type' => 'qvol', 'vol_true_name' => $this->name, 'number' => $this->id_number];
        foreach ($params as $param => $val) {
            if ($val == reset($params))
                $this->url .= '?' . $param . '=' . $val;
            else
                $this->url .= '&' . $param . '=' . $val;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resp = curl_exec($ch);
        curl_close($ch);
        return $resp;
    }

    public static function htmlParser($html)
    {
        libxml_use_internal_errors(true);
        $doc = new DOMDocument;
        $doc->loadHTML($html);
        $trimHour = function ($str) {
            return trim(preg_replace('/([\x80-\xff]*)/i', '', $str));
        };
        $result = $doc->getElementsByTagName('td');
        if($result->length!=17)
            return false;
        $hour_total = $trimHour($result->item(13)->nodeValue);
        $hour_previous = $trimHour($result->item(14)->nodeValue);
        $hour_current = $trimHour($result->item(15)->nodeValue);
        $data = [
            "user_name" => $result->item(10)->nodeValue,
            "user_sex" => $result->item(11)->nodeValue,
            "vol_code" => $result->item(12)->nodeValue,
            "hour_total" => $hour_total,
            "hour_previous" => $hour_previous,
            "hour_current" => $hour_current
        ];
        return $data;
    }

    public function getRet()
    {
        return self::htmlParser($this->httpGet());
    }
}
