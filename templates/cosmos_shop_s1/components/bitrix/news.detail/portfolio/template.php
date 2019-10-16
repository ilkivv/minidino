<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
//AddMessage2Log($arResult);
?>
    <?if(count($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) > 1):?>
        <!-- Portfolio Single Gallery
        ============================================= -->
        <div class="col_full portfolio-single-image">
            <div class="fslider" data-arrows="true" data-animation="slide">
                <div class="flexslider">
                    <div class="slider-wrap">
                    	<?foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["SLIDES"] as $key => $arPhoto):?>
                        	<div class="slide"><img src="<?=$arPhoto["SRC"]?>" alt=""></div>
                    	<?endforeach;?>
                    </div>
                </div>
            </div>
        </div><!-- .portfolio-single-image end -->
    <?else:?>
        <div class="col_full portfolio-single-image">
            <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>">
        </div>
    <?endif;?>


        <!-- Portfolio Single Content
        ============================================= -->
        <div class="col_three_fifth portfolio-single-content nobottommargin">
            
            <!-- Portfolio Single - Description
            ============================================= -->
            <div class="fancy-title title-dotted-border">
                <h2><?=$arResult["NAME"]?></h2>
            </div>
            
            <?if($arResult["DETAIL_TEXT_TYPE"] == "text") :?>
                <p><?=$arResult["DETAIL_TEXT"]?></p>
            <?else:?>
                <?=$arResult["DETAIL_TEXT"]?>
            <?endif;?>
            <!-- Portfolio Single - Description End -->
            
        </div><!-- .portfolio-single-content end -->

        <div class="col_two_fifth col_last nobottommargin">

            <?if(count($arResult["DISPLAY_PROPERTIES"]) > 0):?>
            <!-- Portfolio Single - Meta
            ============================================= -->
            <div class="panel panel-default events-meta">
                <div class="panel-body">
                    <ul class="portfolio-meta nobottommargin">
                        <?foreach($arResult["DISPLAY_PROPERTIES"] as $propKey => $arProp):?>
                            <?if($propKey == "MORE_PHOTO") continue;?>
                            <li><span><?=$arProp["NAME"]?>:</span> <?=$arProp["DISPLAY_VALUE"]?></li>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>
            <!-- Portfolio Single - Meta End -->
            <?endif;?>
            

            <?
            if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y"):?>
                <!-- Portfolio Single - Share
                ============================================= -->
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.share", 
                    "projectx", 
                    array(
                    ),
                    false
                );?>
            <!-- Portfolio Single - Share End -->
            <?endif;?>

        </div>

        <div class="clear"></div>

        <div class="divider divider-center"><i class="icon-circle"></i></div>
