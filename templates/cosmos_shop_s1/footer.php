
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Application;
use Boxsol\CosmoFashion\Template;

Loc::loadMessages(__FILE__);

$request = Application::getInstance()->getContext()->getRequest();
$isAjax = $request->getQuery("cosmos_ajax");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $isAjax == "Y"
)
{
    ?>
    </div></div></div>
    <script type="text/javascript">

    </script>
    <?
    die();
}
?>
</div><!-- postcontent - or container -->
<? if ($APPLICATION->GetDirProperty("right_sidebar") == 'Y'): ?>
    <div class="sidebar col_last nobottommargin clearfix">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            ".default",
            Array(
                "AREA_FILE_SHOW" => "sect",
                "AREA_FILE_SUFFIX" => "rinc",
                "AREA_FILE_RECURSIVE" => "Y",
                "EDIT_TEMPLATE" => ""
            ),
            false
        );
        ?>
        <? if ($APPLICATION->GetDirProperty("left_sidebar") !== 'Y'): ?>
            <? $APPLICATION->ShowViewContent('catalog_smart_filter_left'); ?>
        <? endif; ?>
    </div>
<? endif; ?>
<? if ($APPLICATION->GetCurPage(true) !== SITE_DIR . "index.php" && ($APPLICATION->GetDirProperty("left_sidebar") == 'Y' || $APPLICATION->GetDirProperty("right_sidebar") == 'Y')): ?>
    </div><!-- container clearfix -->
<? endif; ?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "page",
        "AREA_FILE_SUFFIX" => "about",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_TEMPLATE" => ""
    ),
    false
);
?>

<?
$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "page",
        "AREA_FILE_SUFFIX" => "footer",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_TEMPLATE" => ""
    ),
    false
);
?>

</div><!-- content-wrap -->

</section><!-- content -->
<!-- Footer
============================================= -->
<footer id="footer"<? if (Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'show_dark_footer', 'N') == 'Y') : ?> class="dark"<? endif; ?>>

    <? if (Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'show_big_footer', 'N') == 'Y') : ?>
        <div class="container">

            <!-- Footer Widgets
            ============================================= -->
            <div class="footer-widgets-wrap clearfix">

                <div class="row clearfix">
                    <div class="col_two_third">

                        <div class="col_two_third">

                            <div class="widget clearfix">
                                <?
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/footer/instagram.php",
                                    Array(),
                                    Array("MODE" => "html")
                                );
                                ?><?
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/footer/info.php",
                                    Array(),
                                    Array("MODE" => "html")
                                );
                                ?>
                            </div>
                        </div>

                        <div class="col_one_third col_last">

                            <div class="widget clearfix">
                                <?
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/footer/posts.php",
                                    Array(),
                                    Array("MODE" => "html")
                                );
                                ?>
                            </div>

                        </div>

                    </div>

                    <div class="col_one_third col_last">
                        <? /*
						<div class="widget subscribe-widget clearfix">
							$APPLICATION->IncludeFile(
									SITE_DIR . "include/footer/subscribe.php",
									Array(),
									Array("MODE" => "html")
							);
						</div>
					*/ ?>
                        <div class="widget clearfix" style="margin-bottom: -20px;">
                            <?
                            $APPLICATION->IncludeFile(
                                SITE_DIR . "include/footer/social_block.php",
                                Array(),
                                Array("MODE" => "html")
                            );
                            ?>
                        </div>

                    </div>
                </div>

            </div>
            <!-- .footer-widgets-wrap end -->

        </div>
    <? endif; ?>
    <!-- Copyrights
    ============================================= -->
    <div id="copyrights">

        <div class="container clearfix">

            <div class="footer__row">
                <div class="col_two_third nobottommargin footer__navigation">
                    <?
                    $APPLICATION->IncludeFile(
                        SITE_DIR . "include/footer/links_horizontal.php",
                        Array(),
                        Array("MODE" => "html")
                    );
                    ?>
                </div>
                
                <div class="footer__payment footer-payment">
                   <?php /*?> <h2 class="footer-payment__title">Способы оплаты</h2>
                    <div class="footer-payment__image-wrapper">
                        <img src="/images/visa.png" alt="visa" class="footer-payment__image--visa" width="55" height="20">
                        <img src="/images/mastercard.png" alt="mastercard" class="footer-payment__image--mastercard" width="36" height="28">
                        <img src="/images/mir.png" alt="mir" class="footer-payment__image--mir" width="55" height="16">
                        <img src="/images/jcb.png" alt="jcb" class="footer-payment__image--jcb" width="36" height="28">
                    </div>
                    <p class="footer-payment__text">Также вы можете оплатить покупки наличными при получении, либо выбрать другой способ оплаты.</p>
                    */?>
                </div>
                
                <div class="col_one_third col_last visible-lg visible-md footer__contacts footer-contacts">
                    <div class="widget clearfix fright footer-contacts__inner">
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/footer/contacts.php",
                            Array(),
                            Array("MODE" => "html")
                        );
                        ?>
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/footer/metrika.php",
                            Array(),
                            Array("MODE" => "html")
                        );
                        ?>
                        <div id="bx-composite-banner"></div>
                    </div>
                    <div class="visible-sm visible-xs bottommargin-sm"></div>
                </div>
                
                <div class="col_one_third col_last nobottommargin footer__social">
                    <div class="clearfix">
                        <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/footer/social.php",
                            Array(),
                            Array("MODE" => "html")
                        );
                        ?>
                    </div>
                </div>
            </div>

            <div class="line topmargin-md bottommargin-sm footer__line"></div>

            <div class="col_two_third nobottommargin footer__copyright footer-copyright">
                <div class="widget clearfix">
                    <div class="clear-bottommargin-sm">
                        <div class="row clearfix">

                            <div class="col-md-6 footer-copyright__inner">
                                <?
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/footer/copyrights.php",
                                    Array(),
                                    Array("MODE" => "html")
                                );
                                ?>
                            </div>

                            <div class="col-md-6">
                                <div class="footer-big-contacts">
                                    <?
                                    $APPLICATION->IncludeFile(
                                        SITE_DIR . "include/footer/call_number.php",
                                        Array(),
                                        Array("MODE" => "html")
                                    );
                                    ?>
                                    <?
                                    $APPLICATION->IncludeFile(
                                        SITE_DIR . "include/footer/worktime.php",
                                        Array(),
                                        Array("MODE" => "html")
                                    );
                                    ?>
                                </div>
                                <div class="visible-xs bottommargin-sm"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="visible-sm visible-xs bottommargin-sm"></div>
            </div>

        </div>

    </div>
    <!-- #copyrights end -->

</footer><!-- #footer end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<? if (!$APPLICATION->GetShowIncludeAreas()) : ?>
    <? if (strpos($APPLICATION->GetCurDir(), "personal/cart/") === false && strpos($APPLICATION->GetCurDir(), "personal/order/") === false): ?>
        <div>
            <?
            \Bitrix\Main\Loader::includeModule("sale");
            CJSCore::Init(array('currency'));
            $allCurrency = CSaleLang::GetLangCurrency(SITE_ID);
            $currencyFormat = CCurrencyLang::GetFormatDescription($allCurrency);
            ?>
            <div class="fly-cart clearfix hidden hidden-sm hidden-xs">
                <div class="fly-cart-head">
                    <div class="fly-cart-trigger icon-cart"><span>0</span></div>
                </div>
                <div class="fly-cart-body clearfix">
                </div>
            </div>
            <?
            Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/components/bitrix/sale.basket.basket/cosmos/script.js");
            Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/components/bitrix/sale.basket.basket/cosmos/style.css");
            ?>
        </div>
    <? endif; ?>
<? endif; ?>


<!-- Footer Scripts
============================================= -->
<? if (Option::get("main", "move_js_to_body") === "Y"):
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/functions.js");
else: ?>
    <script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/functions.js"></script>
<? endif; ?>
<?
global $USER;
if (BOXSOL_COSMOS_DEMO === true || $USER->IsAdmin()) :
    ?>
    <? if (Template::getInstance()->isPublicSettingsAvailable()) : ?>
    <? $APPLICATION->IncludeComponent(
        "boxsol:style.swticher",
        "cosmos",
        array(),
        false
    ); ?>
<? endif; ?>
<? endif; ?>
</body>
</html>