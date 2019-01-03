<?php
/**
 * Created by PhpStorm.
 * User: Azurak
 * Date: 2019/1/3
 * Time: 0:11
 */

require_once "VolTime.php";

echo "Enter your name:";
$name = trim(fgets(STDIN));
echo "Enter your ID number:";
$id_number = trim(fgets(STDIN));
if (isset($name) && isset($id_number)) {
    $vol = new VolTime($name, $id_number);
    $data=$vol->getRet();
    if($data){
        echo "Name:".$data['user_name']."\n";
        echo "Sex:".$data['user_sex']."\n";
        echo "Code:".$data['vol_code']."\n";
        echo "Total:".$data['hour_total']."\n";
        echo "Previous:".$data['hour_previous']."\n";
        echo "Current".$data['hour_current']."\n";
    }else
        echo "Error!";
}else
    echo "Error!";

