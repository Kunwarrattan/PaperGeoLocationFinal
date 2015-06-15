<?php

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);

$address = null;
$id=null;
$city = null;
$state = null;
$country = null;


if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
{
    $id=($_REQUEST['id']);
}

if(isset($_REQUEST['address']) && $_REQUEST['address']!="")
{
    $address=($_REQUEST['address']);
}

if(isset($_REQUEST['city']) && $_REQUEST['city']!="")
{
    $city=($_REQUEST['city']);
}

if(isset($_REQUEST['state']) && $_REQUEST['state']!="")
{
    $state=($_REQUEST['state']);
}

if(isset($_REQUEST['country']) && $_REQUEST['country']!="")
{
    $country=($_REQUEST['country']);
}



if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'filtereddb')) {
    echo 'Could not select database';
    exit;
}

$queryUpdate ="UPDATE `final_addresses` set `full_address` = \"$address\", `city` = \"$city\" , `province` = \"$state\", `country`= \"$country\" WHERE `id` = $id";
mysqli_set_charset($link, "utf8");
mysqli_query($link, "SET NAMES 'utf8'");
mysqli_query($link, "SET CHARACTER SET 'utf8'");
$result1 = mysqli_query($link, $queryUpdate);
//echo $queryUpdate;
