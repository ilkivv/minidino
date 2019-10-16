<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arTemplateParameters = array(
	"NL_USE_IMAGE_RESIZE" => Array(
		"NAME" => Loc::getMessage("MD_IBLOCK_USE_IMAGE_RESIZE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"Y",
		"REFRESH"=> "Y",
		"PARENT" => "DETAIL_SETTINGS",
	),

	"MSG_ASK_QUESTION" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION_DEF"),
		"PARENT" => "DETAIL_SETTINGS",
	),
	"MSG_ASK_QUESTION_UNDER" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION_UNDER"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION_UNDER_DEF"),
		"PARENT" => "DETAIL_SETTINGS",
	),
	"MSG_ZAKAZ" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_DEF"),
		"PARENT" => "DETAIL_SETTINGS",
	),
	"MSG_ZAKAZ_TITLE" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_TITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_TITLE_DEF"),
		"PARENT" => "DETAIL_SETTINGS",
	),
	"MSG_ZAKAZ_UNDER" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_UNDER"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_UNDER_DEF"),
		"PARENT" => "DETAIL_SETTINGS",
	),

);
if ($arCurrentValues["NL_USE_IMAGE_RESIZE"] == "Y")
{
	$arTemplateParameters["NL_IMAGE_RESIZE_WIDTH"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_IBLOCK_IMAGE_RESIZE_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "300",
		"PARENT" => "DETAIL_SETTINGS",
	);
	$arTemplateParameters["NL_IMAGE_RESIZE_HEIGHT"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_IBLOCK_IMAGE_RESIZE_HEIGHT"),
		"TYPE" => "STRING",
		"DEFAULT" => "300",
		"PARENT" => "DETAIL_SETTINGS",
	);
	$arItemSizes = array(
		BX_RESIZE_IMAGE_PROPORTIONAL => Loc::getMessage("MD_IBLOCK_IMAGE_RESIZE_TYPE_PROPORTIONAL"),
		BX_RESIZE_IMAGE_EXACT => Loc::getMessage("MD_IBLOCK_IMAGE_RESIZE_TYPE_EXACT"),
	);
	$arTemplateParameters["NL_IMAGE_RESIZE_TYPE"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_IBLOCK_IMAGE_RESIZE_TYPE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"ADDITIONAL_VALUES" => "N",
		"REFRESH" => "N",
		"DEFAULT" => BX_RESIZE_IMAGE_EXACT,
		"VALUES" => $arItemSizes,
		"PARENT" => "DETAIL_SETTINGS",
	);

}


$arDescrPos = array(
  "top" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_TOP"),
  "bottom" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_BOTTOM"),
  );

$arTemplateParameters["SHOW_SECTION_DESCRIPTION"] = Array(
        "NAME" => GetMessage("MD_SHOW_SECTION_DESCRIPTION"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "VALUE" => "Y",
        "DEFAULT" =>"N",
        "REFRESH"=> "Y",
        "PARENT" => "LIST_SETTINGS",
    );
if ($arCurrentValues["SHOW_SECTION_DESCRIPTION"] == "Y")
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