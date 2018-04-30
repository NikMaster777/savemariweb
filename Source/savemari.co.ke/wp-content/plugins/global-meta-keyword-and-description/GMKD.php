<?php
/*
Plugin Name: Global Meta Keyword & Description
Plugin URI: http://wordpress.org/plugins/global-meta-keyword-and-description/
Description: Plugin for Global Meta Keyword & Description
Author: Kunal Shivale
Version: 2.3
*/

function set_GMKD_options() {
    include('GMKD-options.php');
}

function add_GMKD_menu() {
    add_options_page("Global Meta Keyword & Description", "Global Meta Keyword & Description", 1, "GMKD", "set_GMKD_options");
}

function add_GMKD_meta($headers) {
    $hideStr = get_option('GMKD_hide');
    $isHide  = false;
    if(isset($hideStr)) { $hideArr = explode(",", $hideStr);
        foreach ($hideArr as $hideVal) {
            if($hideVal == get_the_ID()) { $isHide = true;}
    }}

    if(!$isHide) {
        echo '
    <!-- GMKD Meta Keywords & Description -->
     ';        
        if(get_option('GMKD_keyword')) {
            echo '<meta name="keywords" content="'.get_option('GMKD_keyword').'">
        ';
        }
        if(get_option('GMKD_desc')) {
            echo ' <meta name="description" content="'.get_option('GMKD_desc').'">
        ';
        }
        if(get_option('GMKD_robots')) {
            echo ' <meta name="robots" content="'.get_GMKD_robots(get_option('GMKD_robots')).'">
         ';
        }
        if(get_option('GMKD_meta')) {
            echo stripslashes(get_option('GMKD_meta'))
            ;
            echo '
    <!-- GMKD Meta Keywords & Description -->
    ';
        }
        else {
            echo '<!-- GMKD Meta Keywords & Description -->
    ';
        }
    }

}

function get_GMKD_robots($robotsId) {
    switch ($robotsId) {
        case 1:
            $robotsName="Noindex, Nofollow";
            break;
        case 2:
            $robotsName="Index, Nofollow";
            break;
        case 3:
            $robotsName="Noindex, Follow";
            break;
        case 4:
            $robotsName="Index, Follow";
            break;

        default:
            $robotsName="Noindex, Nofollow";
            break;
    }
    return $robotsName;
}

function remove_GMKD_options() {
    delete_option("GMKD_keyword");
    delete_option("GMKD_desc");
    delete_option("GMKD_robots");
    delete_option("GMKD_meta");
    delete_option("GMKD_hide");
}

function GMKD_enqueue_style( $hook_suffix ) {
    wp_enqueue_style('GMKD-style', plugins_url('css/style.css', __FILE__), false, '1.0.0', 'all');
}

add_action('admin_menu', 'add_GMKD_menu');
add_action('wp_head', 'add_GMKD_meta');
add_action('admin_enqueue_scripts', 'GMKD_enqueue_style');
register_deactivation_hook( __FILE__, 'remove_GMKD_options' );
?>