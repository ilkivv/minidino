<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$cartId = "top_cart";
$arParams['cartId'] = $cartId;
?>
<div id="top-cart" class="top-cart">
    <a href="<?=$arParams["PATH_TO_BASKET"]?>" id="top-cart-trigger"><i class="icon-shopping-cart"></i></a>
    <div id="top-cart-content" class="top-cart-content">
<?$frame = $this->createFrame("top-cart-content", false)->begin("");
if ($arResult["READY"] == "Y" || $arResult["DELAY"] == "Y" || $arResult["NOTAVAIL"] == "Y" || $arResult["SUBSCRIBE"] == "Y") {
    ?>
            <div class="top-cart-title">
                <h4><?=GetMessage("TSBS_READY")?></h4>
            </div>
            <div class="top-cart-items">
                <?
                $totalSum = 0;
                foreach ($arResult["ITEMS"] as &$arItem) {
                    $totalSum += $arItem["PRICE"] * $arItem["QUANTITY"];
                    if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y") {
                        ?>
                        <div class="top-cart-item clearfix">
                            <div class="top-cart-item-image">
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]; ?>"><img src="<?=$arResult['PICTURES'][$arItem["PRODUCT_ID"]]["SRC"]?>" alt="<?=$arItem["NAME"] ?>" /></a>
                            </div>
                            <div class="top-cart-item-desc">
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]; ?>"><?=$arItem["NAME"] ?></a>
                                <span class="top-cart-item-price"><?= GetMessage("TSBS_PRICE") ?>&nbsp;<?=$arItem["PRICE_FORMATED"] ?> x <?=$arItem["QUANTITY"] ?></span>
                            </div>
                        </div>
                        <?
                    }
                }
                if (isset($arItem))
                    unset($arItem);
                ?>
            </div>
            <div class="top-cart-action clearfix">
                <span class="fleft top-checkout-price"><?=CurrencyFormat($totalSum, "RUB")?></span>
                <a class="button button-3d button-small nomargin fright" href="<?=$arParams["PATH_TO_BASKET"]?>"><?=GetMessage("TSBS_2BASKET");?></a>
            </div>
            <script type="text/javascript">
                $("#top-cart-trigger").append("<span>" +  $(".top-cart-items .top-cart-item").length + "</span>");
            </script>
<?
} else { ?>
    <div class="top-cart-title">
        <h4><?=GetMessage("TSBS_READY")?></h4>
    </div>
    <div class="top-cart-items">
        <?=GetMessage("TSBS_EMPTY_BASKET");?>
    </div>
<?}

$frame->end();?>
    </div>
</div>
<script type="text/javascript">
    <?=$cartId?> = new CosmosSmallCart;
    <?=$cartId?>.siteId       = '<?=SITE_ID?>';
    <?=$cartId?>.cartId       = '<?=$cartId?>';
    <?=$cartId?>.ajaxPath     = '<?=$this->GetFolder();?>/ajax.php';
    <?=$cartId?>.templateName = '<?=$templateName?>';
    <?=$cartId?>.arParams     =  <?=CUtil::PhpToJSObject ($arParams)?>; // TODO \Bitrix\Main\Web\Json::encode
    <?=$cartId?>.init();
</script>