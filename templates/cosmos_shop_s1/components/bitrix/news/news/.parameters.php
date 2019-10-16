<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"NL_USE_IMAGE_RESIZE" => Array(
		"NAME" => GetMessage("MD_NL_USE_IMAGE_RESIZE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
		"PARENT" => "LIST_SETTINGS",
	),
	"USE_SHARE" => Array(
			"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
			"TYPE" => "CHECKBOX",
			"MULTIPLE" => "N",
			"VALUE" => "Y",
			"DEFAULT" =>"N",
			"REFRESH"=> "Y",
	),
);

if ($arCurrentValues["USE_SHARE"] == "Y")
{
	if (strlen(trim($arCurrentValues["SHARE_TEMPLATE"])) <= 0)
		$shareComponentTemlate = false;
	else
		$shareComponentTemlate = trim($arCurrentValues["SHARE_TEMPLATE"]);

	include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/bitrix/main.share/util.php");

	$arHandlers = __bx_share_get_handlers($shareComponentTemlate);

	$arTemplateParameters["SHARE_HANDLERS"] = array(
			"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arHandlers["HANDLERS"],
			"DEFAULT" => $arHandlers["HANDLERS_DEFAULT"],
	);
}

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
if ($arCurrentValues["SHOW_INFOBLOCK_DESCRIPTION"] == "Y")
{
    $arDescrPos = array(
      "top" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_TOP"),
      "bottom" => GetMessage("MD_SHOW_INFOBLOCK_DESCRIPTION_BOTTOM"),
      );
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
?>