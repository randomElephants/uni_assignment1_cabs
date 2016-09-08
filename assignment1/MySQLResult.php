<?php
class MySQLResult {
	
	private $numFields;
	private $rowCount;
	private $fieldNames = array();
	private $rows;
	
	//Takes a mysqli_stmt class, turns into readable result set
	public function __construct($stmt) {
		$stmt->store_result();
		$this->numFields = $stmt->field_count;
		$this->rowCount = $stmt->num_rows;
		$meta = $stmt->result_metadata();
		$params = array();
		
		while($field = $meta->fetch_field()) {
			$params[] = &$row[$field->name];
			$this->fieldNames[] = $field->name;
		}
		
		call_user_func_array(array($stmt, 'bind_result'), $params);

		while ($stmt->fetch()) {
			$tempRow = array();
			for ($i=0;$i<($this->numFields);$i++) {
				$name = $this->fieldNames[$i];
				$tempRow[$name] = $params[$i]; 
			}
			$this->rows[]=$tempRow;
		}
	}
	
	public function printResultsTable() {
		$numFields = $this->numFields;
		
		echo "<table border='1'>";
		echo "<thead><tr>";
		foreach ($this->getFieldNames() as $field) {
			echo "<th>$field</th>";
		}
		echo "</tr></thead>";
		echo "<tbody>";
		
		if ($this->getRowCount() < 1) {
			echo "<tr><td colspan='$numFields'>No results found</td></tr>";
		} else {
			foreach ($this->getRows() as $row) {
				echo "<tr>";
				foreach ($row as $field) {
					echo "<td>$field</td>";
				}
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	
	public function getFieldNames() {
		return $this->fieldNames;
	}
	
	public function getRows() {
		return $this->rows;		
	}
	
	public function getFieldCount() {
		return $this->numFields;
	}
	
	public function getRowCount() {
		return $this->rowCount;
	}
	
	public function getFirstRow() {
		return $this->rows[0];
	}
}