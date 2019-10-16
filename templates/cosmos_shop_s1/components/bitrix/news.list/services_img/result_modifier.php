<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * Created by PhpStorm.
 * User: Chikovinskii Dmitrii
 * Date: 31.01.17
 * Time: 5:33
 */

foreach ($arResult["ITEMS"] as $key => $arItem)
{
    if (isset($arItem["PREVIEW_PICTURE"]["ID"]))
    {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem["PREVIEW_PICTURE"]["ID"],
            array("width" => 350, "height" => 220),
            BX_RESIZE_IMAGE_EXACT,
            TRUE
        );
        $arResult["ITEMS"][$key]["PREVIEW_PICTURE_RESIZED"] = array(
            'SRC' => $arFileTmp["src"],
            'WIDTH' => $arFileTmp["width"],
            'HEIGHT' => $arFileTmp["height"],
        );
    }
}