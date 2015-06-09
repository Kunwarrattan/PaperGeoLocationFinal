<?php

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


echo $id." ".$city." ".$state." ".$country;