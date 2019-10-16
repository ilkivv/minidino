<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

?><ul><?
foreach($arResult as $arItem):?>
<?if($arItem["DEPTH_LEVEL"] == 1){
?>
 <li class="mega-menu-title"><a href="<?=$arItem["LINK"]?>" class="parent">
                <div><?=$arItem["TEXT"]?></div></a></li>
<?

} ?>
<?
endforeach;
?></ul><?
return;
use Boxsol\CosmoFashion\Template;

if (empty($arResult)) return;?>
<?
CModule::IncludeModule(COSMOS_MODULE_NAME);
$this->setFrameMode(true);
$showIcons = Template::getInstance()->getOption('show_icons_menu');
$showSubText = "N";
$showAngle = "Y";

$menuType = Template::getInstance()->getOption('menu_type');
if ($menuType == "sub-title")
{
    $showSubText = "Y";
    $showIcons = "N";
}
elseif ($menuType == "style-5")
{
    $showIcons = "Y";
    $showAngle = "N";
}

?>
<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
<ul class="marsd-menu">
<?
$useMegaMenu = false;
$previousLevel = 0;
foreach($arResult as $arItem):?>

    <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
        <?if ($arItem["DEPTH_LEVEL"] == 1 && $useMegaMenu) :?>
            <?
            echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"] - 1));
            $useMegaMenu = false;
            ?>
            </ul></div></li>
        <? elseif($arItem["DEPTH_LEVEL"] == 1 && !$useMegaMenu):?>
            <?
            echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
            ?>
        <?else:?>
            <?=str_repeat('</ul></li></ul><ul class="mega-menu-column col-md-4">', ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
        <?endif?>
    <?endif?>

    <?if ($arItem["IS_PARENT"]):?>

        <?if ($arItem["DEPTH_LEVEL"] == 1):?>

            <?if ($arItem["PARAMS"]["USE_MEGA_MENU"] == "Y") :?>
                <?$useMegaMenu = true;?>
                <li class="mega-menu<?if ($arItem["SELECTED"]):?> current<?endif?>"><a href="<?=$arItem["LINK"]?>">
                    <div><?
                        if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"]))
                        {
                            echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
                        }
                        echo $arItem["TEXT"];
                        if ($showAngle == "Y")
                        {
                            echo '<i class="icon-angle-down"></i>';
                        }
                        ?>
                    </div><?
                        if ($showSubText == "Y") {
                            echo '<span>' . $arItem["PARAMS"]["subtext"] . '&nbsp;</span>';
                        }?></a>
                        <div class="mega-menu-content style-2 clearfix">
                            <ul class="mega-menu-column col-md-4">
            <? else : ?>
                <li><a href="<?=$arItem["LINK"]?>">
                    <div><?
                        if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"]))
                        {
                            echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
                        }
                        echo $arItem["TEXT"];
                        if ($showAngle == "Y")
                        {
                            echo '<i class="icon-angle-down"></i>';
                        }
                        ?>
                    </div><?
                        if ($showSubText == "Y") {
                            echo '<span>' . $arItem["PARAMS"]["subtext"] . '&nbsp;</span>';
                        }?></a>
                        <ul>
            <? endif; ?>

        <?else:?>
            <li class="mega-menu-title"><a href="<?=$arItem["LINK"]?>" class="parent">
                <div><?=$arItem["TEXT"]?></div></a>
                    <ul>
        <?endif?>

    <?else:?>

        <?if ($arItem["DEPTH_LEVEL"] == 1):?>

            <?if ($arItem["PARAMS"]["USE_MEGA_MENU"] == "Y") :?>

                <li class="mega-menu<?if ($arItem["SELECTED"]):?> current<?endif?>"><a href="<?=$arItem["LINK"]?>">
                    <div><?
                        if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"]))
                        {
                            echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
                        }
                        echo $arItem["TEXT"];
                        ?>
                    </div></a>
                        <div class="mega-menu-content style-2 clearfix">
                            <?foreach($arItem["PARAMS"]["WIDGETS"] as $widgetPath) : ?>
                                <ul class="mega-menu-column col-md-4">
                                    <li>
                                        <div class="widget clearfix">
                                            <?
                                            $APPLICATION->IncludeFile(
                                                $widgetPath,
                                                Array(),
                                                Array("MODE" => "html")
                                            );
                                            ?>
                                        </div>
                                    </li>
                                </ul>
                            <?endforeach;?>
                        </div>
            <?else : ?> 
                <li class="<?if ($arItem["SELECTED"]):?> current<?endif?>">
                    <a href="<?=$arItem["LINK"]?>">
                        <div><?
                            if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"]))
                            {
                                echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
                            }
                            echo $arItem["TEXT"];

                            ?></div>
                        <?
                        if ($showSubText == "Y") {
                            echo '<span>' . $arItem["PARAMS"]["subtext"] . '&nbsp;</span>';
                        }?>
                    </a>
                </li>
            <?endif;?>
        <? elseif($arItem["DEPTH_LEVEL"] == 2 && $useMegaMenu):?>
            <li class="mega-menu-title sub-menu<?if ($arItem["SELECTED"]):?> current<?endif?>">
                <a href="<?=$arItem["LINK"]?>">
                    <div><?=$arItem["TEXT"]?></div>
                </a>
            </li>
        <?else:?>
            <li class="<?if ($arItem["SELECTED"]):?> current<?endif?>">
                <a href="<?=$arItem["LINK"]?>">
                    <div class="nott"><?=$arItem["TEXT"]?></div>
                </a>
            </li>
        <?endif?>

    <?endif?>

    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
    <?if ($arItem["DEPTH_LEVEL"] == 1 && $useMegaMenu) :?>
        <?
        echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"] - 1));
        $useMegaMenu = false;
        ?>
        </ul></div></li>
    <? elseif($arItem["DEPTH_LEVEL"] == 1 && !$useMegaMenu):?>
        <?
        echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
        ?>
    <?else:?>
        <?=str_repeat('</ul></li></ul><ul class="mega-menu-column col-md-4">', ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
    <?endif?>
<?endif?>

</ul>
<div class="menu-clear-left"></div>