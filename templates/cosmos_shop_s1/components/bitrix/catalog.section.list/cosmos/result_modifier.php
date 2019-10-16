<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arViewModeList = array('LIST', 'TILE', "BLOCK");

$arDefaultParams = array(
	'VIEW_MODE' => 'LIST',
	'SHOW_PARENT_NAME' => 'Y',
	'HIDE_SECTION_NAME' => 'N',
	//TODO: add to parametres
	'TRUNCATE_DESCRIPTION' => 120,
);

$arParams = array_merge($arDefaultParams, $arParams);

if (!in_array($arParams['VIEW_MODE'], $arViewModeList))
	$arParams['VIEW_MODE'] = 'LIST';
if ('N' != $arParams['SHOW_PARENT_NAME'])
	$arParams['SHOW_PARENT_NAME'] = 'Y';
if ('Y' != $arParams['HIDE_SECTION_NAME'])
	$arParams['HIDE_SECTION_NAME'] = 'N';

$arResult['VIEW_MODE_LIST'] = $arViewModeList;

if (0 < $arResult['SECTIONS_COUNT'])
{
	if (!in_array($arParams['VIEW_MODE'], array('LIST', 'TILE')))
	{
		$boolClear = false;
		$arNewSections = array();
		foreach ($arResult['SECTIONS'] as &$arOneSection)
		{
			if (1 < $arOneSection['RELATIVE_DEPTH_LEVEL'])
			{
				$boolClear = true;
				continue;
			}
			$arNewSections[] = $arOneSection;
		}
		unset($arOneSection);
		if ($boolClear)
		{
			$arResult['SECTIONS'] = $arNewSections;
			$arResult['SECTIONS_COUNT'] = count($arNewSections);
		}
		unset($arNewSections);
	}
}


$pictureSizes= array("width" => 270, "height" => 400);
//BITRIX CODE WTF?
if (0 < $arResult['SECTIONS_COUNT'])
{
	$boolPicture = false;
	$boolDescr = false;
	$arSelect = array('ID');
	$arMap = array();
	if ('LINE' == $arParams['VIEW_MODE'] || 'TILE' == $arParams['VIEW_MODE'] || 'BLOCK' == $arParams['VIEW_MODE'])
	{
		reset($arResult['SECTIONS']);
		$arCurrent = current($arResult['SECTIONS']);
		if (!isset($arCurrent['PICTURE']))
		{
			$boolPicture = true;
			$arSelect[] = 'PICTURE';
		}
		if ('LINE' == $arParams['VIEW_MODE'] && !array_key_exists('DESCRIPTION', $arCurrent))
		{
			$boolDescr = true;
			$arSelect[] = 'DESCRIPTION';
			$arSelect[] = 'DESCRIPTION_TYPE';
		}
	}
	if ($boolPicture || $boolDescr)
	{
		foreach ($arResult['SECTIONS'] as $key => $arSection)
		{
			$arMap[$arSection['ID']] = $key;
		}
		$rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
		while ($arSection = $rsSections->GetNext())
		{
			if (!isset($arMap[$arSection['ID']]))
				continue;
			$key = $arMap[$arSection['ID']];
			if ($boolPicture)
			{
				$arSection['PICTURE'] = intval($arSection['PICTURE']);
				$arSection['PICTURE'] = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);

				$pictureId = intval($arSection['PICTURE']['ID']);
				if ($pictureId == 0) return;
				$arFileTmp = CFile::ResizeImageGet(
					$pictureId,
					$pictureSizes,
					BX_RESIZE_IMAGE_EXACT,
					true, flase, false, 100
				);
				$arSection['PICTURE']["SRC"] = $arFileTmp["src"];
				$arSection['PICTURE']["WIDTH"] = $arFileTmp["width"];
				$arSection['PICTURE']["HEIGHT"] = $arFileTmp["height"];

				$arResult['SECTIONS'][$key]['PICTURE'] = $arSection['PICTURE'];
				$arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
			}
			if ($boolDescr)
			{
				$arResult['SECTIONS'][$key]['DESCRIPTION'] = $arSection['DESCRIPTION'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION'] = $arSection['~DESCRIPTION'];
				$arResult['SECTIONS'][$key]['DESCRIPTION_TYPE'] = $arSection['DESCRIPTION_TYPE'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
			}
		}
	} else {
		foreach ($arResult['SECTIONS'] as $key => $arSection) {

			$pictureId = intval($arSection['PICTURE']['ID']);
			if ($pictureId == 0) continue;
			$arFileTmp = CFile::ResizeImageGet(
				$pictureId,
				$pictureSizes,
				BX_RESIZE_IMAGE_EXACT,
				true, flase, false, 100
			);

			$arResult['SECTIONS'][$key]['PICTURE']['SRC'] =  $arFileTmp["src"];
			$arResult['SECTIONS'][$key]['PICTURE']['WIDTH'] = $arFileTmp["width"];
			$arResult['SECTIONS'][$key]['PICTURE']['HEIGHT'] = $arFileTmp["height"];
		}
	}


	foreach ($arResult['SECTIONS'] as $key => $arSection) {
		   $resSectionWithUF = CIBlockSection::GetList(
		   								Array(),
		   								Array(
			   									"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			   									"ID" => $arSection["ID"]
		   									),
		   								false,
		   								Array("UF_PREVIEW_TEXT")
	   								);
		   if($arSectionWithUF = $resSectionWithUF->GetNext()) {
		      if(strlen($arSectionWithUF["UF_PREVIEW_TEXT"]) > 0) {
		         $arResult['SECTIONS'][$key]["DESCRIPTION"] = $arSectionWithUF["UF_PREVIEW_TEXT"];
		      }
		   }
	}
}
?>