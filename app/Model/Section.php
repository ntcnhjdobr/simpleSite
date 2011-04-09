<?php
class Model_Section extends AbstractModel
{

	const STATUS_OFF = 0;
	const STATUS_ON = 1;
	
	protected $_tablename = 'sections';
		
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
	
	
	function save ($data) {
		if (!$data) {
			return;
		}
		$sql = "INSERT INTO {$this->_tablename}(`title`,`text`,`status`,`created`) VALUE 
		('{$data['title']}','{$data['text']}','{$data['status']}',NOW())";

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
	
	public function getAll(){
		return parent::getAll(array(
			'orderby'=>$this->_tablename.'.id ASC'
		));
	}
}