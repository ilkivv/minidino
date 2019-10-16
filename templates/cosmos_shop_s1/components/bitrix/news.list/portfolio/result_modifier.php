<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if ($arParams["PARENT_SECTION"] > 0) {
	$rsParentSection = CIBlockSection::GetByID($arParams["PARENT_SECTION"]);
	if ($arParentSection = $rsParentSection->GetNext())
	{
		$arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
		$rsSect = CIBlockSection::GetList(
			array('left_margin' => 'asc'),
			$arFilter,
			true,
			array('ID', 'NAME', 'SECTION_PAGE_URL')
			);
	}
} else {
	$arFilter = array(
		'IBLOCK_ID' => $arParams["IBLOCK_ID"],
		'ACTIVE'	=> 'Y',
		'DEPTH_LEVEL' => 1
		);
	$rsSect = CIBlockSection::GetList(
		array('sort' => 'asc'),
		$arFilter,
		true,
		array('ID', 'NAME', 'SECTION_PAGE_URL')
		);
}


$arResult["SECTIONS"] = array();
while ($arSect = $rsSect->GetNext())
{
	$arResult["SECTIONS"][] = $arSect;
	$arSections[$arSect["ID"]] = $arSect;
}

foreach ($arResult["ITEMS"] as $key => $arItem) {
	$elementGroupsList = CIBlockElement::GetElementGroups($arItem['ID'], false);
	$sectionCount = 0;
	while($arElementSect = $elementGroupsList->Fetch()) {
		$arResult["ITEMS"][$key]["SECTION_CLASS"] .= ' pf-' . $arElementSect['ID'];
		$rsSection = CIBlockSection::GetByID($arElementSect['ID']);
		$arSection = $rsSection->GetNext();

		//Get Section Parents
		$arSectionParent["IBLOCK_SECTION_ID"] = $arSection["IBLOCK_SECTION_ID"];
		while ($arSectionParent["IBLOCK_SECTION_ID"] > 0) {
			$rsSectionParent = CIBlockSection::GetByID($arSection["IBLOCK_SECTION_ID"]);
			$arSectionParent = $rsSectionParent->GetNext();
			if ($sectionCount > 0) $arResult["ITEMS"][$key]["SECTION_TAGS"] .= ', ';
			$arResult["ITEMS"][$key]["SECTION_TAGS"] .= '<a href="' . $arSectionParent["SECTION_PAGE_URL"] . '">' . $arSectionParent["NAME"] . '</a>';
			$arResult["ITEMS"][$key]["SECTION_CLASS"] .= ' pf-' . $arSectionParent['ID'];
			$sectionCount++;
		}

		if ($sectionCount > 0) $arResult["ITEMS"][$key]["SECTION_TAGS"] .= ', ';
		$arResult["ITEMS"][$key]["SECTION_TAGS"] .= '<a href="' . $arSection["SECTION_PAGE_URL"] . '">' . $arSection["NAME"] . '</a>';
		$sectionCount++;

	}


	if (isset($arItem["PREVIEW_PICTURE"]["ID"])) {
	    $arFileTmp = CFile::ResizeImageGet(
	        $arItem["PREVIEW_PICTURE"]["ID"],
	        array("width" => 370, "height" => 277),
	        BX_RESIZE_IMAGE_EXACT,
	        true
	    );

	    $arResult["ITEMS"][$key]["PREVIEW_PICTURE"]["RESIZED"] = array(
	        'SRC' => $arFileTmp["src"],
	        'WIDTH' => $arFileTmp["width"],
	        'HEIGHT' => $arFileTmp["height"],
	    );
	}

	if (isset($arItem["DETAIL_PICTURE"]["ID"])) {
	    $arFileTmp = CFile::ResizeImageGet(
	        $arItem["DETAIL_PICTURE"]["ID"],
	        array("width" => 1400, "height" => 1400),
	        BX_RESIZE_IMAGE_PROPORTIONAL,
	        true
	    );

	    $arResult["ITEMS"][$key]["PROPERTIES"]["MORE_PHOTO"]["SLIDES"][] = array(
	        'SRC' => $arFileTmp["src"],
	        'WIDTH' => $arFileTmp["width"],
	        'HEIGHT' => $arFileTmp["height"],
	    );
	}
	foreach($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $keyPhoto => $photoId) {
	    $arFileTmp = CFile::ResizeImageGet(
	        $photoId,
	        array("width" => 1400, "height" => 1400),
	        BX_RESIZE_IMAGE_PROPORTIONAL,
	        true
	    );
		$arResult["ITEMS"][$key]["PROPERTIES"]["MORE_PHOTO"]["SLIDES"][] = array(
	        'SRC' => $arFileTmp["src"],
	        'WIDTH' => $arFileTmp["width"],
	        'HEIGHT' => $arFileTmp["height"],
	    );
	}
	unset($arResult["ITEMS"][$key]["DISPLAY_PROPERTIES"]["MORE_PHOTO"]);


}

?>