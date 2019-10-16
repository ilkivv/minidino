<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult["ITEMS"] as $key => $arItem)
{
	if (isset($arItem["PREVIEW_PICTURE"]["ID"]))
	{
		$arFileTmp = CFile::ResizeImageGet(
				$arItem["PREVIEW_PICTURE"]["ID"],
				array("width" => 64, "height" => 64),
				BX_RESIZE_IMAGE_EXACT,
				true
		);
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE_RESIZED"] = array(
				'SRC'    => $arFileTmp["src"],
				'WIDTH'  => $arFileTmp["width"],
				'HEIGHT' => $arFileTmp["height"],
		);
	}
}

?>