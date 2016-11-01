<?php

class CRUD {

	private $conn;
	private $table;

	protected function __construct($host = "localhost", $user = "root", $pass = "", $db = "", $port = 3306) {
		$mysqli = new mysqli($host, $user, $pass, $db, $port);
		$this->conn = $mysqli;
	}

	public function setTable($table) {
		$this->table = $table;
		return $this;
	}

	public function create($data = array(), $debug = false) {
		if(empty($this->table)) { return false; }
		$count = count($data);
		if($count > 0) {
			$columns = "";
			$values = "";
			$i = 0;
			foreach($data as $k => $v) {
				$columns .= $k;
				$values .= '"'.self::filter($v).'"';
				if($i < ($count - 1)) {
					$columns .= ", ";
					$values .= ", ";
				}
				$i++;
			}
			$query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->table, $columns, $values);
			if($debug) {
				return $query;
			} else {
				return $this->conn->query($query);
			}
		} else {
			return false;
		}
	}

	public function read($columns = array(), $where = "", $debug = false) {
		if(empty($this->table)) { return false; }
		$count = count($columns);
		if($count > 0) {
			$col = "";
			$i = 0;
			foreach($columns as $v) {
				$col .= $v;
				if($i < ($count - 1)) {
					$col .= ", ";
				}
				$i++;
			}
		} else {
			$col = "*";
		}
		$query = sprintf("SELECT %s FROM %s", $col, $this->table);
		$query .= ( empty($where) ? "" : " WHERE ".$where );
		if($debug) {
			return $query;
		} else {
			return $this->conn->query($query);
		}
	}

	public function update($data = array(), $where = "", $debug = false) {
		if(empty($this->table)) { return false; }
		$count = count($data);
		if($count > 0) {
			$a = "";
			$i = 0;
			foreach($data as $k => $v) {
				$a .= $k.' = "'.self::filter($v).'"';
				if($i < ($count - 1)) {
					$a .= ", ";
				}
				$i++;
			}
			$query = sprintf("UPDATE %s SET %s", $this->table, $a);
			$query .= ( empty($where) ? "" : " WHERE ".$where );
			if($debug) {
				return $query;
			} else {
				return $this->conn->query($query);
			}
		} else {
			return false;
		}
	}

	public function delete($where = "", $debug = false) {
		if(empty($this->table)) { return false; }
		if(empty($where)) {
			return false;
		}
		$query = sprintf("DELETE FROM %s WHERE %s", $this->table, $where);
		if($debug) {
			return $query;
		} else {
			return $this->conn->query($query);
		}
	}

	private static function filter($str) {
		return ( get_magic_quotes_gpc() ? $str : addslashes($str) );
	}

	public static function bind($str, $data) {
		$count = count($data);
		if($count > 0) {
			foreach($data as $k => $v) {
				$str = str_ireplace($k, self::filter($v), $str);
			}
			return $str;
		} else {
			return "";
		}
	}
}

?>