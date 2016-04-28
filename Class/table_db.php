<?php

class Table_DB extends DB
{

	public $table;
	public $id;

	public function __construct($table) {
	
		$this->table = $table;
		parent::__construct();
	
	}

	public function set($id) {
	
		$this->id = $id;
	
	}

	
	public function getById() {
	
		$sql = "SELECT * FROM ".$this->table." WHERE id = ".$this->id;
		
		return $this->_getRow($sql);
		
	}


	public function getRow($arr_select = false, $arr_where = false, $arr_order = false) {
	
		if (is_array($arr_select)) {
			$select = implode(", ", $arr_select);
		} else {
			$select = "*";
		}

		if (is_array($arr_where)) {
			foreach ($arr_where as $key => $value) {
				if ($where) {
					$where .= " AND $key = '$value'";
				} else {
					$where .= " WHERE $key = '$value'";
				}
			}
		}
		
		if (is_array($arr_order)) {
			$order = " ORDER BY ".implode(", ", $arr_order);
		}

		$sql = "SELECT ".$select." FROM ".$this->table.$where.$order;
		
		return $this->_getRow($sql);
		
	}


	public function getAll($arr_select = false, $arr_where = false, $arr_order = false) {
	
		if (is_array($arr_select)) {
			$select = implode(", ", $arr_select);
		} else {
			$select = "*";
		}

		if (is_array($arr_where)) {
			foreach ($arr_where as $key => $value) {
				if ($where) {
					$where .= " AND $key = '$value'";
				} else {
					$where .= " WHERE $key = '$value'";
				}
			}
		}
		
		if (is_array($arr_order)) {
			$order = " ORDER BY ".implode(", ", $arr_order);
		}

		$sql = "SELECT ".$select." FROM ".$this->table.$where.$order;
		
		return $this->_getAll($sql);
		
	}


	public function insert($arr_fields) {
	
		foreach($arr_fields as $key => $value) {
			
			if ($columns) {
				$columns .= ", $key";
			} else {
				$columns .= "$key";
			}
			
			if ($values) {
				$values .= ", '$value'";
			} else {
				$values .= "'$value'";
			}
		
		}

		$sql = "INSERT INTO ".$this->table." ($columns) VALUES ($values)";
		$result = $this->_query($sql);
		
		if ($result) {
			$this->id = $this->DB->insert_id;
		}
		
		return $result;
	
	}


	public function update($arr_fields) {
		
		foreach($arr_fields as $key => $value) {
			if ($set) {
				$set .= ", $key = '$value'";
			} else {
				$set .= "$key = '$value'";
			}
		}
		
		$sql = "UPDATE ".$this->table." SET $set WHERE id = ".$this->id;
		
		return $this->_query($sql);
		
	}

	
	public function delete() {
		
		$sql = "DELETE FROM ".$this->table." WHERE id = ".$this->id;
		
		return $this->_query($sql);
	
	}


}


?>