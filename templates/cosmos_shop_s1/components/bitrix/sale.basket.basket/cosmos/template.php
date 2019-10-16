<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */
use Bitrix\Main\Localization\Loc;
$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);
unset($curPage);

$arBasketJSParams = array(
	'SALE_DELETE' => Loc::getMessage("SALE_DELETE"),
	'SALE_DELAY' => Loc::getMessage("SALE_DELAY"),
	'SALE_TYPE' => Loc::getMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	?>
	<div id="warning_message">
		<?
		if (!empty($arResult["WARNING_MESSAGE"]) && is_array($arResult["WARNING_MESSAGE"]))
		{
			foreach ($arResult["WARNING_MESSAGE"] as $v)
				ShowError($v);
		}
		?>
	</div>
	<?

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? 'style="display:none;"' : '';

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? 'style="display:none;"' : '';

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? 'style="display:none;"' : '';

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? 'style="display:none;"' : '';

	?>
        <? if (defined("COSMOS_MODULE_AJAX_REQUEST") && COSMOS_MODULE_AJAX_REQUEST == true) :?>
            <a href="<?=$APPLICATION->GetCurPage(). '?CLEAR_BASKET=Y' ?>" class="button button-mini button-border button-theme norightmargin fright fly-cart-btn" style="z-index: 10"><?=Loc::getMessage("CLEAR_BASKET")?></a>
            <a href="<?=$APPLICATION->GetCurPage()?>" class="button button-mini button-border button-theme norightmargin fright" style="z-index: 10"><?=GetMessage("GO_TO_BASKET")?></a>
        <? else :?>
            <a href="<?=$APPLICATION->GetCurPage(). '?CLEAR_BASKET=Y' ?>" class="button button-mini button-border button-theme norightmargin fright" style="z-index: 10"><?=Loc::getMessage("CLEAR_BASKET")?></a>
        <?endif;?>

        <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
			<div id="basket_form_container">
				<div class="bx_ordercart">
					<div class="tabs clearfix">
						<ul class="tab-nav tab-nav2 clearfix">
							<li>
								<a href="#tabs-basket-items">
									<?=Loc::getMessage("SALE_BASKET_ITEMS")?>
									(<?=$normalCount?>)
								</a>
							</li>
							<li>
								<a href="#tabs-delayed-items" <?=$delayHidden?>>
									<?=Loc::getMessage("SALE_BASKET_ITEMS_DELAYED")?>
									(<?=$delayCount?>)
								</a>
							</li>
							<li>
								<a href="#tabs-subscribed-items" <?=$subscribeHidden?>>
									<?=Loc::getMessage("SALE_BASKET_ITEMS_SUBSCRIBED")?>
									(<?=$subscribeCount?>)
								</a>
							</li>
							<li>
								<a href="#tabs-available-items" <?=$naHidden?>>
									<?=Loc::getMessage("SALE_BASKET_ITEMS_NOT_AVAILABLE")?>
									(<?=$naCount?>)
								</a>
							</li>
						</ul>
						<div class="tab-container">
							<div class="tab-content clearfix" id="tabs-basket-items">
								<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
								?>
							</div>
							<div class="tab-content clearfix" id="tabs-delayed-items">
								<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
								?>
							</div>
							<div class="tab-content clearfix" id="tabs-subscribed-items">
								<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribed.php");
								?>
							</div>
							<div class="tab-content clearfix" id="tabs-available-items">
								<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_not_available.php");
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="BasketOrder" value="BasketOrder" />
			<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
		</form>
	<?
}
else
{
?>
    <i class="icon-cart fleft" style="font-size: 96px;"></i>
    <div class="topmargin-sm leftmargin-sm" style="display: inline-block; width: 75%;">
        <?=Loc::getMessage("SALE_BASKET_YOU_CART_EMPTY")?>
    </div>
<?
}
?>