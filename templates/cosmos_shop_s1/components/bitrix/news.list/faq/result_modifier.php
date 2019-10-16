<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arFilter = array(
	'IBLOCK_ID' => $arParams["IBLOCK_ID"],
	'ACTIVE'	=> 'Y'
	);
$rsSect = CIBlockSection::GetList(
	array('sort' => 'asc'),
	$arFilter,
	true,
	array('ID', 'NAME')
	);
$arResult["SECTIONS"] = array();
while ($arSect = $rsSect->GetNext())
{
	$arResult["SECTIONS"][] = $arSect;	
}

foreach ($arResult["ITEMS"] as $key => $arItem) {
	$elementGroupsList = CIBlockElement::GetElementGroups($arItem['ID'], false);
	while($arElementSect = $elementGroupsList->Fetch()) {
		$arResult["ITEMS"][$key]["SECTION_CLASS"] .= ' faq-' . $arElementSect['ID'];
		$arResult["ITEMS"][$key]["SECTION_ICON"] = $arElementSect["DESCRIPTION"];
	}
}

?>