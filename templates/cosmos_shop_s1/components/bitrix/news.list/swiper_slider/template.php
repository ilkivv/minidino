<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
if (count($arResult["ITEMS"]) < 1) return;

$sliderHeight = '';
if ($arParams["HEIGHT_SLIDER"] > 100) {
    $sliderHeight = 'style="height:' . (int)$arParams["HEIGHT_SLIDER"] . 'px"';
}
$autoPlay = "";
if ($arParams["AUTOPLAY_TIME"] > 0)  {

    $autoPlay = 'data-autoplay="' .(int)$arParams["AUTOPLAY_TIME"] . '000"';
}
?>
<div class="container container-for-slider">
    <section id="slider" class="swiper_wrapper clearfix" <?=$sliderHeight?> <?=$autoPlay?> data-loop="true">
        <div class="swiper-container swiper-parent box-caption">
            <div class="swiper-wrapper">
                <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                $menuDarkStyle = '';
                $captionPosition = '';
                if ($arItem["PROPERTIES"]["CAPTION_POSITION"]["VALUE_XML_ID"] == "C") $captionPosition = ' slider-caption-center';
                if ($arItem["PROPERTIES"]["CAPTION_POSITION"]["VALUE_XML_ID"] == "R") $captionPosition = ' slider-caption-right';
                if ($arItem["DISPLAY_PROPERTIES"]["DARK_MENU"]["DISPLAY_VALUE"] == "Y") $menuDarkStyle = ' dark';
                ?>
                <? if (isset($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["FILE_VALUE"]["SRC"])
                && strlen($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["FILE_VALUE"]["SRC"]) > 0
                ): ?>
                <div id="<?= $this->GetEditAreaId($arItem['ID']); ?>" class="swiper-slide<?=$menuDarkStyle?>">
                    <? else: ?>

                    <div id="<?= $this->GetEditAreaId($arItem['ID']); ?>" class="swiper-slide<?=$menuDarkStyle?>"
                         style="background-image: url('<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>'); background-position: center top;"><a href="<?= $arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'] ?>" class="a_class_slider">
                        <?endif;?>
                        <div class="container clearfix">
                            <div class="slider-caption<?=$captionPosition?><?if ($arItem["DISPLAY_PROPERTIES"]["CAPTION_BG"]["DISPLAY_VALUE"] == "Y") echo " slider-caption-bg" ?>">
                                <h2 class="nott"><?php //$arItem["NAME"] ?></h2>

                                <p><?php //$arItem["PREVIEW_TEXT"] ?>
                                </p>
                                <?
                                if (isset($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"])
                                    && strlen($arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]) > 0
                                ): ?>
                                    <!--<a href="<?php //$arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>" class="button button--slider noleftmargin">
                                        <?php //($arItem["DISPLAY_PROPERTIES"]["LINK_TEXT"]["VALUE"] != '' ? $arItem["DISPLAY_PROPERTIES"]["LINK_TEXT"]["VALUE"] : GetMessage('SWIPER_MESS_BTN_LINK'));?>
                                    </a>-->
                                <?endif;?>
                                <?
                                if (isset($arItem["DISPLAY_PROPERTIES"]["LINK_SECOND"]["VALUE"])
                                    && strlen($arItem["DISPLAY_PROPERTIES"]["LINK_SECOND"]["VALUE"]) > 0
                                ): ?>
                                    <a href="<?=$arItem["DISPLAY_PROPERTIES"]["LINK_SECOND"]["VALUE"]?>" class="button button--slider button-white button-light">
                                        <?= ($arItem["DISPLAY_PROPERTIES"]["LINK_TEXT_SECOND"]["VALUE"] != '' ? $arItem["DISPLAY_PROPERTIES"]["LINK_TEXT_SECOND"]["VALUE"] : GetMessage('SWIPER_MESS_BTN_LINK_SECOND'));?>
                                    </a>
                                <?endif;?>
                            </div>
                        </div>
                        <? if (isset($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["FILE_VALUE"]["SRC"])
                            && strlen($arItem["DISPLAY_PROPERTIES"]["VIDEO"]["FILE_VALUE"]["SRC"]) > 0
                        ): ?>
                            <div class="video-wrap">
                                <video id="slide-video" poster="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" preload="auto" loop autoplay
                                       muted>
                                    <source src='<?= $arItem["DISPLAY_PROPERTIES"]["VIDEO"]["FILE_VALUE"]["SRC"] ?>' type='video/mp4'/>
                                </video>
                                <div class="video-overlay" style="background-color: rgba(0,0,0,0.55);"></div>
                            </div>
                        <?endif;?>
                        </a>
                    </div>
                    <? endforeach; ?>
                </div>

                <!-- <div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
                <div id="slider-arrow-right"><i class="icon-angle-right"></i></div> -->
                <div class="swiper-pagination"></div>
            </div>

    </section>
</div>
