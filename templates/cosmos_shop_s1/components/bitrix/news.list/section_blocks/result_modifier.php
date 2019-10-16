<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arFilter = array(
	'IBLOCK_ID' => $arParams["IBLOCK_ID"],
	'ACTIVE'	=> 'Y',
	'DEPTH_LEVEL' => 1
	);
$rsSect = CIBlockSection::GetList(
	array('sort' => 'asc'),
	$arFilter,
	true,
	array('ID', 'NAME', 'SECTION_PAGE_URL', 'DESCRIPTION')
	);

$arResult["SECTIONS"] = array();
    while ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] != "N" && $arSect = $rsSect->GetNext()) {
        $arResult["SECTIONS"][$arSect["ID"]] = $arSect;
    }

foreach ($arResult["ITEMS"] as $key => $arItem) {
	$elementGroupsList = CIBlockElement::GetElementGroups($arItem['ID'], false);
	$sectionCount = 0;
	if ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] != "N" && $arElementSect = $elementGroupsList->Fetch()) {
		$arResult["ITEMS"][$key]["SECTION_CLASS"] .= ' pf-' . $arElementSect['ID'];
		$arResult["SECTIONS"][$arElementSect["ID"]]["ITEMS"][] = $arItem;
	} else {
		$arResult["SECTIONS"]['nosect']["ITEMS"][] = $arItem;
	}
}

?>