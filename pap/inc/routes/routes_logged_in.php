<?php
//validate access
defined('CONTROL') or die('Access denied');

if ($_SESSION['type'] == 'Aluno' || $_SESSION['type'] == 'Professor/Funcionario') {
    return [
        '404',

        'office_student',
        'lunch_student',
        'lunch_submit',
        'snack_student',
        'snack_submit',
        'delete_cart_product',
        'confirm_cart',

        'logout'
    ];
} else if ($_SESSION['type'] == 'Administrador') {
    return [
        '404',

        'office_admin',
        'objective_submit',
        'stats_admin',
        'reservations_admin',
        'confirm_paid_reservation',
        'confirm_delivery_reservation',
        'delete_reservation',
        'weekmenu_admin',
        'weekmenu_submit',
        'addproducts_admin',
        'addproducts_submit',
        'products_admin',
        'products_search_submit',
        'edit_products',
        'edit_products_submit',
        'delete_products_submit',
        'addproductstype_submit',
        'notes_admin',
        'notes_submit',

        'logout'
    ];
} else if ($_SESSION['type'] == 'Direcao') {
    return [
        'app_customize',
        'email_domain_submit',
        'img1_submit',
        'img2_submit',
        'img3_submit',
        'img4_submit',
        'img5_submit',
        'img6_submit',
        'footer_submit',
        'social_submit',
        'pauses_submit',
        'lunch_hour_submit',
        'max_hour_lunch_submit',
        'users',
        'add_users',
        'edit_user',
        'edit_users_submit',
        'delete_user_submit',

        'logout'
    ];
};