<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<section id="slider" class="slider-parallax full-screen dark" style="overflow: hidden; background: url('<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>') no-repeat center center;background-size: cover;">
    <div class="container clearfix vertical-middle" style="z-index: 3;">
        <div class="heading-block title-center nobottomborder">
            <h1><?=$arResult["NAME"]?><br><?=GetMessage("STARTING_WITH")?></h1>
        </div>
        <div id="countdown-ex1" class="countdown countdown-large coming-soon divcenter bottommargin" style="max-width:700px;"></div>
        <script>
            jQuery(document).ready( function($){
                var newDate = new Date(<?=(int)ConvertDateTime($arResult["DATE_ACTIVE_TO"], "YYYY")?>, <?=(int)ConvertDateTime($arResult["DATE_ACTIVE_TO"], "MM")?>, <?=(int)ConvertDateTime($arResult["DATE_ACTIVE_TO"], "DD")?>);
                $('#countdown-ex1').countdown({until: newDate});
            });
        </script>
        <div class="center topmargin-lg">
            <?/*<a href="<?=SITE_DIR?>ajax/study.php?ELEMENT_CODE=<?=$arParams["ELEMENT_ID"]?>&TYPE=ZABRON" data-lightbox="ajax" class="button button-3d button-theme button-rounded button-xlarge"><?=GetMessage("SLIDER_ZABRON")?></a>
            <span class="hidden-xs"> - <?=GetMessage("SLIDER_OR")?> - </span> */?>
            <a href="<?=$arResult["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]?>" class="button button-3d button-rounded button-xlarge"><?=GetMessage("SLIDER_READ_MORE")?></a>
        </div>
    </div>
</section>