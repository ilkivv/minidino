<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "CALENDAR_PATH_TO_BACKGROUND" => Array(
        "NAME" => GetMessage("CALENDAR_PATH_TO_BACKGROUND_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => SITE_DIR . "include/back/city.jpg",
    ),
);
?>