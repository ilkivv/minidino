<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
		"AUTOPLAY_TIME" => array(
				"NAME"    => GetMessage("MD_NL_AUTOPLAY_TEXT"),
				"TYPE"    => "STRING",
				"DEFAULT" => GetMessage("MD_NL_AUTOPLAY_DEFAULT"),
		),
		"HEIGHT_SLIDER" => array(
				"NAME"    => GetMessage("MD_NL_HEIGHT_SLIDER"),
				"TYPE"    => "STRING",
				"DEFAULT" => GetMessage("MD_NL_HEIGHT_DEFAULT"),
		),
);
?>