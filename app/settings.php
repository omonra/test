<?php

header("Content-Type: application/x-javascript");

$settings = array(
    "additional" => Array (
        "push" => Array (
            "app_push_id" => "STOLNIK24_RU",
            "use_push" => "YES"
        ),
        "use_top_bar" => "NO"
    ),
    "statusBar" => Array (
        "use_top_offset" => "NO"
    ),
    "buttons" =>
    array(
        "stretchable" => array(
            "flag" => "YES",
            "main_position_horizontal" => "0.0", //точка по горизонтали дл€ раст€гивани€ кнопки
            "main_position_vertical" => "0.0", //точка по вертикали дл€ раст€гивани€ кнопки
            "back_text_position_horizontal" => "5.0", //точка по горизонтали дл€ раст€гивани€ кнопки (ios)
            "back_text_position_vertical" => "0.0"//точка по вертикали дл€ раст€гивани€ кнопки(ios)
        ),
        "default_back_button" => "back_text",
        "button_height" => "32.0", //ширина кнопки
        "button_width" => "34.0", //высота кнопки
        "main_background_image" => "/app/images/toolbar_btn_bg.png", //раст€гиваемый фон кнопки
        //"back_text_background_image" => "/app/images/toolbar_btn_img.png", //раст€гиваемый фон кнопки назад
        "type" => array(
            "menu" => "/app/images/toolbar_btn_img.png", //сво€ иконка флажка дл€ кнопки
            "basket" => "/app/images/toolbar_basket_img.png", //кака€-то друга€ иконка
        )
    ),
    
    "controller_settings" => array(
        "main_background" => array(
            //"image" => "/myfirst_app/img/back.png", //основной фон приложени€
            "color" => "#FFFFFF"// цвет фона, имеет приоритет перед image
        ),
        "title_color" => "#000000",
        
        "loading_background" => array(
            //"image" => "/myfirst_app/img/back1.png", //фон экрана загрузки
            "color" => "#FFFFFF"//цвет экрана загрузки, имеет приоритет перед image
        ),
        //"navigation_bar_image" => "/myfirst_app/img/panel2.png", //фон навигационной панели 
        //"navigation_bar_image_large" => "/myfirst_app/img/panel2.png", //фон навигационной панели дл€ планшетов
        //"toolbar_bar_image" => "/myfirst_app/img/panel.png", //фон тулбара ios
        //"toolbar_bar_image_large" => "/myfirst_app/img/panel.png", //фон тулбара дл€ планшетов ios
    ),
    "table" => array(
        "background_cell_image" => "/myfirst_app/img/a_panel.png", //фон €чейки списка
        "row_height" => "150.0", //высота €чейки 
        "row_height_large" => "63.0"//высота €чейки планшетна€
    ),
    "pull_down" => array(
        "icon" => "/app/img/down_arrow.png", //стрелочка дл€ пулдауна
        "text_color" => "#333333", //цвет текста пулдауна
    )
);

echo json_encode($settings);
