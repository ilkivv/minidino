<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["SECTIONS"] as $keySection => $arSection) {
    $pictureId = $arSection["PICTURE"]["ID"];

    if (isset($pictureId) && $pictureId > 0) {
        $arFileTmp = CFile::ResizeImageGet(
            $pictureId,
            array("width" => 172, "height" => 172),
            BX_RESIZE_IMAGE_EXACT,
            true
        );
        $arResult["SECTIONS"][$keySection]["PICTURE_RESIZED"] = array(
            'SRC' => $arFileTmp["src"],
            'WIDTH' => $arFileTmp["width"],
            'HEIGHT' => $arFileTmp["height"],
        );
    }


    
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
         $arResult['SECTIONS'][$keySection]["DESCRIPTION"] = $arSectionWithUF["UF_PREVIEW_TEXT"];
      }
   }
}

?>