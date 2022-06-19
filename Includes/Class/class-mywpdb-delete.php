<?php

class Mywpdb_Delete {

	function __construct() {
		$this->delete_row();
	}

	/**
	 * テーブルの値削除
	 */
	function delete_row() {
		global $wpdb;
		$nonce = isset($_POST['mywpdb_nonce_field']) ? $_POST['mywpdb_nonce_field'] : null;
		$is_verified = $nonce && wp_verify_nonce($nonce, 'mywpdb_delete_row');

		if ('POST' === $_SERVER['REQUEST_METHOD']) {
			if ($is_verified) {
				$table_name = mywpdb_s_POST('table_name');
				$table_key = mywpdb_s_POST('table_key');
				$table_value = mywpdb_s_POST('table_value');


				$deletes = $wpdb->delete($table_name, [$table_key => $table_value]);
				wp_safe_redirect(mywpdb_get_current_link());
			} else {
				echo esc_html('エラーが発生しました。もう一度やり直してください。');
			}
		}
	}
}
