<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "NL_USE_IMAGE_RESIZE" => Array(
        "NAME" => GetMessage("MD_NL_USE_IMAGE_RESIZE"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "VALUE" => "Y",
        "DEFAULT" =>"N",
        "REFRESH"=> "Y",
        "PARENT" => "LIST_SETTINGS",
    ),
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
$arTemplateParameters["SHOW_INFOBLOCK_DESCRIPTION"] = Array(
        "NAME" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "VALUE" => "Y",
        "DEFAULT" =>"N",
        "REFRESH"=> "Y",
        "PARENT" => "LIST_SETTINGS",
    );

$arDescrPos = array(
  "top" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_TOP"),
  "bottom" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_BOTTOM"),
  );
if ($arCurrentValues["SHOW_INFOBLOCK_DESCRIPTION"] == "Y")
{
    $arTemplateParameters["SHOW_INFOBLOCK_DESCRIPTION_POSITION"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_POSITION"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "ADDITIONAL_VALUES" => "N",
        "REFRESH" => "N",
        "DEFAULT" => BX_RESIZE_IMAGE_PROPORTIONAL,
        "VALUES" => $arDescrPos
    );
}

$arTemplateParameters["SHOW_SECTION_DESCRIPTION"] = Array(
        "NAME" => GetMessage("MD_SHOW_SECTION_DESCRIPTION"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "VALUE" => "Y",
        "DEFAULT" =>"N",
        "REFRESH"=> "Y",
        "PARENT" => "LIST_SETTINGS",
    );
if ($arCurrentValues["SHOW_INFOBLOCK_DESCRIPTION"] == "Y")
{
    $arTemplateParameters["SHOW_SECTION_DESCRIPTION_POSITION"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_POSITION"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "ADDITIONAL_VALUES" => "N",
        "REFRESH" => "N",
        "DEFAULT" => BX_RESIZE_IMAGE_PROPORTIONAL,
        "VALUES" => $arDescrPos
    );
}
?>