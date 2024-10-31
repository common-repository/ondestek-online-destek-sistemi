<?php
/*
Plugin Name: OnDestek
Plugin URI: http://ondestek.com/
Description: OnDestek canlı destek eklentisi
Author: WMedya
Author URI: http://ondestek.com/
Text Domain: ondestek
Version: 1.0
*/
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
    die('You are not allowed to call this page directly.');
}

register_activation_hook(__FILE__, 'ondestek_default');
function ondestek_default()
{
    add_option('ondestek_script', '');
    add_option('ondestek_switch', 0);
}

register_deactivation_hook(__FILE__, 'ondestek_delete');
function ondestek_delete()
{
    delete_option('ondestek_script');
    delete_option('ondestek_switch');
}

add_action('admin_menu', 'ondestek_add_menu');

function ondestek_add_menu()
{
    add_menu_page("OnDestek Eklenti", "OnDestek", "manage_options", "ondestek", "ondestek", plugins_url('favicon_16.png', __FILE__), "81");
}

function ondestek()
{
    if (isset($_POST["od_script"])) {
        $od_script = $_POST['od_script'];
        $od_switch = $_POST['od_switch'] == 'on' ? 1 : 0;

        update_option('ondestek_script', $od_script);
        update_option('ondestek_switch', $od_switch);
    }
    ?>
    <div class="wrap">
        <div id="main-container">
            <div id="top" style="position:relative">
                <div class="wrapper" style="margin-left:5px;">
                    <a href="http://ondestek.com" class="logo">
                        <img src="<?= plugins_url("logo.png", __FILE__) ?>" alt="" width="120">
                    </a>
                </div>
            </div>
        </div>
        <div class="widget">
            <div class="whead">
                <h6>Canlı Destek Kodu Ekle</h6>
                <div class="clear"></div>
            </div>
            <div class="formRow">
                <form method="post" action="<?= $_SERVER["REQUEST_URI"]; ?>">
                    <p>Sitemizden aldığınız scripti buraya yapıştırın.</p>
                    <br/>
                    <p style="color:#000; padding-top:0; padding-bottom:10px; line-height:20px;">
                        Aşağıdaki kodlar, web sitenizin <a class="red"
                                                           href="http://www.w3.org/wiki/The_HTML_head_element"
                                                           target="_blank"><b>&lt;head&gt;&lt;/head&gt;</b></a>
                        etiketlerinin arasına yerleştirilecektir. Sitenizin bütün sayfalarında aktif olacaktır!
                    </p>
                    <div style="position:relative">
            <textarea id="script_tag" name="od_script"
                      style="padding:15px; background:#FFFFFF; height:150px; font-size:12px;"><?= stripslashes(get_option('ondestek_script')); ?></textarea>
                        <a href="javascript:void(0)" style="position:absolute; bottom:9px; right:0;"
                           class="buttonH bBlue"
                           onclick="document.getElementById('script_tag').select()">Kodu Seç</a>
                    </div>
                    <br/>
                    <div>
                        Etkinleştirilsin Mi?
                        <input type="checkbox" id="switch"
                               name="od_switch" <?= get_option('ondestek_switch') == 1 ? 'checked' : '' ?>/><label
                                for="switch">Toggle</label>
                        <br/>
                    </div>
                    <input class="buttonL bGreen" type="submit" id="submit" name="submit"
                           value="<?php _e('Save Changes'); ?>">
                </form>
            </div>
        </div>
    </div>

    <?php
}

/* Fonksiyon yazalım */
function ondestek_script()
{
    echo stripslashes(get_option('ondestek_script'));
}

if (get_option('ondestek_switch') == 1) {
    add_action('wp_head', 'ondestek_script');
}


add_action('admin_head', function () {
    if (strpos($_SERVER['REQUEST_URI'], "wp-admin/admin.php?page=ondestek")) {
        echo '
        <link href="' . plugins_url("styles.css", __FILE__) . '" rel="stylesheet" type="text/css" />
        <link href="' . plugins_url("checkbox.css", __FILE__) . '" rel="stylesheet" type="text/css" />
        ';
    }
})
?>