<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
    "SHOW_INFOBLOCK_DESCRIPTION" => array(
        "NAME" => GetMessage("MD_NL_SHOW_INFOBLOCK_DESCRIPTION"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "VALUE" => "Y",
        "DEFAULT" =>"Y",
        "REFRESH"=> "Y",
    ),
);


if ($arCurrentValues["SHOW_INFOBLOCK_DESCRIPTION"] == "N")
{
    $arTemplateParameters["TITLE_TEXT"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("MD_NL_TITLE_TEXT_TITLE"),
        "TYPE" => "STRING",
        "REFRESH" => "N",
    );
}

?>