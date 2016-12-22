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
                            <div class="b-footer__title"><?=COption::GetOptionString('main', 'site_name', 'Интернет-магазин STOLNIK')?></div>
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
                </section>
            </section>
            <section class="b-wrapper b-wrapper_darkness">
                <section class="b-container">
                    <div class="dev">
                        <a href="http://evosweb.ru/" target="_blank" title="EVOLUTION STUDIO">Разработка сайта</a><br />
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
                    <div class="title">Товар успешно добавлен в корзину</div>
                    <div class="g-clear b-btn-group">
                        <a title="продолжить" class="b-btn close" href="">Продолжить</a>
                        <a title="в корзину" class="b-btn" href="/basket/">В корзину</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="hidden">
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
