<?php
class Model_Project extends AbstractModel
{

	const STATUS_OFF = 0;
	const STATUS_ON = 1;
	
	protected $_tablename = 'projects';
	
	/**
	 * Singleton
	 * @var AbstractModel
	 */
	private static $_instance = null;
	
	/**
	 * 
	 */
	private function __construct() {
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
		$sql = "INSERT INTO {$this->_tablename}(`section_id`,`title`,`text`,`status`,`created`) VALUE 
		('{$data['section_id']}','{$data['title']}','{$data['text']}','{$data['status']}',NOW())";

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
			'select'=>'sections.title as section_title,projects.*',
			'join'=>'sections ON (projects.section_id = sections.id)',
			'orderby'=>'sections.created DESC, projects.created DESC'
		),$inputParam);
		
		return parent::getAll($param);
	}
	
 	public function getPagin ($id_project, $id_section, $type) {
    	
    	if ($type == 'next') {
    		
    		$condSection = '>';
        	$condSection2 = 'ASC';
    		$condId = '<';
    		$cond2 = 'DESC';
    	}else {
    		$condSection = '<';
    		$condSection2 = 'DESC';
    		$condId = '>';
    		$cond2 = 'ASC';
    		
    	}
    	
    	$sql = 'SELECT projects.title 
    			FROM projects 
    			LEFT JOIN sections ON (projects.section_id = sections.id)
    			WHERE 
    				projects.id '.$condId.' "'.(int)$id_project.'" 
    				AND projects.section_id="'.$id_section.'" 
    				AND projects.status="'.Model_Sample::STATUS_ON.'" 
    				AND sections.status="'.Model_Section::STATUS_ON.'"
    			ORDER BY projects.id '.$cond2.' LIMIT 1';
		$result = $this->query($sql);
		if ($result) {
			return $result;
		}
		
    	$sql = 'SELECT projects.title 
    		FROM projects 
    		LEFT JOIN sections ON (projects.section_id = sections.id)
    		WHERE 
    			projects.section_id'.$condSection.'"'.$id_section.'" 
    			AND projects.status="'.Model_Sample::STATUS_ON.'" 
    			AND sections.status="'.Model_Section::STATUS_ON.'"    
    		ORDER BY projects.section_id '.$condSection2.', projects.id '.$cond2.' LIMIT 1';
    	
    	$result =  $this->query($sql);
 		if ($result) {
			return $result;
		}
		
    	$sql = 'SELECT projects.title 
    		FROM projects 
    		LEFT JOIN sections ON (projects.section_id = sections.id)
    		WHERE 
    			projects.status="'.Model_Sample::STATUS_ON.'" 
    			AND sections.status="'.Model_Section::STATUS_ON.'"    
    		ORDER BY projects.section_id '.$condSection2.', projects.id '.$cond2.' LIMIT 1';
    	return  $this->query($sql);
    }
	

	
	

    
}