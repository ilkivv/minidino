<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if (!empty($arResult)):?>
<div class="list-group">
<?
$previousLevel = 0;
$showChilds = false;
foreach($arResult as $arItem):?>
    <?if ($arItem["IS_PARENT"]):?>
        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
            <?($arItem["SELECTED"])? $showChilds=true : $showChilds=false;?>
            <a href="<?=$arItem["LINK"]?>" class="list-group-item <?if ($arItem["SELECTED"]):?>active<?endif?>">
                <?=$arItem["TEXT"]?>
                <i class="icon-angle-<?=($arItem["SELECTED"])? 'down':'right';?> fright"></i>
            </a>
        <?else:?>
            <a href="<?=$arItem["LINK"]?>" class="list-group-item <?if ($arItem["SELECTED"]):?>active<?endif?>">
                <?=$arItem["TEXT"]?>
                <i class="icon-angle-<?=($arItem["SELECTED"])? 'down':'right';?> fright"></i>
            </a>
        <?endif?>
    <?else:?>
        <?if ($arItem["PERMISSION"] > "D"):?>
            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <a class="list-group-item <?if ($arItem["SELECTED"]):?>active<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            <?elseif($showChilds):?>
                <a class="list-group-item-child <?if ($arItem["SELECTED"]):?>active<?endif?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            <?endif?>
        <?else:?>
            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <a href="" class="list-group-item <?if ($arItem["SELECTED"]):?>active<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a>
            <?elseif($showChilds):?>
                <a href="" class="list-group-item-child <?if ($arItem["SELECTED"]):?>active<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a>
            <?endif?>
        <?endif?>
    <?endif?>
    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
<?endforeach?>
</div>
<?endif?>