<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arServicesViewTypes = array(
	'team-list' => GetMessage("MD_NL_TEAM_LIST"),
	'noteam-list' => GetMessage("MD_NL_TEAM_GRID"),
);

$arTemplateParameters = array(
	"TEAM_TYPE" => array(
		//"PARENT"  => "LIST_SETTINGS",
		"NAME"    => GetMessage("MD_NL_TEAM_TYPE_TEXT"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"REFRESH" => "N",
		"DEFAULT" => 'team-list',
		"VALUES" => $arServicesViewTypes
	),
	"TEAM_COLS"       => array(
		"NAME"    => GetMessage("MD_NL_TEAM_COLS_TEXT"),
		"TYPE"    => "STRING",
		"DEFAULT" => 2,
	),
);

?>