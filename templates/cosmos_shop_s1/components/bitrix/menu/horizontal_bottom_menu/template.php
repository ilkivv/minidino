<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>
<?if (!empty($arResult)):?>
<div class="copyrights-menu copyright-links clearfix">
<?
foreach($arResult as $keyItem => $arItem):?>
	<a class="rightmargin-sm noleftmargin" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
<?endforeach?>
</div>
<?endif?>