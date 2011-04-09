<?php
class Controller_Admin extends AbstractController {

	
	const TYPE_SAMPLE = 'sample';
	const TYPE_PROJECT = 'project';
	const TYPE_SECTION = 'section';
	const TYPE_STATIC = 'staticpage';
	
	
	public function init() {
		parent::init();
		$this->view->setLayout('system');
	}
	
	public function index () {		
	}

	public function sections () {
		$this->view->set('data',Model_Section::instance()->getAll(array('onlyStatusOn'=>false)));
		$this->view->setViewPath('admin/sections');
	}
	
	public function projects ($id = false) {
		$params = array('onlyStatusOn'=>false);
		$isOneEntity = false;
		if ($id) {
			$params['where'] = "section_id = {$id}";
			$isOneEntity = true;
		};
		
		$data = Model_Project::instance()->getAll($params);

		$this->view->set('data',$data);
		$this->view->set('isOneEntity',$isOneEntity);
		$this->view->setViewPath('admin/projects');
	}
	
	public function samples ($id = false) {
		$params = array('onlyStatusOn'=>false);
		$isOneEntity = false;
		$currentProjectId = false;
		if ($id) {
			$params['where'] = "samples.project_id = {$id}";
			$isOneEntity = true;
			$currentProjectId = $id; 
		};
		$this->view->setViewPath('admin/samples');
		
		$modelSample = Model_Sample::instance();
		$this->view->set('currentProjectId',$currentProjectId);
		$allSamples = $modelSample->getAll($params);
		$allSamples = $this->_joinImgPatch($allSamples);
		
		
		$this->view->set('isOneEntity',$isOneEntity);
		$this->view->set('data',$allSamples);
	}
	
	public function addSample($defaultProject = '') {
		$defaultData = array(
			'id'=>'',
			'project_id'=>'',
			'title'=>'',
			'text'=>''
		);
		
		$data = array_merge($defaultData, $this->input->post());
		$data['status'] = (isset($data['status'])) ? Model_Section::STATUS_ON : Model_Section::STATUS_OFF;
		if (!$this->input->post()){
			$data['status']=Model_Section::STATUS_ON;
		}
		
 		if ($data['project_id']) {
		 	if ($data['id']) {
		 		$insertId = $data['id'];
		 		Model_Sample::instance()->update($data);
		 	}else{
		 		$insertId= Model_Sample::instance()->save($data);
		 	}
		 	
		 	if ($insertId) {
		 		$file = $_FILES['file'];
		 		$ext = strtolower(substr($file['name'],-4));
		 		if (!$file['error'] && in_array($ext,array('.jpg'))) {
		 			$filename = UPLOAD_PATH.'sample/'.$insertId.$ext;
		 			
		 			if (is_readable($filename)) {
		 				unlink($filename);
		 			}
		 			move_uploaded_file($file['tmp_name'], $filename);
		 		}
 			
		 		return $this->samples($data['project_id']);
				$data = Model_Sample::instance()->getBy('id',$insertId);
				$data = $data[0];
		 	}
		 }else{
		 	$data['project_id'] = (int) $defaultProject;
		 }
	
		$this->view->setViewPath('admin/addsample');
		$this->view->set('data',$data);
		$this->view->set('projects',Model_Project::instance()->getAll(array('onlyStatusOn'=>false)));
	}
	
	public function addsection () {
		$defaultData = array(
			'id'=>'',
			'title'=>'',
			'text'=>''
		);
		
		$data = array_merge($defaultData, $this->input->post());

		$data['status'] = (isset($data['status'])) ? Model_Section::STATUS_ON : Model_Section::STATUS_OFF;
		if (!$this->input->post()){
			$data['status']=Model_Section::STATUS_ON;
		}
		
		if ($this->input->post()) {
		 	if ($data['id']) {
		 		$insertId = $data['id'];
		 		Model_Section::instance()->update($data);
		 	}else{
		 		$insertId= Model_Section::instance()->save($data);
		 	}
		 	
		 	if ($insertId) {
		 		return $this->sections();
		 	}
		}
	
		$this->view->setViewPath('admin/addsection');
		$this->view->set('data',$data);
		$this->view->set('projects',Model_Project::instance()->getAll(array('onlyStatusOn'=>false)));
		$this->view->set('sections',Model_Section::instance()->getAll(array('onlyStatusOn'=>false)));
	}
	
	
	public function addproject ($curentSectionId = 0) {
		$defaultData = array(
			'id'=>'',
			'section_id'=>'',
			'title'=>'',
			'text'=>''
		);

		$data = array_merge($defaultData, $this->input->post());

		$data['status'] = (isset($data['status'])) ? Model_Project::STATUS_ON : Model_Project::STATUS_OFF;
		if (!$this->input->post()){
			$data['status']=Model_Project::STATUS_ON;
		}
		
 		if ($data['section_id']) {
		 	if ($data['id']) {
		 		$insertId = $data['id'];
		 		Model_Project::instance()->update($data);
		 	}else{
		 		$insertId= Model_Project::instance()->save($data);
		 	}
		 	
		 	if ($insertId) {
		 		return $this->projects();
		 	}
		 }
	
		$data['section_id']=(int)$curentSectionId;
		 
		$this->view->setViewPath('admin/addproject');
		$this->view->set('data',$data);
		$this->view->set('projects',Model_Project::instance()->getAll(array('onlyStatusOn'=>false)));
		$this->view->set('sections',Model_Section::instance()->getAll(array('onlyStatusOn'=>false)));
	}
	
	public function edit($type, $id) {
		$model = $this->_getModelByType($type);
		$data = $model->getBy('id',$id);
		
		$this->view->set('data',$data[0]);
		$this->view->set('projects',Model_Project::instance()->getAll(array('onlyStatusOn'=>false)));
		$this->view->set('sections',Model_Section::instance()->getAll(array('onlyStatusOn'=>false)));
		
		$this->view->setViewPath('admin/add'.$type);
	}

	
	public function delete ($type, $id) {
		$model = $this->_getModelByType($type);
		
		$result = $model->deleteBy('id',$id);
		
		if ($type==self::TYPE_SAMPLE){
			$filename = UPLOAD_PATH.'sample/' . $id .'.jpg';
			if (is_writable($filename)) { 
				unlink($filename);
			}
		}
		$methodRedirect = $type.'s';
		$this->$methodRedirect();
	}
	
	
	public function staticPage () {
		$this->view->set('allStatic', Model_Info::instance()->getAll());
	}
	
	public function addstaticpage() {
		$defaultData = array(
			'id'=>'',
			'text'=>''
		);
		
		$data = array_merge($defaultData, $this->input->post());

	 	if ($data['id']) {
	 		$insertId = $data['id'];
	 		Model_Info::instance()->update($data);
	 	}else{
	 		$insertId= Model_Info::instance()->save($data);
	 	}

	
		$this->view->setViewPath('admin/addstaticpage');
		$this->view->set('data',$data);
		$this->view->set('allStatic', Model_Info::instance()->getAll());
	}
	
	
	private function _getModelByType ($type) 
	{
		switch ($type)
		{
			case self::TYPE_SAMPLE:
				$model = Model_Sample::instance();
				break; 
			case self::TYPE_SECTION:
				$model = Model_Section::instance();
				break; 
			case self::TYPE_PROJECT:
				$model = Model_Project::instance();
				break;
			case self::TYPE_STATIC:
				$model = Model_Info::instance();
				break;
			default:
				$model = false;
		}
		return $model; 		
	}
	
	private function _joinImgPatch (array $samples) 
	{	
		foreach ($samples as $key=>$val) {
			$filename = UPLOAD_PATH.'sample/'.$val['id'].'.jpg';
			if (is_readable($filename)) {
				$samples[$key]['img'] = $filename;
			}else{
				$samples[$key]['img'] = false;
			}
		}
		return $samples; 
	}
		
}
