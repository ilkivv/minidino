<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"MSG_ASK_QUESTION" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION_DEF"),
	),
	"MSG_ASK_QUESTION_UNDER" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION_UNDER"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ASK_QUESTION_UNDER_DEF"),
	),
	"MSG_ZAKAZ" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_DEF"),
	),
	"MSG_ZAKAZ_TITLE" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_TITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_TITLE_DEF"),
	),
	"MSG_ZAKAZ_UNDER" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_UNDER"),
		"TYPE" => "STRING",
		"DEFAULT" => Loc::getMessage("T_IBLOCK_MSG_ZAKAZ_UNDER_DEF"),
	),
	"LINK_TO_AJAX" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_LINK_TO_AJAX"),
		"TYPE" => "STRING",
		"DEFAULT" => SITE_DIR . "ajax/formserv.php",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => Array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
	"NL_USE_IMAGE_RESIZE" => Array(
		"NAME" => Loc::getMessage("MD_IBLOCK_USE_IMAGE_RESIZE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"Y",
		"REFRESH"=> "Y",
		"PARENT" => "LIST_SETTINGS",
	),
);


if ($arCurrentValues["NL_USE_IMAGE_RESIZE"] == "Y")
{
	$arTemplateParameters["NL_IMAGE_RESIZE_WIDTH"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_IBLOCK_IMAGE_RESIZE_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "300",
	);
	$arTemplateParameters["NL_IMAGE_RESIZE_HEIGHT"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => Loc::getMessage("MD_IBLOCK_IMAGE_RESIZE_HEIGHT"),
		"TYPE" => "STRING",
		"DEFAULT" => "300",
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
		"VALUES" => $arItemSizes
	);

}


if ($arCurrentValues["USE_SHARE"] == "Y")
{
	$arTemplateParameters["SHARE_HIDE"] = array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
		"TYPE" => "CHECKBOX",
		"VALUE" => "Y",
		"DEFAULT" => "N",
	);

	$arTemplateParameters["SHARE_TEMPLATE"] = array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
		"DEFAULT" => "",
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"REFRESH"=> "Y",
	);
	
	if (strlen(trim($arCurrentValues["SHARE_TEMPLATE"])) <= 0)
		$shareComponentTemlate = false;
	else
		$shareComponentTemlate = trim($arCurrentValues["SHARE_TEMPLATE"]);

	include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/bitrix/main.share/util.php");

	$arHandlers = __bx_share_get_handlers($shareComponentTemlate);

	$arTemplateParameters["SHARE_HANDLERS"] = array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arHandlers["HANDLERS"],
		"DEFAULT" => $arHandlers["HANDLERS_DEFAULT"],
	);

	$arTemplateParameters["SHARE_SHORTEN_URL_LOGIN"] = array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_LOGIN"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
	
	$arTemplateParameters["SHARE_SHORTEN_URL_KEY"] = array(
		"NAME" => Loc::getMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_KEY"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

?>