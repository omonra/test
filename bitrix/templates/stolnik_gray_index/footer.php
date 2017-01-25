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
            <section class="b-wrapper b-wrapper_dark-grey" style="padding-bottom: 0">
                <section class="b-container" style="margin-bottom: 30px;">
                    <?$APPLICATION->IncludeComponent("bitrix:news.list", "advantages_new_on_index", array(
                        "IBLOCK_TYPE" => "services",
                        "IBLOCK_ID" => ADVANTAGES_IBLOCK_ID,
                        "NEWS_COUNT" => "6",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "",
                        "FIELD_CODE" => array(
                            0 => "DETAIL_PICTURE",
                            1 => "",
                        ),
                        "PROPERTY_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "SET_TITLE" => "N",
                        "SET_STATUS_404" => "N",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "PAGER_TEMPLATE" => ".default",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "PAGER_TITLE" => "Новости",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "DISPLAY_DATE" => "N",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => ""
                    ),
                        false
                    );?>
                </section>
                <section class="b-container">
                    <div class="b-footer__column b-footer__column_big">
                        <?if ($isIndexPage):?>
                        <?//if ($APPLICATION->GetCurDir() == '/new_template/'):?>
                            <div class="b-footer__title">
                                Интернет-магазин <span> STOLNIK</span>
                            </div>
                            <div class="jsFooterSlider">
                                <?$APPLICATION->IncludeFile(
                                    SITE_DIR."include/footer_text.php",
                                    array(),
                                    Array("MODE" => "html")
                                );?>
                            </div>
                            <a href="javascript: void(0)" class="jsFooterSpoiler">
                                Подробнее
                            </a>
                            <script>
                                $('.jsFooterSpoiler').click(function(){
                                    $(this).hide();
                                    $(this).prev('.jsFooterSlider').css('height','auto');
                                });
                            </script>
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
                    </section>
                <div style="background-color: #e2e6e9;padding: 20px 0;margin-top: 30px;">
                    <section class="b-container" style="">
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
                                "PAGER_TITLE" => "Товары",
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
                                "PAGER_TITLE" => "Товары",
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
                        <div class="cities">
                            <img style="display: inline-block;   margin-right: 5px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAWCAYAAADJqhx8AAADSElEQVQ4T42UXWgcVRTHf2c2MbWbVqkPKQoVK4oxah/Wh3a3+0EfhJlJghaCoKWWqqD180EUrGIVFUGE+lEVVIpWBQlUaLKzKKVkZjNbH1wo1LRisUpBaYVa+rFlm2TnyJ3djZuwgvdp5p5zf/d//+fcKywZ2ax9uyIPI9gKa01Y4CRKSdDPyuXSsc4l0v5JpVK9fcmBtwWeAHqAiwgn47jGoBXAPOgH9dpfz1er1bkWHGzb7rtQkwPAPcDPqrx0/u/kxMzM+KxJGhoau+qaVbUREV4HbhP0u3Nn+0dNPFaQzjl7BHaAeL1W7f6pqalLS49m/guFQv9clPwG1AH2hIH3pKQL7h0S6RHgRL2WSFWrE5dNcibvZkFHmiCZCP1i2XylUiPLr042flS4lUZjnaRzzm6BZ0SszdP+5LdNRfZbgrzQqUKRdypB8TkztzE/fJ9qtF/hXQP4RWB1vXbmOmNMOj+8QTSqCByP0GfNAgvZrTAYIZnDQbFiDF+WHDircFoyOecKwtHQ9+6O6Tlnl8IrnYraOwq8Oh14u1oqq4LcaQA14FQYeIPNgLtTUOP2g2HgfR37kXMeAL5CdGfol95szR0H1sjGnHNM4cbrB5Irx8fHG+tz7mACPQqcQ+WNpof6IrDKUr3LNNLY2FjizzO1C8Dvksk7n6A8opCvBF4Qq8i6W0T0YyDZMrKmKo9VysUvW2XPCfgIn0o667oiOgl8EQbeQ23nN2wavkEakWksNGF9f/jQ5B/tWCbnfA5sFdFRKRQKPXPR8l+B1VGPtbYzsVszGbA1H5kWP91rXb652Yl59ylRfU+UvdNlb3u3hQu75529KNtU5OmKX3w/BsR34ZLMINxkqW4ql0t+N0g2a+cjkUMov63s16FSqXRl4TZm8raNShHlVL1vdl314MHznZBC4d5r5xqzRxDWIOqGfqkUF6gzaaEiyr5K2du6JLYPZYtxPvS9R9uxxYDM6ApNzFcFblHRHRW/9FHTI/txUflQ4YQ0elJheOBiV0Cc3LydPwDLxGI4LmOEKXNdLVlfmSr+1KlskYJ/6+yOgu4XiN8FhX6QzWFQNI/OotEV0Ck7BnQc538DTGIma7+MZUnoF1/7r974B+uoYz2s4BSRAAAAAElFTkSuQmCC" alt="">
                            <a href="http://ekaterinburg.stolnik24.ru">Екатеринбург</a>, <a href="http://kazan.stolnik24.ru">Казань</a>, <a href="http://krasnodar.stolnik24.ru">Краснодар</a>, <a href="http://n-novgorod.stolnik24.ru">Нижний Новгород</a>, <a href="http://novosibirsk.stolnik24.ru">Новосибирск</a>
                        </div>
                    </section>
                </div>
            </section>
            <?/*?>
            <section class="b-wrapper b-wrapper_darkness" style="display: none;">
                <section class="b-container">
                    <!--
                    <div class="dev">
                        <a href="http://evosweb.ru/" target="_blank" title="EVOLUTION STUDIO">Разработка сайта</a><br />
                        <a href="http://evosweb.ru/Portfolios" target="_blank"><img src="/upload/medialibrary/b85/b85e14c599c5355d243a05bd81707fb7.png" title="EVOLUTION STUDIO" border="0" alt="EVOLUTION STUDIO" width="110" height="42"></a>
                    </div>
                    -->
                    <div class="copyright">
                        <?$APPLICATION->IncludeFile(
                            SITE_DIR."include/copyright.php",
                            array(),
                            Array("MODE" => "html")
                        );?>
                    </div>
                </section>
            </section>
        <?*/?>
        </footer>

        <div class="go_top"></div>

        <section class="hidden">
            <div id="added-to-basket">
                <div class="b-fancy-added">
                    <div class="title">Товар успешно добавлен в корзину</div>
                    <div class="g-clear b-btn-group">
                        <a title="продолжить" class="b-btn close" href="">Продолжить</a>
                        <a title="в корзину" class="b-btn" href="/basket/">В корзину</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="hidden">
			<noindex>
            <div id="oferta">
                <h1 class="title">
                    Публичная оферта
                </h1>
                <div class="news-detail">
                    <p><b>ОСНОВНЫЕ ПОНЯТИЯ</b></p>

                    <p><b>Пользователь</b> – физическое лицо, посетитель Сайта, принимающий условия настоящего Соглашения и желающий разместить Заказы на сайте <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>Покупатель</b> – Пользователь, разместивший Заказ на сайте <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>Продавец</b> – ИП Экшиян Д.В. (ОГРН  <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">313744829000028</span>    , ИНН  <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">744830169076</span>    , место нахождения:454080, Россия г.Челябинск, ул.Коммуны 88 «Лакитур»).</p>
                    <p><b>Интернет-магазин</b> – Интернет-сайт, принадлежащий Продавцу, расположенный в сети интернет по адресу <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>, где представлены Товары, предлагаемые Продавцом для приобретения, а также условия оплаты и доставки Товаров Покупателям.</p>
                    <p><b>Сайт</b> – <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>. </p>
                    <p><b>Товар</b> – обувь, одежда, аксессуары и иные товары, представленные к продаже на Сайте Продавца.</p>
                    <p><b>Заказ</b> – должным образом оформленный запрос Покупателя на приобретение и доставку по указанному Покупателем адресу / посредством самовывоза Товаров, выбранных на Сайте.</p>
                    <p><b><font color="#ee1d24">1. ОБЩИЕ ПОЛОЖЕНИЯ</font></b></p>
                    <p><b>1.1.</b> Продавец осуществляет продажу Товаров через Интернет-магазин по адресу <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>1.2.</b> Заказывая Товары через Интернет-магазин, Пользователь соглашается с условиями продажи Товаров, изложенными ниже (далее – Условия продажи товаров). В случае несогласия с настоящим Пользовательским соглашением (далее - Соглашение) Пользователь обязан немедленно прекратить использование сервиса и покинуть сайт <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
                    <p><b>1.3.</b> Настоящие Условия продажи товаров, а также информация о Товаре, представленная на Сайте, являются публичной офертой в соответствии со ст.435 и п.2 ст.437 Гражданского кодекса Российской Федерации.</p>
                    <p><b>1.4.</b> Пользователь соглашается с Условиями продажи товаров путем проставления отметки в графе «С данными условиями согласен» при оформлении Заказа.</p>
                    <p><b>1.5.</b> Соглашение может быть изменено Продавцом в одностороннем порядке без уведомления Пользователя/Покупателя. Новая редакция Соглашения вступает в силу по истечении 10 (Десяти) календарных дней с момента ее опубликования на Сайте, если иное не предусмотрено условиями настоящего Соглашения.</p>
                    <p><b>1.6.</b> Соглашение вступает в силу с момента отправки Покупателю Продавцом электронного подтверждения принятия Заказа при оформлении Покупателем Заказа без авторизации на Сайте, а также с момента принятия от Покупателя Заказа по телефону 8 (351) 220-12-70 (для звонков из Челябинска) и 8 (800) 33-33-019 (для звонков из регионов).</p>
                    <p>Сообщая Продавцу свой e-mail, Пользователь/Покупатель дает согласие на использование его в целях осуществления рассылок рекламно-информационного характера, содержащих информацию о скидках, предстоящих и действующих акциях и иных мероприятиях Продавца.</p>
                    <p><b><font color="#ee1d24">2. ПРЕДМЕТ СОГЛАШЕНИЯ</font></b></p>
                    <p><b>2.1.</b> Предметом настоящего Соглашения является предоставление возможности Пользователю приобретать для личных, семейных, домашних и иных нужд, не связанных с осуществлением предпринимательской деятельности, Товары, представленные в каталоге Интернет-магазина по адресу <a href="http://www.stolnik24.ru."><b>http://www.stolnik24.ru.</b></a></p>
                    <p><b>2.2.</b> Данное Соглашение распространяется на все виды Товаров и услуг, представленных на Сайте, пока такие предложения с описанием присутствуют в каталоге Интернет-магазина.</p>
                    <p><b><font color="#ee1d24">3. РЕГИСТРАЦИЯ НА САЙТЕ</font></b></p>
                    <p><b>3.1.</b> Регистрация на Сайте осуществляется по адресу <a href="http://stolnik24.ru/login/?register=yes">http://stolnik24.ru/login/?register=yes</a></p>
                    <p><b>3.2.</b> Регистрация на Сайте не является обязательной для оформления Заказа.</p>
                    <p><b>3.3.</b> Продавец не несет ответственности за точность и правильность информации, предоставляемой Пользователем при регистрации.</p>
                    <p><b>3.4.</b> Пользователь обязуется не сообщать третьим лицам логин и пароль, указанные Пользователем при регистрации. В случае возникновения у Пользователя подозрений относительно безопасности его логина и пароля или возможности их несанкционированного использования третьими лицами, Пользователь обязуется незамедлительно уведомить об этом Продавца, направив соответствующее электронное письмо по адресу: info@stok-stolnik.ru.</p>
                    <p><b>3.5.</b> Общение Пользователя/Покупателя с операторами Call-центра / менеджерами и иными представителями Продавца должно строиться на принципах общепринятой морали и коммуникационного этикета. Строго запрещено использование нецензурных слов, брани, оскорбительных выражений, а также угроз и шантажа, в независимости от того, в каком виде и кому они были адресованы.</p>
                    <p><b><font color="#ee1d24">4. ТОВАР И ПОРЯДОК СОВЕРШЕНИЯ ПОКУПКИ</font></b></p>
                    <p><b>4.1.</b> Продавец обеспечивает наличие на своем складе Товаров, представленных на Сайте. Сопровождающие Товар фотографии являются простыми иллюстрациями к нему и могут отличаться от фактического внешнего вида Товара. Сопровождающие Товар описания/характеристики не претендуют на исчерпывающую информативность и могут содержать опечатки. Для уточнения информации по Товару Покупатель должен обратиться в Службу поддержки.Обновление информации, представленной на Сайте, производится каждые сутки.</p>
                    <p><b>4.2.</b> В случае отсутствия заказанных Покупателем Товаров на складе Продавца, последний вправе исключить указанный Товар из Заказа / аннулировать Заказ Покупателя, уведомив об этом Покупателя путем направления соответствующего электронного сообщения по адресу, указанному Покупателем при регистрации (либо звонком оператора Call-центра Продавца).</p>
                    <p><b>4.3.</b> В случае аннуляции полностью либо частично предоплаченного Заказа стоимость аннулированного Товара возвращается Продавцом Покупателю способом, которым Товар был оплачен.</p>
                    <p><b>4.4.</b> Заказ Покупателя оформляется в соответствии с процедурами, указанными на Сайте в разделе «Оформление Заказа» по адресу <a href="http://stolnik24.ru/articles/help/">http://stolnik24.ru/articles/help/</a></p>
                    <p><b>4.5.</b> Покупатель несет полную ответственность за предоставление неверных сведений, повлекшее за собой невозможность надлежащего исполнения Продавцом своих обязательств перед Покупателем.</p>
                    <p><b>4.6.</b> После оформления Заказа на Сайте. Менеджер,обслуживающий данный Заказ, в течении 1-2 дней(не считая праздники и сб\вс) уточняет детали Заказа, согласовывает дату доставки, которая зависит от наличия заказанных Товаров на складе Продавца и времени, необходимого для обработки и доставки Заказа.В период распродаж и акций,обработка заказа может задерживаться до 7 дней.</p>
                    <p><b>4.7.</b> Ожидаемая дата передачи Заказа в Службу доставки сообщается Покупателю менеджером, обслуживающим Заказ, по электронной почте или при контрольном звонке Покупателю.</p>
                    <p><b><font color="#ee1d24">5. ДОСТАВКА ЗАКАЗА</font></b></p>
                    <p><b>5.1.</b> Способы, а также примерные сроки доставки Товаров указаны на Сайте в разделе «Способы доставки» по адресу <a href="http://stolnik24.ru/articles/dostavka/"><b>ссылка</b></a>  Конкретные сроки доставки могут быть согласованы Покупателем с оператором Call-центра при подтверждении заказа.</p>
                    <p><b>5.2.</b> Территория доставки Товаров, представленных на Сайте, ограничена пределами Российской Федерации.</p>
                    <p><b>5.3.</b> Задержки в доставке возможны ввиду непредвиденных обстоятельств, произошедших не по вине Продавца.</p>
                    <p><b>5.4.</b> При доставке Заказ вручается Покупателю либо третьему лицу, указанному в Заказе качестве получателя (далее Покупатель и третье лицо именуются «Получатель»). При невозможности получения Заказа, оплаченного посредством наличного расчета, указанными выше лицами, Заказ может быть вручен лицу, который может предоставить сведения о Заказе (номер отправления и/или ФИО Получателя), а также оплатить стоимость Заказа в полном объеме лицу, осуществляющему доставку Заказа.</p>
                    <p><b>5.5.</b> Во избежание случаев мошенничества, а также для выполнения взятых на себя обязательств, указанных в пункте 5. настоящего Соглашения, при вручении предоплаченного Заказа лицо, осуществляющее доставку Заказа, вправе затребовать документ, удостоверяющий личность Получателя, а также указать тип и номер предоставленного Получателем документа на квитанции к Заказу. Продавец гарантирует конфиденциальность и защиту персональных данных Получателя (п.9.3.).</p>
                    <p><b>5.6.</b> Риск случайной гибели или случайного повреждения Товара переходит к Покупателю с момента передачи ему Заказа и проставления Получателем Заказа подписи в документах, подтверждающих доставку Заказа. В случае недоставки Заказа Продавец возмещает Покупателю стоимость предоплаченного Покупателем Заказа и доставки в полном объеме после получения от Службы доставки подтверждения утраты Заказа.</p>
                </div>
            </div>
			</noindex>
        </section>
<?if (!IsDev()):?>
    <?$APPLICATION->IncludeFile(
        SITE_DIR."include/counters.php",
        Array(),
        Array("MODE"=>"html")
    );?>
<?endif;?>
<div style="visibility:hidden;">
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t26.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число посетителей за"+
" сегодня' "+
"border='0' width='88' height='15'><\/a>")
//--></script><!--/LiveInternet-->
	</div>

<?$APPLICATION->ShowViewContent('js_end');?>

<input type="hidden" class="registerSuccessInput" value="<?=$_REQUEST["registerSuccess"]?>">
<input type="hidden" class="newRegisterSuccessInput" value="<?=$_REQUEST["newRegisterSuccess"]?>">
<!-- Top100 (Kraken) Counter -->
<script>
    (function (w, d, c) {
    (w[c] = w[c] || []).push(function() {
        var options = {
            project: 4462331
        };
        try {
            w.top100Counter = new top100(options);
        } catch(e) { }
    });
    var n = d.getElementsByTagName("script")[0],
    s = d.createElement("script"),
    f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src =
    (d.location.protocol == "https:" ? "https:" : "http:") +
    "//st.top100.ru/top100/top100.js";

    if (w.opera == "[object Opera]") {
    d.addEventListener("DOMContentLoaded", f, false);
} else { f(); }
})(window, document, "_top100q");
</script>
<noscript><img src="//counter.rambler.ru/top100.cnt?pid=4462331"></noscript>
<!-- END Top100 (Kraken) Counter -->
<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "2854140", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2854140;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->

    </body>
</html>