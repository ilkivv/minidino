<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["ITEMS"] as $key => $arItem) {
	if (isset($arItem["PREVIEW_PICTURE"]["ID"])) {
	    $arFileTmp = CFile::ResizeImageGet(
	        $arItem["PREVIEW_PICTURE"]["ID"],
	        array("width" => 400, "height" => 300),
	        BX_RESIZE_IMAGE_EXACT,
	        true
	    );

	    $arResult["ITEMS"][$key]["PREVIEW_PICTURE_RESIZED"] = array(
	        'SRC' => $arFileTmp["src"],
	        'WIDTH' => $arFileTmp["width"],
	        'HEIGHT' => $arFileTmp["height"],
	    );
	}

	if (is_array($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
        foreach($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $keyPhoto => $photoId) {
            $arFileTmp = CFile::ResizeImageGet(
                $photoId,
                array("width" => 1200, "height" => 700),
                BX_RESIZE_IMAGE_EXACT,
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
}
?>