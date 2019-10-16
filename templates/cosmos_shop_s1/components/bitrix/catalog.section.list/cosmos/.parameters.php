<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arViewModeList = array(
	'LIST' => GetMessage('CPT_BCSL_VIEW_MODE_LIST'),
	'TILE' => GetMessage('CPT_BCSL_VIEW_MODE_TILE'),
	'BLOCK' => GetMessage('CPT_BCSL_VIEW_MODE_BLOCK'),
);

$arTemplateParameters = array(
	'VIEW_MODE' => array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CPT_BCSL_VIEW_MODE'),
		'TYPE' => 'LIST',
		'VALUES' => $arViewModeList,
		'MULTIPLE' => 'N',
		'DEFAULT' => 'LINE',
		'REFRESH' => 'Y'
	),
	'SHOW_PARENT_NAME' => array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CPT_BCSL_SHOW_PARENT_NAME'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y'
	),

	"SL_USE_TITLE" => Array(
		"NAME" => GetMessage("MD_SL_USE_TITLE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
		"PARENT" => "LIST_SETTINGS",
	),
);

if ($arCurrentValues["SL_USE_TITLE"] == "Y")
{
	$arTemplateParameters["TITLE_TEXT"] = array(
		//"PARENT"  => "LIST_SETTINGS",
		"NAME"    => GetMessage("MD_SL_TITLE_TEXT"),
		"TYPE"    => "STRING",
		"DEFAULT" => GetMessage("MD_SL_TITLE_TEXT_DEFAULT"),
	);
	$arTemplateParameters["UNDER_TITLE_TEXT"] = array(
		//"PARENT"  => "LIST_SETTINGS",
		"NAME"    => GetMessage("MD_SL_UNDER_TITLE_TEXT"),
		"TYPE"    => "STRING",
		"DEFAULT" => GetMessage("MD_SL_UNDER_TITLE_TEXT_DEFAULT"),
	);
}


if (isset($arCurrentValues['VIEW_MODE']) && 'TILE' == $arCurrentValues['VIEW_MODE'])
{
	$arTemplateParameters['HIDE_SECTION_NAME'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CPT_BCSL_HIDE_SECTION_NAME'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N'
	);
}
?>