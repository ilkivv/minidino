<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


CModule::IncludeModule("catalog");
foreach($arResult as $key => $arItem) {
    $idsArray[] = IntVal($key);
}

if(count($arResult) > 0 && CModule::IncludeModule('iblock')) {
    $res = CIBlockElement::GetList(
        array(),
        array("ACTIVE" => "Y", "ID" => $idsArray),
        false,
        false,
        array("PREVIEW_PICTURE", "DETAIL_PICTURE", "ID", "DETAIL_PAGE_URL")
    );


    while($ar_fields = $res->GetNext()) {

        if (!isset($ar_fields["PREVIEW_PICTURE"]) && !isset($ar_fields["DETAIL_PICTURE"])){
            $ar_field_parent_sku = CCatalogSku::GetProductInfo($ar_fields["ID"], $ar_fields["IBLOCK_ID"]);

            $ar_parent_sku_res = CIBlockElement::GetList(
                array(),
                array("ACTIVE" => "Y", "ID" => $ar_field_parent_sku["ID"]),
                false,
                false,
                array("PREVIEW_PICTURE", "DETAIL_PICTURE", "ID", "DETAIL_PAGE_URL")
            );
            if ($ar_parent_sku_fields = $ar_parent_sku_res->GetNext()) {
                $ar_fields["PREVIEW_PICTURE"] = $ar_parent_sku_fields["PREVIEW_PICTURE"];
                $ar_fields["DETAIL_PICTURE"] = $ar_parent_sku_fields["DETAIL_PICTURE"];
            }
        }

        if (isset($ar_fields["PREVIEW_PICTURE"])) {
            $arFileTmp = CFile::ResizeImageGet(
                $ar_fields["PREVIEW_PICTURE"],
                array("width" => 54, "height" => 54),
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );
        } else {
            $arFileTmp = CFile::ResizeImageGet(
                $ar_fields["DETAIL_PICTURE"],
                array("width" => 54, "height" => 54),
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true
            );
        }

        $arResult[$ar_fields["ID"]] += array(
            'SRC' => $arFileTmp["src"],
            'WIDTH' => $arFileTmp["width"],
            'HEIGHT' => $arFileTmp["height"],
        );
    }
}

?>