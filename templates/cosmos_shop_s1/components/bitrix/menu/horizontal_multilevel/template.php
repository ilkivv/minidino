<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Boxsol\CosmoFashion\Template;
if (!empty($arResult)):?>
    <?
    CModule::IncludeModule(COSMOS_MODULE_NAME);
    $this->setFrameMode(true);
    $showIcons = Template::getInstance()->getOption('show_icons_menu');
    $showSubText = "N";
    $showAngle = "Y";

    $menuType = Template::getInstance()->getOption('menu_type');
    if ($menuType == "sub-title") {
        $showSubText = "Y";
        $showIcons = "N";
    } elseif ($menuType == "style-5") {
        $showIcons = "Y";
        $showAngle = "N";
    }

    ?>
    <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
    <ul class="marsd-menu">
    <?
    $previousLevel = 0;
foreach ($arResult as $arItem) { ?>
    <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
        <?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
    <? endif ?>
    <? if ($arItem["IS_PARENT"]): ?>
    <? if ($arItem["DEPTH_LEVEL"] == 1): ?>
    <li<? if ($arItem["SELECTED"]):?> class="current"<? endif ?>><a href="<?= $arItem["LINK"] ?>">
        <div><?
            if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"])) {
                echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
            }
            echo $arItem["TEXT"];
                if ($showAngle == "Y") {
                echo '<i class="icon-angle-down"></i>';
            }
            ?></div><?
        if ($showSubText == "Y") {
            echo '<span>' . $arItem["PARAMS"]["subtext"] . '&nbsp;</span>';
        }?>
    </a>
    <ul>
    <? else: ?>
    <li<? if ($arItem["SELECTED"]):?> class="current"<? endif ?>><a href="<?= $arItem["LINK"] ?>" class="parent">
        <div class="nott"><?
            if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"])) {
                echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
            }?><?= $arItem["TEXT"] ?></div>
    </a>
    <ul>
    <? endif ?>
    <? else:?>
        <? if ($arItem["PERMISSION"] > "D"):?>
            <? if ($arItem["DEPTH_LEVEL"] == 1):?>
                <?
                $hrefLink = 'href="' . $arItem["LINK"] . '"';
                if ($arItem["LINK"][0] == '#') {
                    $hrefLink = 'href="#" data-scrollto="' . $arItem["LINK"] . '"';
                }
                ?>
                <li<? if ($arItem["SELECTED"]):?> class="current"<? endif ?>><a <?= $hrefLink ?>>
                        <div><?
                            if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"])) {
                                echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
                            }
                            echo $arItem["TEXT"];
                            ?></div><?
                        if ($showSubText == "Y") {
                            echo '<span>' . $arItem["PARAMS"]["subtext"] . '&nbsp;</span>';
                        }?>
                    </a></li>
            <? else:?>
                <li<? if ($arItem["SELECTED"]):?> class="current"<? endif ?>><a href="<?= $arItem["LINK"] ?>">
                        <div class="nott"><?
                            if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"])) {
                                echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
                            }?><?= $arItem["TEXT"] ?></div>
                    </a></li>
            <? endif ?>
        <? else:?>
            <? if ($arItem["DEPTH_LEVEL"] == 1):?>
                <li<? if ($arItem["SELECTED"]):?> class="current"<? endif ?>><a href=""
                                                                                title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>">
                        <div class="nott"><?= $arItem["TEXT"] ?></div>
                    </a></li>
            <? else:?>
                <li><a href="" class="denied" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>">
                        <div class="nott"><?
                            if ($showIcons == "Y" && isset($arItem["PARAMS"]["icon"])) {
                                echo '<i class="icon-' . $arItem["PARAMS"]["icon"] . '"></i>';
                            }?><?= $arItem["TEXT"] ?></div>
                    </a></li>
            <? endif ?>
        <? endif ?>
    <? endif ?>
    <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>
<? } ?>
    <? if ($previousLevel > 1)://close last item tags
        ?>
        <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
    <? endif ?>
    </ul>
<? endif ?>
        <script>
            var CosmosMenuFlexInit = function() {
                var flexMenuInit = $('ul.marsd-menu').flexMenu({
                    'linkText' : "<?=\Bitrix\Main\Localization\Loc::getMessage("MENU_SHOW_MORE")?>",
                    'linkTitle': "<?=\Bitrix\Main\Localization\Loc::getMessage("MENU_SHOW_MORE_TITLE")?>",
                    'menuType': '<?=$menuType?>',
                    'showAngle': '<?=$showAngle?>',
                    'showSubText': '<?=$showSubText?>',
                    'showIcons' : '<?=$showIcons?>'
                });
            };
            $(document).ready(function () {
                CosmosMenuFlexInit();
            });

            var $cosmosPrimaryMenuElement = $("#primary-menu");
            var cosmosPrimaryMenuLastHeight = $("#primary-menu").css('height');
            function checkForChanges()
            {
                if ($cosmosPrimaryMenuElement.css('height') != cosmosPrimaryMenuLastHeight)
                {
                    $(function(){
                        $(window).trigger('resize');
                    });
                    //CosmosMenuFlexInit();
                    cosmosPrimaryMenuLastHeight = $cosmosPrimaryMenuElement.css('height');
                }
                setTimeout(checkForChanges, 50);
            }
            checkForChanges();
        </script>
