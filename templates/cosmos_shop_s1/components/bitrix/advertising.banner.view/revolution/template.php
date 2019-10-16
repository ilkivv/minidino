<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$rnd = randString(5);
/*
$arParams['PROPS']['VIDEO_MUTE'] = $arParams['PROPS']['VIDEO_MUTE'] == 'Y' ? 'muted' : '';
$arParams['PROPS']['STREAM_MUTE'] = $arParams['PROPS']['STREAM_MUTE'] == 'Y' ? '1' : '0';
$arParams['AUTOPLAY'] = $arParams['INDEX'] == '0' ? '&autoplay=1' : '';
$arParams['PROPS']['HEADING_BG_OPACITY'] = isset($arParams['PROPS']['HEADING_BG_OPACITY']) ? intval($arParams['PROPS']['HEADING_BG_OPACITY']) : 100;
$arParams['PROPS']['OVERLAY_COLOR'] = hexdec(substr($arParams['PROPS']['OVERLAY_COLOR'],0,2)).",".hexdec(substr($arParams['PROPS']['OVERLAY_COLOR'],2,2)).",".hexdec(substr($arParams['PROPS']['OVERLAY_COLOR'],4,2)).",".abs(100 - intval($arParams['PROPS']['OVERLAY_OPACITY']))/100;
$arParams['PROPS']['HEADING_BG_COLOR'] = hexdec(substr($arParams['PROPS']['HEADING_BG_COLOR'],0,2)).",".hexdec(substr($arParams['PROPS']['HEADING_BG_COLOR'],2,2)).",".hexdec(substr($arParams['PROPS']['HEADING_BG_COLOR'],4,2)).",".abs(100 - $arParams['PROPS']['HEADING_BG_OPACITY'])/100;
$arParams['PROPS']['ANNOUNCEMENT_BG_COLOR'] = hexdec(substr($arParams['PROPS']['ANNOUNCEMENT_BG_COLOR'],0,2)).",".hexdec(substr($arParams['PROPS']['ANNOUNCEMENT_BG_COLOR'],2,2)).",".hexdec(substr($arParams['PROPS']['ANNOUNCEMENT_BG_COLOR'],4,2)).",".abs(100 - intval($arParams['PROPS']['ANNOUNCEMENT_BG_OPACITY']))/100;
$arParams['PROPS']['PRESET'] = intval($arParams['PROPS']['PRESET']);
$animation = $arParams['PROPS']['ANIMATION'] == 'Y' ? ' data-duration="'.intval($arParams['PROPS']['ANIMATION_DURATION']).'" data-delay="'.intval($arParams['PROPS']['ANIMATION_DELAY']).'"' : '';
$playClass = $arParams['PROPS']['ANIMATION'] == 'Y' ? ' play-caption' : '';
$mobileHide = $arParams['PROPS']['ANNOUNCEMENT_MOBILE_HIDE'] == 'Y' ? ' hidden-xs' : '';
if ($arParams['PROPS']['BACKGROUND'] == 'stream')
{
    $id = '';
    if (strpos($arParams['PROPS']['STREAM'], 'watch?') !== false && ($v = strpos($arParams['PROPS']['STREAM'], 'v=')) !== false)
        $id = substr($arParams['PROPS']['STREAM'], $v + 2, 11);
    else if ($v = strpos($arParams['PROPS']['STREAM'], 'youtu.be/'))
        $id = substr($arParams['PROPS']['STREAM'], $v + 9, 11);
    else if ($v = strpos($arParams['PROPS']['STREAM'], 'embed/'))
        $id = substr($arParams['PROPS']['STREAM'], $v + 6, 11);
}
*/
$arParams['PROPS']['VIDEO_MUTE'] = $arParams['PROPS']['VIDEO_MUTE'] == 'Y' ? 'mute' : '50';

if (is_array($arParams['PROPS']['HEADING'])) {
    $headingText = $arParams['PROPS']['HEADING']['CODE'];
} else {
    $headingText = $arParams['PROPS']['HEADING'];
    $announcementText = $arParams['PROPS']['ANNOUNCEMENT'];
}
$frame = $this->createFrame()->begin("");
if (isset($arParams['FILES']['IMG']["ID"])) {
    $thumbFile = CFile::ResizeImageGet($arParams['FILES']['IMG']["ID"], array('width' => 50, 'height' => 50), BX_RESIZE_IMAGE_EXACT, true);
} else {
    $thumbFile["src"] = $this->GetFolder() . '/images/noimage.png';
}
$headingData = array(
    "VOFFSET" => "['100','100','100','100']",
    "HOFFSET" => "['50','50','50','30']",
    "FONTSIZE" => intval($arParams['PROPS']['HEADING_FONT_SIZE']),
    "COLOR" => $arParams['PROPS']['HEADING_FONT_COLOR'],
    "DATAX" => $arParams['PROPS']['HEADER_DATAX'],
);
$announcementData = array(
    "VOFFSET" => "['180','180','180','180']",
    "HOFFSET" => "['50','50','50','30']",
    "FONTSIZE" => intval($arParams['PROPS']['ANNOUNCEMENT_FONT_SIZE']),
    "COLOR" => $arParams['PROPS']['ANNOUNCEMENT_FONT_COLOR'],
    "DATAX" => $arParams['PROPS']['ANNOUNCEMENT_DATAX'],

);
$buttonData = array(
    "VOFFSET" => "['220','220','220','220']",
    "HOFFSET" => "['50','50','50','30']",
    "BG_COLOR" => $arParams['PROPS']['BUTTON_BG_COLOR'],
    "DATAX" => $arParams['PROPS']['BUTTON_DATAX'],

);
?>
    <!-- SLIDE  -->
    <li data-index="rs-<?= $rnd ?>" data-transition="fade" data-slotamount="7" data-easein="default"
        data-easeout="default"
        data-masterspeed="300" data-thumb="<?= $thumbFile["src"] ?>"
        data-rotate="0" data-saveperformance="off" data-title="<?=$arParams['PROPS']['THUMB_TEXT']?>" data-param1="<?=$arParams['PROPS']['THUMB_SUBTEXT']?>"
        data-description="">

        <? if ($arParams['PROPS']['OVERLAY'] == 'Y'): ?>
            <div class="bx-advertisingbanner-pattern"
                 style="background:rgba(<?= $arParams['PROPS']['OVERLAY_COLOR'] ?>)"></div>
        <? endif; ?>

        <? if (isset($arParams['FILES']['IMG']["ID"])) : ?>
            <img src="<?= $arParams['FILES']['IMG']['SRC'] ?>"
                 alt="<?= $arParams['FILES']['IMG']['DESCRIPTION'] ?>"
                 title="<?= $arParams['FILES']['IMG']['DESCRIPTION'] ?>"
                 data-bgposition="center center"
                 data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
        <? endif; ?>
        <? if (isset($arParams['PROPS']['BACKGROUND']) && $arParams['PROPS']['BACKGROUND'] == 'video'): ?>
            <!-- BACKGROUND VIDEO LAYER -->
            <div class="rs-background-video-layer"
                 data-forcerewind="on"
                 data-volume="<?= $arParams['PROPS']['VIDEO_MUTE'] ?>"
                 data-videowidth="100%"
                 data-videoheight="100%"
                 data-videomp4="<?= $arParams['FILES']['VIDEO_MP4']['SRC'] ?>"
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
        <? elseif (isset($arParams['PROPS']['BACKGROUND']) && $arParams['PROPS']['BACKGROUND'] == 'stream'): ?>
            <?
            if ($arParams['PROPS']['STREAM_MUTE'] == "Y") {
                $volume = 0;
            } else {
                $volume = 100;
            }
            ?>
            <div class="rs-background-video-layer"
                data-forcerewind="on"
                data-volume="0"
                data-ytid="<?=$arParams['PROPS']["STREAM"]?>"
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

        <? if (false && $arParams['PROPS']['OVERLAY'] == 'Y'): ?>
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
                <?= $headingText ?>
            </div>
        <? endif; ?>

        <? if ($arParams['PROPS']['HEADING_SHOW'] == 'Y'): ?>
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
                 style="z-index: 6;"><?= $headingText ?>
            </div>
        <? endif; ?>

        <? if ($arParams['PROPS']['ANNOUNCEMENT_SHOW'] == 'Y'): ?>
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
                <?= $announcementText ?>
            </div>
        <? endif; ?>

        <? if ($arParams['PROPS']['BUTTON'] == 'Y'): ?>
            <!-- LAYER NR. 4 -->
            <div class="tp-caption rs-parallaxlevel-0"
                 id="slide-<?= $rnd ?>-layer-4"
                 data-x="<?= $buttonData["DATAX"] ?>" data-hoffset="<?= $buttonData["HOFFSET"] ?>"
                 data-y="['top','top','top','top']" data-voffset="<?= $buttonData["VOFFSET"] ?>"
                 data-fontsize="<?= $announcementData["FONTSIZE"] ?>"
                 data-color="#<?= $announcementData["COLOR"] ?>"
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
                <a href="<?= $arParams['PROPS']['BUTTON_LINK_URL'] ?>" class="button noleftmargin topmargin-sm"
                   target="<?= $arParams['PROPS']['BUTTON_LINK_TARGET'] ?>"
                   title="<?= $arParams['PROPS']['BUTTON_LINK_TITLE'] ?>">
                    <?= $arParams['PROPS']['BUTTON_TEXT'] ?>
                </a>
            </div>
        <? endif; ?>
    </li>

<? $frame->end(); ?>