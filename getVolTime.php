<?php
/**
 * Created by PhpStorm.
 * User: Azurak
 * Date: 2019/1/2
 * Time: 23:42
 */

require_once "VolTime.php";

if (isset($_POST["name"]) && isset($_POST["id_number"])) {
    $vol = new VolTime($_POST["name"], $_POST["id_number"]);
    if ($data = $vol->getRet())
        echo json_encode($data);
    else
        echo false;
} else
    echo false;
