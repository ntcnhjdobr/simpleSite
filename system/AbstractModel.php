<?php
class AbstractModel 
{

	/**
	 * $var
	 */	
	protected $_tablename = null;
	
	
	private function _output($sql, $params = array()) 
	{
		$unqid = uniqid();
		Debugger::getInstance()->timerStart($unqid);
		
		$conn = Database::getConnection();
		
		if ($params) {
			$query = $conn->prepare($sql);
			$query->execute($params);
			$sqlForDebugger = $sql .'  ('. implode(',', $params).')';
		}else{
			$query = $conn->query($sql);
			$sqlForDebugger = $sql;
		}
		
		if (!$query) {
        	return false;
        }
        
        $return = $query->fetchAll(PDO::FETCH_ASSOC);
        
        Debugger::getInstance()->addSql(array(
        	$sqlForDebugger,
        	$query->rowCount(),
        	Debugger::getInstance()->timerEnd($unqid, false))
        );
        
        return $return;
	}
	
	public function query($sql, $params = array())  
	{
		$return = $this->_output($sql, $params);
		if ($return === false) {
			$conn = Database::getConnection();
			throw new AbstractException($sql);
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
			'orderby'=>$this->_tablename.'.id DESC',
			'groupby'=>false,
			'having'=>false,
			'onlyStatusOn'=>true,
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
		
        return $this->query($sql);
    }
    
    
	public function getBy($column, $value) 
	{
        $sql = "SELECT * from `{$this->_tablename}` where `{$column}`=:value";
        return $this->query($sql, array('value'=>$value));
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
        $sql = "DELETE FROM `{$this->_tablename}` WHERE `{$column}`=:value";
        return $this->query($sql, array('value'=>(int)$value));
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
