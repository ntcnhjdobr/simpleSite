<?php
class Model_Sample extends AbstractModel
{
	const STATUS_OFF = 0;
	const STATUS_ON = 1;
	
	protected $_tablename = 'samples';
		
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
		$sql = "INSERT INTO {$this->_tablename}(`project_id`,`title`,`text`,`status`,`created`) VALUE 
		('{$data['project_id']}','{$data['title']}','{$data['text']}','{$data['status']}',NOW())";

        return  parent::save($sql);
	}
	

	public function getAll(array $inputParam = array()) {
		$param = array_merge(array(
			'select'=>'projects.title as project_title,samples.*',
			'join'=>'projects ON (samples.project_id = projects.id)'
		),$inputParam);
		return parent::getAll($param);
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
	
	
	public function getBlock($limit = false) {
		
		$sql = "
		SELECT section_id, sections.title as section, project_id, projects.title as project, samples.id, samples.title as sample_title
		FROM samples 
		LEFT JOIN projects ON (projects.id = samples.project_id)
		LEFT JOIN sections ON (sections.id = projects.section_id)
		WHERE   sections.status=1 AND projects.status=1 AND samples.status=1
		ORDER BY section_id desc, project_id, samples.id
		"; 
		
		if ($limit) {
			$sql=$sql.' LIMIT '.(int)$limit;
		}
		
		return $this->query($sql);
	}
	
	
	public function getCountBySectionId ($section_id) 
	{
		$sql = "
			SELECT project_id, count(samples.id) as count 
			FROM samples
			WHERE samples.project_id IN (SELECT id FROM projects WHERE section_id=".$section_id.") AND samples.status = '1' 
			GROUP BY project_id
		"; 
		return $this->query($sql);
	}

}