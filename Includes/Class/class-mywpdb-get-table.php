<?php
class Mywpdb_Get_Table {

	function __construct() {
		$this->offset = (mywpdb_s_GET('offset') ? mywpdb_s_GET('offset') : 0);
		$this->limit = (mywpdb_s_GET('limit') ? mywpdb_s_GET('limit') : 25);
	}

	/**
	 * 全テーブル取得
	 */
	function tables($output = '') {
		global $wpdb;
		$sql = $wpdb->prepare('SHOW TABLES');
		if ($output === 'sql') {
			return $sql;
		} else {
			$show_tables = $wpdb->get_results(
				$sql
			);
			$key = array_key_first((array)$show_tables[0]);
			$tables = array_column($show_tables, $key);
			asort($tables);
			return $tables;
		}
	}


	/**
	 * テーブルのカラム名
	 */
	function table_column_names($table_name) {
		global $wpdb;
		return $wpdb->get_col("DESC {$table_name}");
	}

	/**
	 * テーブルの全てのカラムの値の数
	 */
	function table_column_values_max() {
		global $wpdb, $limit;
		$table_name = mywpdb_s_GET('table_name');
		$sql = "SELECT * FROM $table_name";
		$table_column_values_max = $wpdb->get_results(
			$sql,
			ARRAY_A
		);

		return count($table_column_values_max);
	}

	/**
	 * テーブルのs全てのカラムの値
	 */
	function table_column_values($output = '', $table_name_arg = '') {
		global $wpdb, $limit;
		$table_name = ($table_name_arg) ? $table_name_arg : mywpdb_s_GET('table_name');
		$sql = $wpdb->prepare(
			"SELECT * FROM $table_name LIMIT %d OFFSET %d",
			$this->limit,
			$this->offset
		);

		if ($output === 'sql') {
			return $sql;
		} else {
			$table_column_values = $wpdb->get_results(
				$sql,
				ARRAY_A
			);

			return $table_column_values;
		}
	}

	/**
	 * テーブルの1カラムの値
	 */
	function table_row_values($output = '') {
		global $wpdb, $limit;
		$table_name = mywpdb_s_GET('table_name');
		$where_key = array_key_first(mywpdb_s_GET('where'));
		$where_value = mywpdb_s_GET('where')[$where_key];
		$sql = $wpdb->prepare(
			"SELECT * FROM {$table_name} WHERE $where_key = %d",
			$where_value,
		);

		if ($output === 'sql') {
			return $sql;
		} else {

			$table_row_values = $wpdb->get_row(
				$sql,
				ARRAY_A
			);

			return $table_row_values;
		}
	}


	/**
	 * 検索テーブル一覧
	 */
	function search_tables() {
		$search_tables = (mywpdb_s_GET('search_tables')) ? mywpdb_s_GET('search_tables') : [];
		return $search_tables;
	}
}
