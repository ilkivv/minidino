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

    $randRevId = $this->randString(5);
    /*
    $this->addExternalCss("/bitrix/css/main/bootstrap.css");
    $this->addExternalCss("/bitrix/css/main/font-awesome.css");
    $this->addExternalCss("/bitrix/themes/.default/banner.css");
    $this->addExternalJs("/bitrix/components/bitrix/advertising.banner/templates/bootstrap/bxcarousel.js");
    $arParams['WIDTH'] = intval($arResult['SIZE']['WIDTH']);
    $arParams['HEIGHT'] = intval($arResult['SIZE']['HEIGHT']);
    if($arParams['BS_CYCLING'] == 'Y')
        $arParams['BS_INTERVAL'] = intval($arParams['BS_INTERVAL']);
    else
        $arParams['BS_INTERVAL'] = 'false';
    $arParams['BS_WRAP'] = ($arParams['BS_WRAP'] == 'Y' || $arParams['PREVIEW'] == 'Y') ? 'true' : 'false';
    $arParams['BS_PAUSE'] = $arParams['BS_PAUSE'] == 'Y' ? 'true' : 'false';
    $arParams['BS_KEYBOARD'] = $arParams['BS_KEYBOARD'] == 'Y' ? 'true' : 'false';
    $arParams['BS_HIDE_FOR_TABLETS'] = $arParams['BS_HIDE_FOR_TABLETS'] == 'Y' ? ' hidden-sm' : '';
    $arParams['BS_HIDE_FOR_PHONES'] = $arParams['BS_HIDE_FOR_PHONES'] == 'Y' ? ' hidden-xs' : '';
*/

    $styleArrows = "gyges";
    $styleTabs = "ares";

    $this->addExternalCss($this->GetFolder() . "/css/settings.css");
    $this->addExternalCss($this->GetFolder() . "/css/" . $styleTabs . ".css");
    $this->addExternalCss($this->GetFolder() . "/css/" . $styleArrows . ".css");


    $this->addExternalJs($this->GetFolder() . "/js/jquery.themepunch.tools.min.js");
    $this->addExternalJs($this->GetFolder() . "/js/jquery.themepunch.revolution.min.js");

    $frame = $this->createFrame()->begin("");

    ?>

    <section id="slider" class="revoslider-wrap clearfix">

        <div id="rev-<?= $randRevId ?>_wrapper" class="rev_slider_wrapper fullwidthbanner-container"
             data-alias="media-carousel-autoplay30"
             style="margin:0px auto;padding:0px;margin-top:0px;margin-bottom:0px;">
            <!-- START REVOLUTION SLIDER 5.0.7 fullwidth mode -->
            <div id="rev-<?= $randRevId ?>" class="rev_slider fullwidthabanner" style="display:none;"
                 data-version="5.0.7">
                <ul>
                    <? foreach ($arResult["ITEMS"] as $keyBanner => $arItem): ?>
					<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

						if (isset($arItem['DETAIL_PICTURE']["ID"])) {
						    $thumbFile = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']["ID"], array('width' => 50, 'height' => 50), BX_RESIZE_IMAGE_EXACT, true);
						} else {
						    $thumbFile["src"] = $this->GetFolder() . '/images/noimage.png';
						}

						$rnd = randString(5);

						$headingData = array(
						    "VOFFSET" => "['100','100','100','100']",
						    "HOFFSET" => "['50','50','50','30']",
						    "FONTSIZE" => intval($arItem['DISPLAY_PROPERTIES']['HEADING_FONT_SIZE']["VALUE"]),
						    "COLOR" => $arItem['DISPLAY_PROPERTIES']['HEADING_FONT_COLOR']["VALUE"],
						    "DATAX" => $arItem['DISPLAY_PROPERTIES']['HEADER_DATAX']["VALUE_XML_ID"],
						);
						$announcementData = array(
						    "VOFFSET" => "['180','180','180','180']",
						    "HOFFSET" => "['50','50','50','30']",
						    "FONTSIZE" => intval($arItem['DISPLAY_PROPERTIES']['ANNOUNCEMENT_FONT_SIZE']["VALUE"]),
						    "COLOR" => $arItem['DISPLAY_PROPERTIES']['ANNOUNCEMENT_FONT_COLOR']["VALUE"],
						    "DATAX" => $arItem['DISPLAY_PROPERTIES']['ANNOUNCEMENT_DATAX']["VALUE_XML_ID"],

						);
						$buttonData = array(
						    "VOFFSET" => "['220','220','220','220']",
						    "HOFFSET" => "['50','50','50','30']",
						    "BG_COLOR" => $arItem['DISPLAY_PROPERTIES']['BUTTON_BG_COLOR']["VALUE"],
						    "DATAX" => $arItem['DISPLAY_PROPERTIES']['BUTTON_DATAX']["VALUE_XML_ID"],

						);
                    ?>
					    <!-- SLIDE  -->
					    <li data-index="rs-<?= $rnd ?>" data-transition="fade" data-slotamount="7" data-easein="default" id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
					        data-easeout="default"
					        data-masterspeed="300" data-thumb="<?= $thumbFile["src"] ?>"
					        data-rotate="0" data-saveperformance="off" data-title="<?=$arItem['DISPLAY_PROPERTIES']['THUMB_TEXT']["VALUE"]?>" data-param1="<?=$arItem['DISPLAY_PROPERTIES']['THUMB_SUBTEXT']["VALUE"]?>"
					        data-description="">

					        <? if (isset($arItem['DETAIL_PICTURE']["ID"])) : ?>
					            <img src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>"
					                 alt="<?= $arItem['DETAIL_PICTURE']['DESCRIPTION'] ?>"
					                 title="<?= $arItem['DETAIL_PICTURE']['DESCRIPTION'] ?>"
					                 data-bgposition="center center"
					                 data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
					        <? endif; ?>

					        <? if (isset($arItem['DISPLAY_PROPERTIES']['VIDEO_MP4']['FILE_VALUE']['SRC']) && strlen($arItem['DISPLAY_PROPERTIES']['VIDEO_MP4']['FILE_VALUE']['SRC']) > 0 ): ?>
					            <!-- BACKGROUND VIDEO LAYER -->
					            <div class="rs-background-video-layer"
					                 data-forcerewind="on"
					                 data-volume="<?=($arItem['DISPLAY_PROPERTIES']['VIDEO_MUTE']["VALUE"] == "Y") ? "mute" : "70" ?>"
					                 data-videowidth="100%"
					                 data-videoheight="100%"
					                 data-videomp4="<?= $arItem['DISPLAY_PROPERTIES']['VIDEO_MP4']['FILE_VALUE']['SRC'] ?>"
					                 data-videopreload="preload"
					                 data-videoloop="none"
					                 data-forceCover="1"
					                 data-aspectratio="16:9"
					                 data-autoplay="true"
					                 data-autoplayonlyfirsttime="false"
					                 data-nextslideatend="true"
					            ></div>
					            <? if (isset($arParams['FILES']['VIDEO_WEBM']['SRC'])): ?>
					                <source src="<?= $arParams['FILES']['VIDEO_WEBM']['SRC'] ?>"
					                        type='video/webm; codecs="vp8, vorbis"'>
					            <? endif; ?>
					        <? elseif (isset($arItem['DISPLAY_PROPERTIES']['BACKGROUND']["VALUE"]) && $arItem['DISPLAY_PROPERTIES']['BACKGROUND']["VALUE"] == 'stream'): ?>
					            <?
					            if ($arItem['DISPLAY_PROPERTIES']['STREAM_MUTE']["VALUE"] == "Y") {
					                $volume = 0;
					            } else {
					                $volume = 100;
					            }
					            ?>
					            <div class="rs-background-video-layer"
					                data-forcerewind="on"
					                data-volume="0"
					                data-ytid="<?=$arItem['DISPLAY_PROPERTIES']["STREAM"]["VALUE"]?>"
					                data-videoattributes="version=3&enablejsapi=1&html5=1&hd=1&wmode=opaque&showinfo=0&ref=0;;origin=http://<?=$_SERVER["HTTP_HOST"]?>;"
					                data-videorate="1"
					                data-videowidth="100%"
					                data-videoheight="100%"
					                data-videocontrols="none"
					                data-videoloop="none"
					                data-forceCover="1"
					                data-aspectratio="16:9"
					                data-autoplay="true"
					                data-autoplayonlyfirsttime="false"
					                data-nextslideatend="true"
					            ></div>
					        <? endif; ?>

					        <? if (false && $arItem['DISPLAY_PROPERTIES']['OVERLAY']["VALUE"] == 'Y'): ?>
					            <div class="tp-caption rs-parallaxlevel-1"
					                 id="overlay-<?= $rnd ?>-layer-1"
					                 data-x="<?= $headingData["DATAX"] ?>" data-hoffset="<?= $headingData["VOFFSET"] ?>"
					                 data-y="['top','top','top','top']" data-voffset="<?= $headingData["HOFFSET"] ?>"
					                 data-width="['600','600','600','420']"
					                 data-height="['600','600','600','420']"
					                 data-whitespace="normal"
					                 data-transform_idle="o:1;"

					                 data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:500;e:Power3.easeInOut;"
					                 data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
					                 data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
					                 data-mask_out="x:0;y:0;s:inherit;e:inherit;"
					                 data-start="500"
					                 data-splitin="none"
					                 data-splitout="none"
					                 data-responsive_offset="on"
					                 style="z-index: 6; background:#AAA">
					                <?= $arItem["NAME"] ?>
					            </div>
					        <? endif; ?>

					        <? if ($arItem['DISPLAY_PROPERTIES']['HEADING_SHOW']["VALUE"] == 'Y'): ?>
					            <!-- LAYER NR. 2 -->
					            <div class="tp-caption rs-parallaxlevel-0"
					                 id="slide-<?= $rnd ?>-layer-1"
					                 data-x="<?= $headingData["DATAX"] ?>" data-hoffset="<?= $headingData["HOFFSET"] ?>"
					                 data-y="['top','top','top','top']" data-voffset="<?= $headingData["VOFFSET"] ?>"
					                 data-fontsize="<?= $headingData["FONTSIZE"] ?>"
					                 data-color="#<?= $headingData["COLOR"] ?>"
					                 data-lineheight="['55','55','55','35']"
					                 data-width="['600','600','600','600']"
					                 data-height="none"
					                 data-whitespace="normal"
					                 data-transform_idle="o:1;"

					                 data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:500;e:Power3.easeInOut;"
					                 data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
					                 data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
					                 data-mask_out="x:0;y:0;s:inherit;e:inherit;"
					                 data-start="500"
					                 data-splitin="none"
					                 data-splitout="none"
					                 data-responsive_offset="on"
					                 style="z-index: 6;"><?= $arItem["NAME"] ?>
					            </div>
					        <? endif; ?>

					        <? if ($arItem['DISPLAY_PROPERTIES']['ANNOUNCEMENT_SHOW']["VALUE"] == 'Y'): ?>
					            <!-- LAYER NR. 3 -->
					            <div class="tp-caption rs-parallaxlevel-0"
					                 id="slide-<?= $rnd ?>-layer-3"
					                 data-x="<?= $announcementData["DATAX"] ?>" data-hoffset="<?= $announcementData["HOFFSET"] ?>"
					                 data-y="['top','top','top','top']" data-voffset="<?= $announcementData["VOFFSET"] ?>"
					                 data-fontsize="<?= $announcementData["FONTSIZE"] ?>"
					                 data-color="#<?= $announcementData["COLOR"] ?>"
					                 data-lineheight="<?= $announcementData["FONTSIZE"] ?>"
					                 data-width="['600','600','600','420']"
					                 data-height="none"
					                 data-whitespace="normal"
					                 data-transform_idle="o:1;"

					                 data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:500;e:Power3.easeInOut;"
					                 data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
					                 data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
					                 data-mask_out="x:0;y:0;s:inherit;e:inherit;"
					                 data-start="500"
					                 data-splitin="none"
					                 data-splitout="none"
					                 data-responsive_offset="on"

					                 style="z-index: 7; white-space: nowrap;">
					                <?= $arItem['DISPLAY_PROPERTIES']['ANNOUNCEMENT']["VALUE"] ?>
					            </div>
					        <? endif; ?>

					        <? if ($arItem['DISPLAY_PROPERTIES']['BUTTON_SHOW']["VALUE"] == 'Y'): ?>
					            <!-- LAYER NR. 4 -->
					            <div class="tp-caption rs-parallaxlevel-0"
					                 id="slide-<?= $rnd ?>-layer-4"
					                 data-x="<?= $buttonData["DATAX"] ?>" data-hoffset="<?= $buttonData["HOFFSET"] ?>"
					                 data-y="['top','top','top','top']" data-voffset="<?= $buttonData["VOFFSET"] ?>"
					                 data-fontsize="<?= $buttonData["FONTSIZE"] ?>"
					                 data-color="#<?= $buttonData["COLOR"] ?>"
					                 data-width="['600','600','600','420']"
					                 data-height="none"
					                 data-whitespace="normal"
					                 data-transform_idle="o:1;"

					                 data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:500;e:Power3.easeInOut;"
					                 data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
					                 data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
					                 data-mask_out="x:0;y:0;s:inherit;e:inherit;"
					                 data-start="500"
					                 data-splitin="none"
					                 data-splitout="none"
					                 data-responsive_offset="on"

					                 style="z-index: 7; white-space: nowrap;">
					                <a href="<?= $arItem['DISPLAY_PROPERTIES']['BUTTON_LINK_URL']["VALUE"] ?>" class="button noleftmargin topmargin-sm"
					                   target="<?= $arItem['DISPLAY_PROPERTIES']['BUTTON_LINK_TARGET']["VALUE_XML"] ?>"
					                   title="<?= $arItem['DISPLAY_PROPERTIES']['BUTTON_LINK_TITLE']["VALUE"] ?>">
					                    <?= $arItem['DISPLAY_PROPERTIES']['BUTTON_TEXT']["VALUE"] ?>
					                </a>
					            </div>
					        <? endif; ?>


				        </li>
                    <? endforeach; ?>
                </ul>
                <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
            </div>
        </div><!-- END REVOLUTION SLIDER -->
        <script type="text/javascript">
            var tpj = jQuery;

            var revapi30;
            tpj(document).ready(function () {
                if (tpj("#rev-<?=$randRevId?>").revolution == undefined) {
                    revslider_showDoubleJqueryError("#rev-<?=$randRevId?>");
                } else {
                    revapi30 = tpj("#rev-<?=$randRevId?>").show().revolution({
                        sliderType: "carousel",
                        jsFileLocation: "<?=$this->GetFolder()?>/js/",
                        sliderLayout: "fullwidth",
                        dottedOverlay: "none",
                        delay: 9000,
                        navigation: {
                            keyboardNavigation: "off",
                            keyboard_direction: "horizontal",
                            mouseScrollNavigation: "off",
                            onHoverStop: "off",
                            touch: {
                                touchenabled: "on",
                                swipe_threshold: 75,
                                swipe_min_touches: 1,
                                swipe_direction: "horizontal",
                                drag_block_vertical: false
                            }
                            ,
                            arrows: {
                                style: "<?=$styleArrows?>",
                                enable: true,
                                hide_onmobile: false,
                                hide_onleave: false,
                                tmp: '',
                                left: {
                                    h_align: "left",
                                    v_align: "center",
                                    h_offset: 20,
                                    v_offset: 0
                                },
                                right: {
                                    h_align: "right",
                                    v_align: "center",
                                    h_offset: 20,
                                    v_offset: 0
                                }
                            }
                            ,
                            tabs: {
                                style: "<?=$styleTabs?>",
                                enable: true,
                                width: 234,
                                height: 80,
                                min_width: 250,
                                wrapper_padding: 10,
                                wrapper_color: "#222",
                                wrapper_opacity: "1",
                                tmp: '<div class="tp-tab-content">  <span class="tp-tab-date">{{param1}}</span>  <span class="tp-tab-title">{{title}}</span></div><div class="tp-tab-image"></div>',
                                visibleAmount: 5,
                                hide_onmobile: false,
                                hide_onleave: false,
                                hide_delay: 200,
                                direction: "horizontal",
                                span: true,
                                position: "outer-bottom",
                                space: 0,
                                h_align: "center",
                                v_align: "bottom",
                                h_offset: 0,
                                v_offset: 0
                            }
                        },
                        carousel: {
                            horizontal_align: "center",
                            vertical_align: "center",
                            fadeout: "on",
                            vary_fade: "on",
                            maxVisibleItems: 1,
                            infinity: "on",
                            space: 0,
                            stretch: "off"
                        },
                        parallax: {
                            type:"mouse",
                            origo:"slidercenter",
                            speed:2000,
                            levels:[2,3,4,5,6,7,12,16,10,50],
                        },
                        gridwidth: 1170,
                        gridheight: 500,
                        lazyType: "none",
                        shadow: 0,
                        spinner: "off",
                        stopLoop: "on",
                        stopAfterLoops: 0,
                        stopAtSlide: 1,
                        shuffle: "off",
                        autoHeight: "off",
                        disableProgressBar: "on",
                        hideThumbsOnMobile: "off",
                        hideSliderAtLimit: 0,
                        hideCaptionAtLimit: 0,
                        hideAllCaptionAtLilmit: 0,
                        debugMode: false,
                        fallbacks: {
                            simplifyAll: "off",
                            nextSlideOnWindowFocus: "off",
                            disableFocusListener: false,
                        }
                    });
                }
            });
            /*ready*/
        </script>

    </section>