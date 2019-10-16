<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
if (!empty($arResult)):
?>
<div class="col_full nobottommargin">
	<div class="fancy-title title-bottom-border">
		<h3><?=Loc::getMessage("VIEW_HEADER")?></h3>
	</div>

	<div class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="true" data-items-xxs="1" data-items-sm="2" data-items-lg="4">
	<?foreach($arResult as $arItem):?>
		<div class="oc-item">
			<div class="product iproduct clearfix">
				<div class="product-image">
					<?if($arParams["VIEWED_IMAGE"]=="Y" && is_array($arItem["PICTURE"])):?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PICTURE"]["src"]?>" alt="<?=$arItem["NAME"]?>"></a>
					<?endif?>
				</div>
				<div class="product-desc center">
					<?if($arParams["VIEWED_NAME"]=="Y"):?>
						<div class="product-title"><h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h3></div>
					<?endif?>
					<?if($arParams["VIEWED_PRICE"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
						<div class="product-price"><ins><?=$arItem["PRICE_FORMATED"]?></ins></div>
					<?endif?>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>
<?endif;?>