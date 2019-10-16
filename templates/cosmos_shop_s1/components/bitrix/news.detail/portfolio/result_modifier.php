<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arResult["DETAIL_PICTURE"]["ID"])) {
    $arFileTmp = CFile::ResizeImageGet(
        $arResult["DETAIL_PICTURE"]["ID"],
        array("width" => 1100, "height" => 550),
        BX_RESIZE_IMAGE_EXACT,
        true
    );

    $arResult["PROPERTIES"]["MORE_PHOTO"]["SLIDES"][] = array(
        'SRC' => $arFileTmp["src"],
        'WIDTH' => $arFileTmp["width"],
        'HEIGHT' => $arFileTmp["height"],
    );
}
foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $key => $photoId) {
    $arFileTmp = CFile::ResizeImageGet(
        $photoId,
        array("width" => 1100, "height" => 550),
        BX_RESIZE_IMAGE_EXACT,
        true
    );
	$arResult["PROPERTIES"]["MORE_PHOTO"]["SLIDES"][] = array(
        'SRC' => $arFileTmp["src"],
        'WIDTH' => $arFileTmp["width"],
        'HEIGHT' => $arFileTmp["height"],
    );
}
unset($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]);


?>