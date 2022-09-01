<?php
/*
@package    WordPress
@subpackage my_plugin
@author  Samurai6111 <samurai.blue6111@gmail.com>
Plugin Name: My wpdb
Text Domain: my_plugin
Description: Wordpressで管理画面からDBを編集することが出来るプラグイン
Author: Shota Kawakatsu
Author URI: https://github.com/Samurai6111
Version: 3.1.5
Plugin URI: https://github.com/Samurai6111/mywpdb
*/

/*--------------------------------------------------
/* phpファイルのURLに直接アクセスされても中身見られないようにするやつ
/*------------------------------------------------*/
if (!defined('ABSPATH')) exit;


//--------------------------------------------------
// 変数
//--------------------------------------------------
$mywpdb_url = plugins_url('', __FILE__);
$mywpdb_path = plugin_dir_path(__FILE__);


/**
 * ページ作成
 */
function mywpdb_add_pages() {
	global $mywpdb_path;
	add_menu_page(
		__('My wpdb'),
		__('My wpdb'),
		'manage_options',
		'mywpdb_page',
		'mywpdb_view',
		'dashicons-calendar-alt',
		100
	);
}
add_action('admin_menu', 'mywpdb_add_pages');


/**
 * ページ読み込み時に実行される関数
 */
function mywpdb_view() {
	global $mywpdb_path;

	//--------------------------------------------------
	// インクルード
	//--------------------------------------------------
	require_once($mywpdb_path . "/Includes/mywpdb--include.php");

	//--------------------------------------------------
	// ページ読み込み
	//--------------------------------------------------
	require_once($mywpdb_path . "/Pages/page.php");
}


/**
 * css読み込み
 */
function mywpdb_load_css() {
	global $mywpdb_url;
	wp_enqueue_style('mywpdb_css', $mywpdb_url . '/Assets/css/style.css', false, '1.1', 'all');
}
add_action('admin_enqueue_scripts', 'mywpdb_load_css');


/**
 * css読み込み
 */
function mywpdb_load_js() {
	global $mywpdb_url;
	wp_enqueue_script('my-wpdb', $mywpdb_url . '/Assets/js/mywpdb.js', [], false, true);
}
add_action('admin_enqueue_scripts', 'mywpdb_load_js');
