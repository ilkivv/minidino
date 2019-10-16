<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arServicesViewTypes = array(
	'fbox-center' => GetMessage("MD_NL_ICONS_CENTER"),
	'fbox-nocenter' => GetMessage("MD_NL_ICONS_RIGHT"),
);
$arServicesViewColor = array(
	'fbox-theme' => GetMessage("MD_NL_ICONS_THEME"),
	'fbox-dark' => GetMessage("MD_NL_ICONS_DARK"),
	'fbox-light' => GetMessage("MD_NL_ICONS_LIGHT"),
);
$arServicesViewBorders = array(
	'fbox-plain' => GetMessage("MD_NL_ICONS_PLAIN"),
	'fbox-border' => GetMessage("MD_NL_ICONS_BORDER"),
	'fbox-outline' => GetMessage("MD_NL_ICONS_OUTLINE"),
);

$arTemplateParameters = array(
	"FEATURE_BOX_CLASS" => array(
		//"PARENT"  => "LIST_SETTINGS",
		"NAME"    => GetMessage("MD_NL_FEATURE_BOX_CLASS_TEXT"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"REFRESH" => "N",
		"DEFAULT" => 'fbox-center fbox-plain',
		"VALUES" => $arServicesViewTypes
	),
	"FEATURE_BOX_ICONS" => array(
		"NAME" => GetMessage("MD_NL_FEATURE_BOX_ICONS_TEXT"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
);

if ($arCurrentValues["FEATURE_BOX_ICONS"] == "Y")
{
	$arTemplateParameters["FEATURE_BOX_COLOR"] = array(
		"NAME"    => GetMessage("MD_NL_FEATURE_BOX_CLASS_TEXT"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"DEFAULT" => 'fbox-theme',
		"VALUES" => $arServicesViewColor
	);
	$arTemplateParameters["FEATURE_BOX_EFFECT"] = array(
		"NAME" => GetMessage("MD_NL_FEATURE_BOX_EFFECT_TEXT"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
	);
	$arTemplateParameters["FEATURE_BOX_BORDER"] = array(
		"NAME"    => GetMessage("MD_NL_FEATURE_BOX_BORDER_TEXT"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"REFRESH" => "N",
		"DEFAULT" => '',
		"VALUES" => $arServicesViewBorders
	);
}
?>