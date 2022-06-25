<?php
class Mywpdb_Search {

	function __construct() {
		$this->s = mywpdb_s_GET('s');
	}

/**
* 検索結果一覧出力
*/
	function search_results($output = '') {

		global $wpdb;

		if ($this->s) {

			$Mywpdb_Get_Table = new Mywpdb_Get_Table();
			$search_tables = $Mywpdb_Get_Table->search_tables();
			$search_results = [];

			foreach ($search_tables as $search_table) {

				// ---------- sqlのコマンドのテーブルにカラム部分 ----------
				$table_column_names = $Mywpdb_Get_Table->table_column_names($search_table);
				$table_column_names_sql = "";
				$i = 0;
				foreach ($table_column_names as $table_column_name) {
					$i++;
					if ($i === 1) {
						$table_column_names_sql .= "CONVERT(`{$table_column_name}` USING utf8) LIKE '%{$this->s}%' ";
					} else {
						$table_column_names_sql .= "OR CONVERT(`{$table_column_name}` USING utf8) LIKE '%{$this->s}%' ";
					}
				}

				// ---------- sqlのコマンド ----------
				$search_sql = "SELECT * FROM `{$search_table}`
			 WHERE (
				$table_column_names_sql
			)
			";
			$search_results[$search_table]= $wpdb->get_results($search_sql, ARRAY_A);
			}

			if ($output === 'sql') {
				return $search_sql;
			} else {
				return $search_results;
			}

		} else {
			return false;
		}
	}
}
