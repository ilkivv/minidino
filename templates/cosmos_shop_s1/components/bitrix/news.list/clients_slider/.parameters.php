<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters["ELEMENT_LINE_COUNTER"] = array(
        "NAME" => GetMessage("MD_NL_ELEMENT_LINE_COUNTER"),
        "TYPE" => "STRING",
        "DEFAULT" =>"6",
        "PARENT" => "BASE",
);

$arTemplateParameters["NL_USE_IMAGE_RESIZE"] = array(
        "NAME" => GetMessage("MD_NL_USE_IMAGE_RESIZE"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "VALUE" => "Y",
        "DEFAULT" =>"N",
        "REFRESH"=> "Y",
        "PARENT" => "LIST_SETTINGS",
);

if ($arCurrentValues["NL_USE_IMAGE_RESIZE"] == "Y")
{
    $arTemplateParameters["NL_IMAGE_RESIZE_WIDTH"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("MD_NL_IMAGE_RESIZE_WIDTH"),
        "TYPE" => "STRING",
        "DEFAULT" => "200",
    );
    $arTemplateParameters["NL_IMAGE_RESIZE_HEIGHT"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("MD_NL_IMAGE_RESIZE_HEIGHT"),
        "TYPE" => "STRING",
        "DEFAULT" => "200",
    );
    $arItemSizes = array(
        BX_RESIZE_IMAGE_PROPORTIONAL => GetMessage("MD_NL_IMAGE_RESIZE_TYPE_PROPORTIONAL"),
        BX_RESIZE_IMAGE_EXACT => GetMessage("MD_NL_IMAGE_RESIZE_TYPE_EXACT"),
    );
    $arTemplateParameters["NL_IMAGE_RESIZE_TYPE"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("MD_NL_IMAGE_RESIZE_TYPE"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "ADDITIONAL_VALUES" => "N",
        "REFRESH" => "N",
        "DEFAULT" => BX_RESIZE_IMAGE_PROPORTIONAL,
        "VALUES" => $arItemSizes
    );

}
?>