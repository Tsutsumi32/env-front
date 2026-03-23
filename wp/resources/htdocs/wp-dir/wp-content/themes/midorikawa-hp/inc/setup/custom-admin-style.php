<?php
/***************************************************
    管理画面デザイン変更
 ****************************************************/
function login_design()
{
    echo '
    <style type="text/css">
    .login {
        background-color: transparent !important;
        background: transparent linear-gradient(180deg, #FFFFFF 0%, #F2F3F2 71%, #B6CEBE 100%) 0% 0% no-repeat padding-box !important;
        background-size: cover !important;
    }
    #loginform {
        background-color: #FFFFFF !important;
        border: 2px solid #A0A0A0 !important;
        border-radius: 10px !important;
    }
    #loginform #user_login.input {
        background-color: #FFFFFF !important;
        border: 2px solid #A0A0A0 !important;

    }
    #loginform #user_pass.input {
        background-color: #FFFFFF !important;
        border: 2px solid #A0A0A0 !important;
    }
    input[type=checkbox]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=datetime]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, select:focus, textarea:focus {
        border-color: #009944 !important;
        box-shadow: 0 0 0 1px #009944 !important;
        outline: 0 !important;
    }
    .login .wp-login-lost-password {
        color: #0D5C30 !important;
    }
    .login #backtoblog a {
        color: #343232 !important;
    }
    #loginform label {
        color: #343232 !important;
        font-weight: bold !important;
    }
    #loginform .button-primary {
        background: #009944 !important;
        border: 0 !important;
        font-weight: bold !important;
        color: #FFFFFF !important;
    }
    .login h1 a {
        background-image: url(' . get_theme_file_uri('/assets/images/logo.png') . ') !important;
        background-size: contain !important;
        width: 100% !important;
    }
    .login .message, .login .notice, .login .success {
        border-color: #009944 !important;
    }
    </style>
    ';
}
add_action('login_head', 'login_design');

function admin_design()
{
    echo '
    <style type="text/css">
    .wp-admin {
        background-color:rgb(243, 243, 243) !important;
    }
    #wpadminbar {
        background: #254A0B; !important;
    }
    #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
        background: #254A0B; !important;
    }
    #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
        background: #009944;
    }
    #adminmenu .wp-submenu a {
        color: #FFFFFF !important;
    }
    #adminmenu .wp-submenu a:hover {
        opacity: .6;
    }
    </style>
    ';
}
add_action('admin_head', 'admin_design');
