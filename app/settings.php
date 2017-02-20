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
            "main_position_horizontal" => "0.0", //����� �� ����������� ��� ������������ ������
            "main_position_vertical" => "0.0", //����� �� ��������� ��� ������������ ������
            "back_text_position_horizontal" => "5.0", //����� �� ����������� ��� ������������ ������ (ios)
            "back_text_position_vertical" => "0.0"//����� �� ��������� ��� ������������ ������(ios)
        ),
        "default_back_button" => "back_text",
        "button_height" => "32.0", //������ ������
        "button_width" => "34.0", //������ ������
        "main_background_image" => "/app/images/toolbar_btn_bg.png", //������������� ��� ������
        //"back_text_background_image" => "/app/images/toolbar_btn_img.png", //������������� ��� ������ �����
        "type" => array(
            "menu" => "/app/images/toolbar_btn_img.png", //���� ������ ������ ��� ������
            "basket" => "/app/images/toolbar_basket_img.png", //�����-�� ������ ������
        )
    ),
    
    "controller_settings" => array(
        "main_background" => array(
            //"image" => "/myfirst_app/img/back.png", //�������� ��� ����������
            "color" => "#FFFFFF"// ���� ����, ����� ��������� ����� image
        ),
        "title_color" => "#000000",
        
        "loading_background" => array(
            //"image" => "/myfirst_app/img/back1.png", //��� ������ ��������
            "color" => "#FFFFFF"//���� ������ ��������, ����� ��������� ����� image
        ),
        //"navigation_bar_image" => "/myfirst_app/img/panel2.png", //��� ������������� ������ 
        //"navigation_bar_image_large" => "/myfirst_app/img/panel2.png", //��� ������������� ������ ��� ���������
        //"toolbar_bar_image" => "/myfirst_app/img/panel.png", //��� ������� ios
        //"toolbar_bar_image_large" => "/myfirst_app/img/panel.png", //��� ������� ��� ��������� ios
    ),
    "table" => array(
        "background_cell_image" => "/myfirst_app/img/a_panel.png", //��� ������ ������
        "row_height" => "150.0", //������ ������ 
        "row_height_large" => "63.0"//������ ������ ����������
    ),
    "pull_down" => array(
        "icon" => "/app/img/down_arrow.png", //��������� ��� ��������
        "text_color" => "#333333", //���� ������ ��������
    )
);

echo json_encode($settings);
