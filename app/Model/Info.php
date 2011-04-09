<?php
class Model_Info extends AbstractModel
{
	
	const CONTENT_ABOUT = 1;
	const CONTENT_INFO = 2;
	const CONTENT_CONTACT = 3;
	
	protected $_tablename = 'static';
		
	/**
	 * 
	 * Singleton
	 * @var AbstractModel
	 */
	private static $_instance = null;
	
	/**
	 * 
	 */
	private function __construct()	{
	}
	
	 /**
	  * Singleton pattern
	  */
	static function instance() {
		if (!self::$_instance) {
			self::$_instance = new self(); 
		}
		return self::$_instance;
	}
	
	/**
	 * @param array  
	 * project_id
	 * title
	 * text
	 * status
	 */
	
	function save ($data) {
		if (!$data) {
			return;
		}
		$sql = "INSERT INTO {$this->_tablename}(`id`,`text`,`created`) VALUE 
		('{$data['id']}','{$data['text']}',NOW())";

        return  parent::save($sql);
	}
	

	function update ($data) {
		if (!isset($data['id']) || !$data['id'])  {
			return;
		}
		$str = array();
		foreach ($data as $column => $val) {
			$str[]=$column." = '".addslashes($val)."'";
		}
		$str = implode(', ', $str);
		$sql = "UPDATE {$this->_tablename} set {$str} WHERE id={$data['id']}";
		parent::save($sql);
	}
	
	
	public function getAll(array $inputParam = array()) {
		$param = array_merge(array(
			'onlyStatusOn'=>false
		),$inputParam);
		
		return parent::getAll($param);
	}
	
	
	

}