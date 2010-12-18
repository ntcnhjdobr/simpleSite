<?php
class AbstractModel 
{

	/**
	 * $var
	 */	
	protected $_tablename = null;
	
	
	private function _output($sql) {
		Debugger::getInstance()->addSql($sql);
		
		$conn = Database::getConnection();
		$query = $conn->query($sql);
        if (!$query) {
        	return false;
        }
        return  $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function query($sql) {
		$return = $this->_output($sql);
		if (!$return) {
			$conn = Database::getConnection();
			var_dump($sql);
			var_dump ($conn->errorInfo());
		}
		return $return;
	}
	
	public function getAll(array $inputParam = array()) 
	{
		$defalutParam = array(
			'where'=>false,
			'select' => '*',
			'join'=>false,
			'orderby'=>$this->_tablename.'.created DESC',
			'groupby'=>false,
			'having'=>false,
			'onlyStatusOn'=>true
		);
		
		$param = array_merge($defalutParam, $inputParam);
		
		extract($param);
		
		$sql = "SELECT {$select} FROM {$this->_tablename}";
		
		if ($join) {
			$sql .=' LEFT JOIN '.$join;
		};
		
		if ($onlyStatusOn || $where) {
			$sql .=' WHERE ';
		}
		
		if ($onlyStatusOn){
			$sql .=$this->_tablename.'.status='.Model_Sample::STATUS_ON;
		}
		
		if ($where) {
			if ($onlyStatusOn) {
 				$sql .=' AND '.$where;
			}else{
				$sql .=$where;
			}
		};

		if ($orderby) {
			$sql .=' ORDER BY '.$orderby;
		};
		
		if ($groupby) {
			$sql .=' GROUP BY '.$groupby;		
		}
		
		

		if ($having) {
			$sql .=' HAVING '.$having;
		};
		
        return $this->_output($sql);
    }
    
	public function getBy($column, $value) 
	{
        $sql = "SELECT * from {$this->_tablename} where {$column}='{$value}'";
        return $this->_output($sql);
	}
	
	/**
	 * 
	 * Delete rows from table by ...
	 * @param string $column
	 * @param int $value
	 * @return int
	 */
	public function deleteBy($column, $value)
	{
		$conn = Database::getConnection();
		$sql = "DELETE from {$this->_tablename} where {$column}='{$value}'";
		$deleteRows = $conn->exec($sql);
		return  $deleteRows;
	}
	
	
	public function save ($sql) {
		$conn = Database::getConnection();
		$insertId = false;
		
		if ($conn->exec($sql)) {
			$insertId = $conn->lastInsertId();
		}
		return  $insertId;
	}
	

}
