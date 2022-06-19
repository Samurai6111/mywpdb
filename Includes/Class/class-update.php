<?php

class Mywpdb_Update {

	function __construct() {
		$this->update_row();
	}

	/**
	 * テーブルの値をupdateする
	 */
	function update_row() {
		global $wpdb;
		$nonce = isset($_POST['mywpdb_nonce_field']) ? $_POST['mywpdb_nonce_field'] : null;
		$is_verified = $nonce && wp_verify_nonce($nonce, 'mywpdb_update_row');

		if ('POST' === $_SERVER['REQUEST_METHOD']) {
			if ($is_verified) {
				$table_name = mywpdb_s_POST('table_name');
				//--------------------------------------------------
				// 対象のテーブルのカラム名を取得
				//--------------------------------------------------
				$Mywpdb_Get_Table = new Mywpdb_Get_Table();
				$table_column_names = $Mywpdb_Get_Table->table_column_names($table_name);


				//--------------------------------------------------
				// サニタイズ
				//--------------------------------------------------
				$sanitized_POST = [];
				if (!empty($_POST)) {
					foreach ($_POST as $key => $value) {
						if (!is_array($value)) {
							$value = wp_kses_post($value);
							$$sanitized_POST[$key] = $value;
						}
					}
				}

				//--------------------------------------------------
				// update用の配列を作成
				//--------------------------------------------------
				$wpdb_update_array = [];
				foreach ($table_column_names as $table_column_name) {
					$wpdb_update_array[$table_column_name] = $sanitized_POST[$table_column_name];
				}


				//--------------------------------------------------
				// whereを定義
				//--------------------------------------------------
				$first_key = array_key_first($wpdb_update_array);
				$first_value = esc_html($wpdb_update_array[$first_key]);

				//--------------------------------------------------
				// 変更処理を実行
				//--------------------------------------------------
				$result = $wpdb->update(
					$table_name,
					$wpdb_update_array,
					[$first_key => wp_kses_post($first_value)]
				);

				wp_safe_redirect(mywpdb_get_current_link());
			} else {
				echo esc_html('エラーが発生しました。もう一度やり直してください。');
			}
		}
	}
}
