<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);
if (count($arResult["ITEMS"])  < 1) return;
$uniqId = $this->randString(6);
?>
<!-- Related Portfolio Items
============================================= -->
<h4><?=GetMessage('NL_MD_RELATED') . ' ' . $arResult["NAME"]?>:</h4>

<div id="related-portfolio-<?=$uniqId?>" class="owl-carousel portfolio-carousel">
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="oc-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="iportfolio">
            <div class="portfolio-image">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <img src="<?=$arItem["PREVIEW_PICTURE_RESIZED"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
                </a>
                <div class="portfolio-overlay" data-lightbox="gallery">
                    <a href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-zoom-in"></i></a>
                    <?foreach($arItem["PROPERTIES"]["MORE_PHOTO"]["SLIDES"] as $arSlide):?>
                    	<a href="<?=$arSlide["SRC"]?>" class="hidden" data-lightbox="gallery-item"></a>
                    <?endforeach;?>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
                </div>
            </div>
            <div class="portfolio-desc">
                <h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h3>
                <span><?=$arItem["SECTION_TAGS"]?></span>
            </div>
        </div>
    </div>
<?endforeach;?>
</div><!-- .portfolio-carousel end -->

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var relatedPortfolio = $("#related-portfolio-<?=$uniqId?>");
         
        relatedPortfolio.owlCarousel({
            margin: 20,
            nav: false,
            dots:true,
            autoplay: true,
            autoplayHoverPause: true,
            responsive:{
                0:{ items:1 },
                600:{ items:2 },
                768:{ items:3 },
            }
        });
    });
</script>


