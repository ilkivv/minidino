<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
	"BG_SRC"       => array(
		"NAME"    => GetMessage("MD_NL_BG_SRC_TEXT"),
		"TYPE"    => "STRING",
		"DEFAULT" => GetMessage("MD_NL_TITLE_BG_SRC_DEFAULT"),
	),
	"BG_COLOR"       => array(
		"NAME"    => GetMessage("MD_NL_BG_COLOR_TEXT"),
		"TYPE"    => "STRING",
		"DEFAULT" => GetMessage("MD_NL_TITLE_BG_COLOR_DEFAULT"),
	),
);
?>