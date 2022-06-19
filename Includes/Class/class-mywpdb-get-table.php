<?php
class Mywpdb_Get_Table {

	function __construct() {
		$this->offset = (mywpdb_s_GET('offset') ? mywpdb_s_GET('offset') : 0);
		$this->limit = (mywpdb_s_GET('limit') ? mywpdb_s_GET('limit') : 25);
	}

	/**
	 * テーブル名に接頭語をつける
	 *
	 * @param $table テーブル名
	 */
	function add_table_prefix($table) {
		global $wpdb;
		return $wpdb->prefix . $table;
	}

	/**
	 * 全テーブル取得
	 */
	function tables() {
		global $wpdb;
		$tables = array_map([$this, 'add_table_prefix'], $wpdb->tables);
		asort($tables);
		return $tables;
	}

	/**
	 * テーブルのカラム名
	 */
	function table_column_names($table_name) {
		global $wpdb;
		return $wpdb->get_col(
			$wpdb->prepare("DESC {$table_name}", '*'),
			0
		);
	}

	/**
	 * テーブルの全てのカラムの値の数
	 */
	function table_column_values_max() {
		global $wpdb, $limit;
		$table_name = mywpdb_s_GET('table_name');
		$table_column_values_max = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM $table_name $table_name"),
			ARRAY_A
		);
		return count($table_column_values_max);
	}

	/**
	 * テーブルのs全てのカラムの値
	 */
	function table_column_values($table_name_arg = '') {
		global $wpdb, $limit;
		$table_name = ($table_name_arg) ? $table_name_arg : mywpdb_s_GET('table_name');
		$table_column_values = $wpdb->get_results(
			"SELECT * FROM $table_name LIMIT $this->limit OFFSET $this->offset",
			ARRAY_A
		);

		return $table_column_values;
	}

	/**
	 * テーブルの1カラムの値
	 */
	function table_row_values() {
		global $wpdb, $limit;
		$table_name = mywpdb_s_GET('table_name');
		$where_key = array_key_first(mywpdb_s_GET('where'));
		$where_value = mywpdb_s_GET('where')[$where_key];

		$table_row_values = $wpdb->get_row(
			$wpdb->prepare(
				'SELECT * FROM `' . $table_name . '` WHERE ' .  $where_key . ' = '  . '%s ',
				$where_value,
			),
			ARRAY_A
		);

		return $table_row_values;
	}


	/**
	 * 検索テーブル一覧
	 */
	function search_tables() {
		$search_tables = (mywpdb_s_GET('search_tables')) ? mywpdb_s_GET('search_tables') : [];
		return $search_tables;
	}
}
?>
