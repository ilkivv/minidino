<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
		"TITLE_TEXT"       => array(
			//"PARENT"  => "LIST_SETTINGS",
				"NAME"    => GetMessage("MD_NL_TITLE_TEXT"),
				"TYPE"    => "STRING",
				"DEFAULT" => GetMessage("MD_NL_TITLE_TEXT_DEFAULT"),
		),
		"UNDER_TITLE_TEXT" => array(
			//"PARENT"  => "LIST_SETTINGS",
				"NAME"    => GetMessage("MD_NL_UNDER_TITLE_TEXT"),
				"TYPE"    => "STRING",
				"DEFAULT" => GetMessage("MD_NL_UNDER_TITLE_TEXT_DEFAULT"),
		),
);
?>