<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;
use \Boxsol\CosmoFashion\Template;
define("COSMOS_MODULE_NAME", "boxsol.cosmofashion");
CJSCore::Init();
Loc::loadMessages(__FILE__);
$arCurrentSite = CSite::GetByID(SITE_ID)->Fetch();
$request = Application::getInstance()->getContext()->getRequest();

CModule::IncludeModule(COSMOS_MODULE_NAME);
?><!DOCTYPE html>
<html dir="ltr" lang="<?= $arCurrentSite["LANGUAGE_ID"] ?>">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5BMPJ9L');</script>
<!-- End Google Tag Manager -->
    <!-- Stylesheets
    ============================================= -->
    <link rel="shortcut icon" href="<?= SITE_DIR ?>favicon.ico">
    <script>
        boxsolCosmos = {
            countDownLabels: <?=Loc::getMessage("HEADER_COUNTDOWN_LABLES");?>,
            cosmosSiteDir: "<?=SITE_DIR?>",
        };

    </script>
    <?
    $APPLICATION->ShowHead();

    Template::getInstance()->setLessVars(array("site-template-path" => "'" . SITE_TEMPLATE_PATH . "'"));
    CCosmoFashion::init();
    Template::getInstance()->showFont();
    ?>

    <meta property="og:title" content="<?=$APPLICATION->ShowTitle();?>"/>
    <meta property="og:description" content="<?=$APPLICATION->ShowProperty("description");?>"/>
    <meta property="og:image" content="<?=$APPLICATION->ShowProperty("ogimage");?>">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content= "<?=$request->getRequestUri();?>" />

    <script>
        BX.message({
            "HEADER_LIGHTBOX_COUNTER": "<?=GetMessageJs("HEADER_LIGHTBOX_COUNTER")?>"
        });
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- External JavaScripts
    ============================================= -->
    <?
    ?>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&amp;subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/style_new.css">
    <title><? $APPLICATION->ShowTitle() ?></title>
</head>
<?

$bodyClass = "";
$isUseBasket = Template::getInstance()->getOption("use_basket");


if (Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'use_transition', 'N') == 'N') $bodyClass .= " no-transition";
if (Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'use_smooth_scroll', 'N') == 'N') $bodyClass .= " no-smooth-scroll";

//$headerType = Template::self::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'type_big_header', 1);
$headerType = Template::getInstance()->getOption('type_big_header');

$headerClass = "";
$headerAdditional = "";
$menuClass = "";
$menuClass = Template::getInstance()->getOption('menu_type');
$menuBgColor = Template::getInstance()->getOption('bgcolor_menu');

if (Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'dark_dropdown_menu', 'N') == 'Y') $menuClass .= " dark";

/*
 * пока не работает, есть возможность задать только для главной страницы
if (Template::getInstance()->getOption("transparent")) $headerClass .= " transparent-header";*/

if (Template::getInstance()->getOption("dark_menu"))
    $headerAdditional .= ' data-sticky-class="dark"';
else
    $headerAdditional .= ' data-sticky-class="not-dark"';

$menuClassForBody = $menuClass;
if ($headerType === true)
{
    if ($menuBgColor)
    {
        $menuClass .= ' bgcolor';
    }
}
if ($headerType == false && $menuBgColor)
{
    $headerClass .= ' bgcolor';
}

$showTopSearch = Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'show_top_search', 'Y');
$showTopBar = Template::getInstance()->getOption('show_top_bar');

$headerClass = Template::getInstance()->getHeaderClass();
?>
<body <?= Template::getInstance()->getBodyClass(); ?> <? //header-type-<?=$headerType.'-'.$menuClassForBody?>  <? $APPLICATION->ShowProperty("backgroundImage") ?>
        data-loader="1" data-animation-in="fadeIn" data-speed-in="1000" data-animation-out="fadeOut"
        data-speed-out="300">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BMPJ9L"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script>
    isUseBasket = "<?=$isUseBasket?>";
</script>
<? $APPLICATION->ShowPanel(); ?>
<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">
    <? if ($showTopBar == 'Y'): ?>
        <!-- Top Bar
    ============================================= -->
        <div id="top-bar">
            <div class="container clearfix top-bar__inner header__top-bar">
                <div class="col_half nobottommargin top-bar__links-wrapper">
                    <!-- Top Links
                    ============================================= -->
                    <div class="top-links">
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/header/top_links.php",
                            Array(),
                            Array("MODE" => "html")
                        );
                        ?>
                    </div><!-- .top-links end -->
                </div>

                <div class="top-bar__menu-wrapper">
                    <ul class="top-bar__menu">
                        <li class="top-bar__menu-item">
                            <a href="/sale/" class="top-bar__menu-link">Акции</a>
                        </li>
                        <li class="top-bar__menu-item">
                            <a href="/about/" class="top-bar__menu-link">О бренде</a>
                        </li>
                        <li class="top-bar__menu-item">
                            <a href="/about/howto/" class="top-bar__menu-link">Опт</a>
                        </li>
                        <li class="top-bar__menu-item">
                            <a href="/about/delivery/" class="top-bar__menu-link">Доставка и оплата</a>
                        </li>
                        <li class="top-bar__menu-item">
                            <a href="/contacts/" class="top-bar__menu-link">Контакты</a>
                        </li>
                        <li class="top-bar__menu-item">
                            <a href="/how_to_order/" class="top-bar__menu-link">Как оформить заказ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #top-bar end -->
    <? endif; ?>
    <!-- Header
    ============================================= -->
    <header id="header" class="<?= $headerClass ?>"<?= $headerAdditional ?>>
        <? if ($headerType == false) : ?>
        <div id="header-wrap">
            <? endif; ?>
            <div class="container clearfix header__middle-bar">

                <!-- Logo
                ============================================= -->
                <div id="logo" class="middle-bar__logo">
                    <a href="<?= SITE_DIR ?>" class="standard-logo">
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/header/logo.php",
                            Array(),
                            Array("MODE" => "html")
                        );
                        ?>
                    </a>
                    <a href="<?= SITE_DIR ?>" class="retina-logo">
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/header/logo.php",
                            Array(),
                            Array("MODE" => "html")
                        );
                        ?>
                    </a>
                </div><!-- #logo end -->

                <? if ($headerType === true) : ?>
                    <div id="logo-slogan" class="hidden-md hidden-sm hidden-xs">
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/header/slogan.php",
                            Array(),
                            Array("MODE" => "html")
                        );
                        ?>
                    </div>

                    <div class="middle-bar__social">
                        <ul class="middle-bar__social-list">
                            <li class="middle-bar__social-item">
                                <a href="https://www.instagram.com/minidino_official/" class="middle-bar__social-link middle-bar__social-link--instagram">
                                    <img class="middle-bar__social-icon--black" width="28" alt="Мы в Instagram" src="/images/instagram-logo.svg" height="28" title="Мы в Instagram">
                                    <img class="middle-bar__social-icon--white" width="28" alt="Мы в Instagram" src="/images/instagram-logo-white.svg" height="28" title="Мы в Instagram">
                                </a>
                            </li>
                        </ul>
                    </div>

                    <ul class="header-extras">
                        <li>
                            <div class="middle-bar__search-wrapper">
                                <?
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/header/search.php",
                                    Array(),
                                    Array("MODE" => "html")
                                );
                                ?>
                            </div>
                        </li>
                        <!--<li>
                            <?/*
                            $APPLICATION->IncludeFile(
                                SITE_DIR . "include/header/third_col.php",
                                Array(),
                                Array("MODE" => "html")
                            );
                            */?>
                        </li>-->
                        <!-- бесплатная доставка. отсутствует в новом макете. комментарий добавлен 13.05.19 -->                        
                    </ul>

                    <div class="col_half fright col_last nobottommargin middle-bar__user-menu-wrapper">
                        <?
                        // LATER will be added option for registration
                        if (COSMOS_MODULE_NAME == "boxsol.cosmos") :
                            ?>
                            <div id="top-social">
                                <?
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/header/top_social.php",
                                    Array(),
                                    Array("MODE" => "html")
                                );
                                ?>
                            </div>
                        <? else: ?>
                        
                        <!-- Top Login
                        ============================================= -->
                        <div class="top-links top-links-login middle-bar__user-menu">
                            <ul>
                            <? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "cosmos", Array(
                                "REGISTER_URL" => SITE_DIR . "auth/",
                                "PROFILE_URL" => SITE_DIR . "personal/",
                                "SHOW_ERRORS" => "N",
                            ),
                                false
                            ); ?>
                            <?$APPLICATION->IncludeComponent('bitrix:sale.basket.basket.small','icon',array());?>
                            </ul>
                        </div><!-- #top-social end -->
                        <? endif; ?>
                    </div>
                    <!-- юзер-меню. переделываю на html/css. комментарий добавлен 13.05.19 -->

                    <!--<div class="middle-bar__user-menu">
                        <ul class="user-menu__list">
                            <li class="user-menu__item">
                                <a href="/auth/" class="user-menu__link">Войти</a>
                            </li>
                        </ul>
                    </div>-->
                <? endif; ?>

                <? if ($headerType === true) : ?>
            </div><!--container clearfix-->
            
            <div id="header-wrap">
                <div class="container">
                    <div class="mobile-menu__wrapper">
                        <button class="mobile-menu__button"></button>
                        <nav class="mobile-menu__list-wrapper">
                            <ul class="mobile-menu__list">
                                <li class="mobile-menu__item">
                                    <a href="/catalog/" class="mobile-menu__link">Каталог</a>
                                </li>
                                <li class="mobile-menu__item">
                                    <a href="/sale/" class="mobile-menu__link">Акции</a>
                                </li>
                                <li class="mobile-menu__item">
                                    <a href="/about/" class="mobile-menu__link">О бренде</a>
                                </li>
                                <li class="mobile-menu__item">
                                    <a href="/about/howto/" class="mobile-menu__link">Опт</a>
                                </li>
                                <li class="mobile-menu__item">
                                    <a href="/about/delivery/" class="mobile-menu__link">Доставка и оплата</a>
                                </li>
                                <li class="mobile-menu__item">
                                    <a href="/vozvrat.php" class="mobile-menu__link">Возврат</a>
                                </li>
                                <li class="mobile-menu__item">
                                    <a href="/contacts/" class="mobile-menu__link">Контакты</a>
                                </li>
                                <li class="mobile-menu__item">
                                    <a href="/how_to_order/" class="mobile-menu__link">Как оформить заказ</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <script>
                        var mobileMenu = document.querySelector(".mobile-menu__list-wrapper");
                        var mobileToggler = document.querySelector(".mobile-menu__button");
                        mobileToggler.addEventListener('click', function() {
                            mobileMenu.classList.toggle('_opened');
                        });
                    </script>
                </div>


                <? endif; ?>
                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu" class="<?= $menuClass ?>">
                    <? if ($headerType === true) : ?>
                    <div class="container clearfix">
                        <? endif; ?>
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/header/menu.php",
                            Array(),
                            Array(
                                "MODE" => "html",
                                "SHOW_BORDER" => false
                            )
                        );
                        ?>
                        <div id="top-cart" class="top-cart hidden-lg hidden-md">
                            <a href="<?=SITE_DIR?>personal/cart/" ><i class="icon-cart"></i></a>
                        </div>
                            <? if ($showTopSearch == 'Y'): ?>
                            <!-- Top Search
                            ============================================= -->
                            <div id="top-search">
                                <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i
                                            class="icon-line-cross"></i></a>

                                <form action="<?= SITE_DIR ?>catalog/search.php" method="get">
                                    <input type="text" name="q" class="form-control" value=""
                                           placeholder="<?= Loc::getMessage("SEACTH_LINE") ?>">
                                </form>
                            </div><!-- #top-search end -->
                        <? endif; ?>
                        <? if ($headerType === true) : ?>
                    </div><!--container clearfix-->
                <? endif; ?>
                </nav><!-- #primary-menu end -->
                <? if ($headerType === true) : ?>
            </div><!--header-wrap-->
        <? endif; ?>

            <? if ($headerType == false) : ?>
        </div><!--container clearfix-->
</div><!--header-wrap-->
<?endif;?>

</header><!-- #header end -->

<? if ($APPLICATION->GetDirProperty("show_submenu") == "Y") :?>
<? $APPLICATION->IncludeComponent("bitrix:menu", "page_submenu", array(
    "ROOT_MENU_TYPE" => "left",
    "MAX_LEVEL" => "3",
    "CHILD_MENU_TYPE" => "left_sub",
    "USE_EXT" => "Y",
    "MENU_CACHE_TYPE" => "A",
    "MENU_CACHE_TIME" => "36000000",
    "MENU_CACHE_USE_GROUPS" => "Y",
    "MENU_CACHE_GET_VARS" => ""
),
    false,
    array(
        "HIDE_ICONS" => "Y",
        "ACTIVE_COMPONENT" => "Y"
    )
); ?>
<?endif;?>
<?
//$pageTitleContent = Template::getInstance()->getOption('page_title_content');
$pageTitleContent = Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'page_title_content', 'onpage');

if ($APPLICATION->GetCurPage(true) !== SITE_DIR . "index.php"
&& $APPLICATION->GetDirProperty("hide_breadcrumbs") !== 'Y'
):
?>
<section id="page-title" <?= Template::getInstance()->getPageTitleClass(); ?>>
    <?
    if ($ptBG = Template::getInstance()->getPageTitleBG())
        echo $ptBG;
    ?>
    <div class="container clearfix">
        <? if ($pageTitleContent == "withbreadcrump"): ?>
            <h1 class="nott"><? $APPLICATION->ShowTitle(true) ?></h1>
            <?= ($APPLICATION->GetDirProperty("pt_subtext")) ? "<span>" . $APPLICATION->GetDirProperty("pt_subtext") . "</span>" : ""; ?>
        <? endif; ?>

        <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "marsd", array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => "-"
        ),
            false,
            Array('HIDE_ICONS' => 'N')
        ); ?>
    </div>
</section>
<? endif; ?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "page",
        "AREA_FILE_SUFFIX" => "header",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_TEMPLATE" => ""
    ),
    false
);
?><?
$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "page",
        "AREA_FILE_SUFFIX" => "promo",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_TEMPLATE" => ""
    ),
    false
);
?>
<section id="content">
    <div class="content-wrap notoppadding topmargin-sm">
        <? if ($APPLICATION->GetCurPage(true) !== SITE_DIR . "index.php" && ($APPLICATION->GetDirProperty("left_sidebar") == 'Y' || $APPLICATION->GetDirProperty("right_sidebar") == 'Y')): ?>
        <div class="container clearfix">
            <? endif; ?>
            <? if ($APPLICATION->GetDirProperty("left_sidebar") == 'Y'): ?>
                <div class="sidebar nobottommargin clearfix">
                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        Array(
                            "AREA_FILE_SHOW" => "sect",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => ""
                        ),
                        false
                    );
                    ?>
                    <? $APPLICATION->ShowViewContent('catalog_smart_filter_left'); ?>
                </div>
            <? endif; ?>
            <!-- Post Content
            ============================================= -->
            <? if ($APPLICATION->GetDirProperty("left_sidebar") == 'Y' && $APPLICATION->GetDirProperty("right_sidebar") == 'Y'): ?>
            <div class="postcontent bothsidebar nobottommargin">
                <? elseif ($APPLICATION->GetDirProperty("left_sidebar") == 'Y'): ?>
                <div class="postcontent col_last nobottommargin">
                    <? elseif ($APPLICATION->GetDirProperty("right_sidebar") == 'Y'): ?>
                    <div class="postcontent nobottommargin">
                        <? else: ?>
                        <div class="container nobottommargin">
                            <? endif; ?>

                            <?
                            if ($APPLICATION->GetCurPage(true) !== SITE_DIR . "index.php"
                                && $APPLICATION->GetDirProperty("hide_breadcrumbs") !== 'Y'
                            ):?>
                                <? if ($pageTitleContent != "withbreadcrump"): ?>
                                    <h1 class="nott"><? $APPLICATION->ShowTitle(true) ?></h1>
                                <? endif; ?>
                            <? endif; ?>
                            <div id="header-notify" data-notify-type="info" data-notify-msg=""></div>
                            <?
                            $isAjax = $request->getQuery("cosmos_ajax");

                            /*   for get order ID    */
                            $isAjaxAJAX_QUICK_CONTACT = $request->getQuery("AJAX_QUICK_CONTACT");
                            $isAjaxCODE = $request->getQuery("CODE");
                            $isAjaxEdit = $request->getQuery("edit");
                            if ($isAjax && $isAjaxAJAX_QUICK_CONTACT == "Y" && $isAjaxCODE && $isAjaxEdit == "Y")
                            {
                                $APPLICATION->RestartBuffer();
                                echo $isAjaxCODE;
                                die();
                            }
                            /*   end      */

                            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $isAjax == "Y")
                            {
                                define(COSMOS_MODULE_AJAX_REQUEST, true);
                            $APPLICATION->RestartBuffer();
                            ?>
                            <div class="shop-quick-view-ajax clearfix wide-ajax-modal" id="<?= $strModalId ?>">

                                <div class="ajax-modal-title">
                                    <h2><? $APPLICATION->ShowTitle(true) ?></h2>
                                </div>
                                <div class="modal-padding clearfix">
                                    <div class="col_full nobottommargin">
                                        <?
                                        }
                                        ?>

