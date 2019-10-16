<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>
<?if (!empty($arResult)):?>
<ul class="noleftpadding">
<?
foreach($arResult as $keyItem => $arItem):?>
	<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
<?endforeach?>
</ul>
<?endif?>