<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>                <!-- END content -->
            </section>
        </section>

        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "page",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_MODE" => "html",
            ),
            false,
            Array('HIDE_ICONS' => 'Y')
        );?>

        <footer>
            <section class="b-wrapper b-wrapper_dark-grey">
                <section class="b-container">
                    <div class="b-footer__column b-footer__column_big">
                        <?if ($isIndexPage):?>
                            <div class="b-footer__title"><?=COption::GetOptionString('main', 'site_name', '��������-������� STOLNIK')?></div>
                            <?$APPLICATION->IncludeFile(
                                SITE_DIR."include/footer_text.php",
                                array(),
                                Array("MODE" => "html")
                            );?>
                        <?endif;?>
                    </div>

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "footer_bottom",
                        Array(
                            "ROOT_MENU_TYPE" => "bottom",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array()
                        ),
                    false);?>
                    <hr/>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "footer_social_group",
                        Array(
                            "AJAX_MODE" => "N",
                            "IBLOCK_TYPE" => "services",
                            "IBLOCK_ID" => "9",
                            "SECTION_ID" => "",
                            "SECTION_CODE" => "",
                            "SECTION_USER_FIELDS" => array(),
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "FILTER_NAME" => "arrFilter",
                            "INCLUDE_SUBSECTIONS" => "N",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "SECTION_URL" => "",
                            "DETAIL_URL" => "",
                            "BASKET_URL" => "/personal/basket.php",
                            "ACTION_VARIABLE" => "action",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "META_KEYWORDS" => "-",
                            "META_DESCRIPTION" => "-",
                            "BROWSER_TITLE" => "-",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "DISPLAY_COMPARE" => "N",
                            "SET_TITLE" => "N",
                            "SET_STATUS_404" => "N",
                            "PAGE_ELEMENT_COUNT" => "30",
                            "LINE_ELEMENT_COUNT" => "1",
                            "PROPERTY_CODE" => array("LINK"),
                            "PRICE_CODE" => array(),
                            "USE_PRICE_COUNT" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "PRICE_VAT_INCLUDE" => "N",
                            "PRODUCT_PROPERTIES" => array(),
                            "USE_PRODUCT_QUANTITY" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "PAGER_TITLE" => "������",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N"
                        ),
                        false
                    );?>

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "footer_pay_list",
                        Array(
                            "AJAX_MODE" => "N",
                            "IBLOCK_TYPE" => "services",
                            "IBLOCK_ID" => "8",
                            "SECTION_ID" => "",
                            "SECTION_CODE" => "",
                            "SECTION_USER_FIELDS" => array(),
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "FILTER_NAME" => "arrFilter",
                            "INCLUDE_SUBSECTIONS" => "N",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "SECTION_URL" => "",
                            "DETAIL_URL" => "",
                            "BASKET_URL" => "/personal/basket.php",
                            "ACTION_VARIABLE" => "action",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "META_KEYWORDS" => "-",
                            "META_DESCRIPTION" => "-",
                            "BROWSER_TITLE" => "-",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "DISPLAY_COMPARE" => "N",
                            "SET_TITLE" => "N",
                            "SET_STATUS_404" => "N",
                            "PAGE_ELEMENT_COUNT" => "30",
                            "LINE_ELEMENT_COUNT" => "1",
                            "PROPERTY_CODE" => array("LINK"),
                            "PRICE_CODE" => array(),
                            "USE_PRICE_COUNT" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "PRICE_VAT_INCLUDE" => "N",
                            "PRODUCT_PROPERTIES" => array(),
                            "USE_PRODUCT_QUANTITY" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "PAGER_TITLE" => "������",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N"
                        ),
                        false
                    );?>
                </section>
            </section>
            <section class="b-wrapper b-wrapper_darkness">
                <section class="b-container">
                    <div class="dev">
                        <a href="http://evosweb.ru/" target="_blank" title="EVOLUTION STUDIO">���������� �����</a><br />
                        <a href="http://evosweb.ru/Portfolios" target="_blank"><img src="/upload/medialibrary/b85/b85e14c599c5355d243a05bd81707fb7.png" title="EVOLUTION STUDIO" border="0" alt="EVOLUTION STUDIO" width="110" height="42"></a>
                    </div>
                    <div class="copyright">
                        <?$APPLICATION->IncludeFile(
                            SITE_DIR."include/copyright.php",
                            array(),
                            Array("MODE" => "html")
                        );?>
                    </div>
                </section>
            </section>
        </footer>

        <div class="go_top"></div>

        <section class="hidden">
            <div id="added-to-basket">
                <div class="b-fancy-added">
                    <div class="title">����� ������� �������� � �������</div>
                    <div class="g-clear b-btn-group">
                        <a title="����������" class="b-btn close" href="">����������</a>
                        <a title="� �������" class="b-btn" href="/basket/">� �������</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="hidden">
            <div id="oferta">
                <h1 class="title">
                    ��������� ������
                </h1>
                <div class="news-detail">
                    <p><b>�������� �������</b></p>

                    <p><b>������������</b> � ���������� ����, ���������� �����, ����������� ������� ���������� ���������� � �������� ���������� ������ �� ����� <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>����������</b> � ������������, ������������ ����� �� ����� <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>��������</b> � �� ������ �.�. (���͠ <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">313744829000028</span>� ��, ��͠ <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">744830169076</span>� ��, ����� ����������:454080, ������ �.���������, ��.������� 88 ��������).</p>
                    <p><b>��������-�������</b> � ��������-����, ������������� ��������, ������������� � ���� �������� �� ������ <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>, ��� ������������ ������, ������������ ��������� ��� ������������, � ����� ������� ������ � �������� ������� �����������.</p>
                    <p><b>����</b> � <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>. </p>
                    <p><b>�����</b> � �����, ������, ���������� � ���� ������, �������������� � ������� �� ����� ��������.</p>
                    <p><b>�����</b> � ������� ������� ����������� ������ ���������� �� ������������ � �������� �� ���������� ����������� ������ / ����������� ���������� �������, ��������� �� �����.</p>
                    <p><b><font color="#ee1d24">1. ����� ���������</font></b></p>
                    <p><b>1.1.</b> �������� ������������ ������� ������� ����� ��������-������� �� ������ <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>1.2.</b> ��������� ������ ����� ��������-�������, ������������ ����������� � ��������� ������� �������, ����������� ���� (����� � ������� ������� �������). � ������ ���������� � ��������� ���������������� ����������� (����� - ����������) ������������ ������ ���������� ���������� ������������� ������� � �������� ���� <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>1.3.</b> ��������� ������� ������� �������, � ����� ���������� � ������, �������������� �� �����, �������� ��������� ������� � ������������ �� ��.435 � �.2 ��.437 ������������ ������� ���������� ���������.</p>
                    <p><b>1.4.</b> ������������ ����������� � ��������� ������� ������� ����� ������������ ������� � ����� �Ѡ������� ��������� �������� ��� ���������� ������.</p>
                    <p><b>1.5.</b> ���������� ����� ���� �������� ��������� � ������������� ������� ��� ����������� ������������/����������. ����� �������� ���������� �������� � ���� �� ��������� 10 (������) ����������� ���� � ������� �� ������������� �� �����, ���� ���� �� ������������� ��������� ���������� ����������.</p>
                    <p><b>1.6.</b> ���������� �������� � ���� � ������� �������� ���������� ��������� ������������ ������������� �������� ������ ��� ���������� ����������� ������ ��� ����������� �� �����, � ����� � ������� �������� �� ���������� ������ �� �������� 8 (351) 220-12-70 (��� ������� �� ����������) � 8 (800) 33-33-019 (��� ������� �� ��������).</p>
                    <p>������� �������� ���� e-mail, ������������/���������� ���� �������� �� ������������� ��� � ����� ������������� �������� ��������-��������������� ���������, ���������� ���������� � �������, ����������� � ����������� ������ � ���� ������������ ��������.</p>
                    <p><b><font color="#ee1d24">2. ������� ����������</font></b></p>
                    <p><b>2.1.</b> ��������� ���������� ���������� �������� �������������� ����������� ������������ ����������� ��� ������, ��������, �������� � ���� ����, �� ��������� � �������������� ������������������� ������������, ������, �������������� � �������� ��������-�������� �� ������ <a href="http://www.stolnik24.ru."><b>http://www.stolnik24.ru.</b></a></p>
                    <p><b>2.2.</b> ������ ���������� ���������������� �� ��� ���� ������� � �����, �������������� �� �����, ���� ����� ����������� � ��������� ������������ � �������� ��������-��������.</p>
                    <p><b><font color="#ee1d24">3. ����������� �� �����</font></b></p>
                    <p><b>3.1.</b> ����������� �� ����� �������������� �� ������<a href="http://stolnik24.ru/login/?register=yes">http://stolnik24.ru/login/?register=yes</a></p>
                    <p><b>3.2.</b> ����������� �� ����� �� �������� ������������ ��� ���������� ������.</p>
                    <p><b>3.3.</b> �������� �� ����� ��������������� �� �������� � ������������ ����������, ���������������������������� ��� �����������.</p>
                    <p><b>3.4.</b> ������������ ��������� �� �������� ������� ����� ����� � ������, ��������� ������������� ��� �����������. � ������ ������������� � ������������ ���������� ������������ ������������ ��� ������ � ������ ��� ����������� �� �������������������� ������������� �������� ������, ������������ ��������� ��������������� ��������� �� ���� ��������, �������� ��������������� ����������� ������ �� ������: info@stok-stolnik.ru.</p>
                    <p><b>3.5.</b> ������� ������������/���������� � ����������� Call-������ / ����������� � ����� ��������������� �������� ������ ��������� �� ��������� ������������ ������ � ����������������� �������. ������ ��������� ������������� ����������� ����, �����, �������������� ���������, � ����� ����� � �������, � ������������� �� ����, � ����� ���� � ���� ��� ���� ����������.</p>
                    <p><b><font color="#ee1d24">4. ����� � ������� ���������� �������</font></b></p>
                    <p><b>4.1.</b> �������� ������������ ������� �� ����� ������ �������, �������������� �� �����. �������������� ����� ���������� �������� �������� ������������� � ���� � ����� ���������� �� ������������ �������� ���� ������. �������������� ����� ��������/�������������� �� ���������� �� ������������� ��������������� � ����� ��������� ��������. ��� ��������� ���������� �� ������ ���������� ������ ���������� � ������ ���������.���������� ����������, �������������� �� �����, ������������ ������ �����.</p>
                    <p><b>4.2.</b> � ������ ���������� ���������� ����������� ������� �� ������ ��������, ��������� ������ ��������� ��������� ����� �� ������ / ������������ ����� ����������, �������� �� ���� ���������� ����� ����������� ���������������� ������������ ��������� �� ������, ���������� ����������� ��� ����������� (���� ������� ��������� Call-������ ��������).</p>
                    <p><b>4.3.</b> � ������ ��������� ��������� ���� �������� ��������������� ������ ��������� ��������������� ������ ������������ ��������� ���������� ��������, ������� ����� ��� �������.</p>
                    <p><b>4.4.</b> ����� ���������� ����������� � ������������ � �����������, ���������� �� ����� � ������� ����������� ������ �� ������<a href="http://stolnik24.ru/articles/help/">http://stolnik24.ru/articles/help/</a></p>
                    <p><b>4.5.</b> ���������� ����� ������ ��������������� �� �������������� �������� ��������, ��������� �� ����� ������������� ����������� ���������� ��������� ����� ������������ ����� �����������.</p>
                    <p><b>4.6.</b> ����� ���������� ������ �� �����. ��������,������������� ������ �����, � ������� 1-2 ����(�� ������ ��������� � ��\��) �������� ������ ������, ������������� ���� ��������, ������� ������� �� ������� ���������� ������� �� ������ �������� � �������, ������������ ��� ��������� � �������� ������.� ������ ��������� � �����,��������� ������ ����� ������������� �� 7 ����.</p>
                    <p><b>4.7.</b> ��������� ���� �������� ������ � ������ �������� ���������� ���������� ����������, ������������� �����, �� ����������� ����� ��� ��� ����������� ������ ����������.</p>
                    <p><b><font color="#ee1d24">5. �������� ������</font></b></p>
                    <p><b>5.1.</b> �������, � ����� ��������� ����� �������� ������� ������� �� ����� � ������� �������� �������� �� ������<a href="http://stolnik24.ru/articles/dostavka/"><b>������</b></a>������������ ����� �������� ����� ���� ����������� ����������� � ���������� Call-������ ��� ������������� ������.</p>
                    <p><b>5.2.</b> ���������� �������� �������, �������������� �� �����, ���������� ��������� ���������� ���������.</p>
                    <p><b>5.3.</b> �������� � �������� �������� ����� �������������� �������������, ������������ �� �� ���� ��������.</p>
                    <p><b>5.4.</b> ��� �������� ����� ��������� ���������� ���� �������� ����, ���������� � ������ �������� ���������� (����� ���������� � ������ ���� ��������� ������������). ��� ������������� ��������� ������, ����������� ����������� ��������� �������, ���������� ���� ������, ����� ����� ���� ������ ����, ������� ����� ������������ �������� � ������ (����� ����������� �/��� ��� ����������), � ����� �������� ��������� ������ � ������ ������ ����, ��������������� �������� ������.</p>
                    <p><b>5.5.</b> �� ��������� ������� �������������, � ����� ��� ���������� ������ �� ���� ������������, ��������� � ������ 5. ���������� ����������, ��� �������� ��������������� ������ ����, �������������� �������� ������, ������ ����������� ��������, �������������� �������� ����������, � ����� ������� ��� � ����� ���������������� ����������� ��������� �� ��������� � ������. �������� ����������� ������������������ � ������ ������������ ������ ���������� (�.9.3.).</p>
                    <p><b>5.6.</b> ���� ��������� ������ ��� ���������� ����������� ������ ��������� � ���������� � ������� �������� ��� ������ � ������������ ����������� ������ ������� � ����������, �������������� �������� ������. � ������ ���������� ������ �������� ��������� ���������� ��������� ��������������� ����������� ������ � �������� � ������ ������ ����� ��������� �� ������ �������� ������������� ������ ������.</p>
                </div>
            </div>
        </section>
<?if (!IsDev()):?>
    <?$APPLICATION->IncludeFile(
        SITE_DIR."include/counters.php",
        Array(),
        Array("MODE"=>"html")
    );?>
<?endif;?>

<?$APPLICATION->ShowViewContent('js_end');?>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KDV48R"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KDV48R');</script>
<!-- End Google Tag Manager -->


    </body>
</html>
