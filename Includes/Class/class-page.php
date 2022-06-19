<?php
class Mywpdb_Page {

	function __construct() {
	}

	function view() {
		global $mywpdb_path;
		// ---------- 検索 ----------
		if (mywpdb_s_GET('s')) {
			require_once($mywpdb_path . "/Pages/page--search.php");
		} else {
			// ---------- 各テーブル 1行 ----------
			if (
				mywpdb_s_GET('view') === 'table_row'
			) {
				require_once($mywpdb_path . "/Pages/page--table-row.php");
			}
			// ---------- 各テーブル ----------
			elseif (
				mywpdb_s_GET('view') === 'table'
			) {
				require_once($mywpdb_path . "/Pages/page--table.php");
			}
			// ---------- 初期画面 ----------
			else {
				require_once($mywpdb_path . "/Pages/page--tables.php");
			}
		}
	}
}
