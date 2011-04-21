<?php
class Controller_Index extends AbstractController 
{

	public function index () 
	{
		$this->view->setPageDescription('Дизайн  выставочных стендов, торгового оборудования. Наружная реклама, печатная продукция, полиграфия, рисунки');
		$this->view->setPageTitle('Вкусные и полезные проекты');
			
		$sections =  Model_Section::instance()->getAll();
		$this->view->set('sections', $sections);
				
		foreach ($sections as $section) {
			$keywords[] = $section['title'];
		}
		$this->view->setPageKeywords(implode(', ',$keywords));

		$this->view->set('block', $this->_getBlock());		
	}

	
	public function section($sectionC, $sample_id='')
	{
		
		$sections = Model_Section::instance()->getAll();
		
		foreach($sections as &$section) {
			if(mb_strtolower($section['title'],'UTF-8') == mb_strtolower($sectionC,'UTF-8')){				
				$section['isCurrent'] = true;				
				$sectionCurr = array(
					'id'=>$section['id'],
					'title'=>$section['title'],
					'text'=>$section['text']
				); 
			}
		}
		
		if (!isset($sectionCurr)){
			throw new AbstractException('раздел '.$sectionC.' не найден');
		}
		
						
		$samples = Model_Sample::instance()->query('
				SELECT s1.id as sample_id,  s1.title as sample_title, projects.title as project_title, s1.project_id as project_id
				FROM samples as s1 
				LEFT OUTER JOIN samples as s2 
					ON (s1.project_id = s2.project_id AND s1.id < s2.id)
				LEFT JOIN projects ON (projects.id = s1.project_id) 
				WHERE s2.project_id is NULL 
					AND s1.project_id IN (SELECT id FROM projects WHERE section_id='.$sectionCurr['id'].')
				ORDER BY s1.project_id DESC'
		);
		
		$sampleC = Model_Sample::instance()->getBy('id',$sample_id);
		if ($sampleC) {
			foreach ($samples as $key => $sample){
				if ($sampleC[0]['project_id'] == $sample['project_id']){
					$sampleC[0]['project_title'] = $sample['project_title'];
					$tmp = array(
						'sample_id' =>$sampleC[0]['id'],
						'sample_title' => $sampleC[0]['title'],
						'project_id' => $samples[$key]['project_id'],
						'project_title' => $samples[$key]['project_title'],
					);
					unset($samples[$key]);
					array_unshift($samples, $tmp);
				}
			}
		}else{
			$sample_id='';
		}		
		
		
//		foreach ($projects as $projectKey => $project){
//			$projects[$projectKey]['count'] = (isset($samplesCountMod[$project['project_id']])) ? $samplesCountMod[$project['project_id']] : '0';
//		}
		
//		$allSamples = Model_Sample::instance()->query('
//				SELECT samples.id, samples.project_id, samples.title, samples.text
//				FROM samples,sections,projects
//				WHERE  samples.project_id = projects.id AND projects.section_id=sections.id AND sections.id='.$sectionCurr['id'].'
//				');
		
		
//		$tmpSamples = array();
//		foreach ($allSamples as $sample) {
//			$tmpSamples[$sample['project_id']][]=$sample;
//		}
//		$allSamples = $tmpSamples;
		
		
		$this->view->setPageDescription($sectionCurr['text']);
		$this->view->setPageTitle($sectionCurr['title']);


//		$this->view->set('projects', $projects); // для лицевых картинок
//		$this->view->set('allSamples', $allSamples); // для модального окна

		//$this->view->set('samplesCountMod', $this->_getSamplesCount($sectionCurr['id']);

		$this->view->set('sectionCurr', $sectionCurr);
		$this->view->set('sample_id', $sample_id);
		
		$this->view->set('sections', $sections);
		$this->view->set('samples', $samples);
	}
	
	private function _getSamplesCount($sectionId) {
		$samplesCount = Model_Sample::instance()->getCountBySectionId($sectionId);
		
		$samplesCountMod = array();
		foreach($samplesCount as $countSample){
			$samplesCountMod[$countSample['project_id']] = $countSample['count'];
		}
		return $samplesCountMod;
	}
	
		
	public function project($projectC, $sample_id='')
	{
	
		$projectCurr = Model_Project::instance()->getAll(
				array(
					'LEFT JOIN sections ON (projects.section_id = sections.id)',
					'where'=>'projects.title ="'.$projectC.'" AND sections.status='.Model_Section::STATUS_ON));
		
		if (!isset($projectCurr[0])) {
			throw new AbstractException('проект '.$projectC.' не найден');
		}
		
		$projectC = $projectCurr[0]['title'];
		
		$sectionCurr = array(
			'section_id'=>$projectCurr[0]['section_id'],
			'title'=>$projectCurr[0]['section_title']
		);
		
		
		$projects = Model_Project::instance()->getAll(array('where'=> 'sections.id ='.$sectionCurr['section_id']));
		
		foreach($projects as $project) {
			if($project['title']==$projectC){
				$projectCurr = $project; 
			}
		}
		
		$conditions = array(
			'where'=>'project_id = '.$projectCurr['id'],
			'orderby'=>'id DESC'
		);
		
		
		if ($sample_id) {
			//$conditions['orderby']="FIELD(samples.id,".$sample_id.") desc";
		}
		
		$samples = Model_Sample::instance()->getAll($conditions);
		

		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
			echo View::factory('element/project',array(
			'samples'=>$samples,
			'sample_id'=>$sample_id,
			'projectCurr'=>$projectCurr
			));
			exit();
		}
		
		if (Helper_Js::isEnabledJs()) {
			header('Location: '.Helper_Html::link(array('controller'=>'index','action'=>'section','param1'=>$sectionCurr['title'],'#'=>'/'.$projectC.'/'.$sample_id)));	
		}
		
		
		$samplesCountMod = $this->_getSamplesCount($sectionCurr['section_id']);
		
		foreach ($projects as $projectKey => $project){
			$projects[$projectKey]['count'] = (isset($samplesCountMod[$project['id']])) ? $samplesCountMod[$project['id']] : '0';
		}
		
		
		$pagination = array( 
			'prev' => Model_Project::instance()->getPagin($projectCurr['id'], $projectCurr['section_id'], 'prev'),
			'next' => Model_Project::instance()->getPagin($projectCurr['id'], $projectCurr['section_id'], 'next'),
		);
		$this->view->set('pagination', $pagination);
		//return View::factory('element/project',array('samples'=>$samples,'sample_id'=>$sample_id));
		
	
		$this->view->setPageDescription($projectCurr['text']);
		$this->view->setPageTitle($sectionCurr['title'].' - '.$projectCurr['title']);
		
		
		$this->view->set('sections', Model_Section::instance()->getAll());
	 
		$sapmlesCurrentArrayId = 0;
		if ($sample_id) {
			foreach ($samples as $arrayKey => $sample) {
				if ($sample['id'] == $sample_id){
					$sapmlesCurrentArrayId = $arrayKey;
				}
			}
		}
		
		$this->view->set('sapmlesCurrentArrayId',$sapmlesCurrentArrayId);
	
		
		$this->view->set('samples', $samples);
//		$this->view->set('sectionCurr', $sectionCurr);
		$this->view->set('projectCurr', $projectCurr);
//		$this->view->set('projects', $projects);
//		
	}
	
	private function _getBlock () 
	{
		$block = Model_Sample::instance()->getBlock();

		$sections=array();
		foreach ($block as $val) {
			if (!isset($sections[$val['section_id']])) {
				$sections[$val['section_id']] = array(
					'id' => (int) $val['section_id'],
					'title' => $val['section'],
					//'projects'=>array()
				);
			}
			
//			if (!isset($sections[$val['section_id']]['projects'][$val['project_id']])) {
//			   $sections[$val['section_id']]['projects'][$val['project_id']] = 
//					array(
//					'id' => $val['project_id'],
//					'title' => $val['project'],
//					'samples'=>array()
//				);
//			}
			
			$sections[$val['section_id']]['samples'][$val['id']]=array(			
				'id'=>(int) $val['id'],
				'sample_title'=>$val['sample_title'],
				'project_id'=>(int)$val['project_id'],
				'project_title'=>$val['project']
			);
			
//			$sections[$val['section_id']]['projects'][$val['project_id']]['samples'][$val['id']]=array(
//				'id'=>(int) $val['id'],
//				'sample_title'=>$val['sample_title']
//			);
		}
	
		$resultData = array();
		for ($i=0; $i<2; $i++) {
			foreach ($sections as $key => $val) {
				$data = array();
				$data['section_id'] = $val['id'];
				$data['section_title'] = $val['title'];
//				$project_id = array_rand($sections[$key]['projects']);
//					$data['project_id'] = $project_id;
//					$data['project_title'] = $val['projects'][$project_id]['title'];
				$sample_id  = array_rand($val['samples']);
					if ($sample_id) {
						$data['sample_id'] = $val['samples'][$sample_id]['id'];
						$data['sample_title'] = $val['samples'][$sample_id]['sample_title'];
						$data['project_id'] = $val['samples'][$sample_id]['project_id'];
						$data['project_title'] = $val['samples'][$sample_id]['project_title'];
							unset($sections[$key]['samples'][$sample_id]);
						$resultData[]=$data;
					}
			}
		}
		
		return $resultData; 
	}
}

/*
 *  SQL
 * 
CREATE TABLE `projects` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT, 
  `section_id` int(1) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `text` varchar(1500) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created` TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `section_id_idx` (`section_id`),
  KEY `status_idx` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `sections` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT, 
  `title` varchar(100) NOT NULL DEFAULT '',
  `text` varchar(1500) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created` TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `samples` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT, 
  `project_id` int(3) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `text` varchar(1500) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created` TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id_idx` (`project_id`),
  KEY `status_idx` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `samples` add `youtube_hash` varchar(12) NOT NULL DEFAULT '';

CREATE TABLE `static` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT, 
  `text` varchar(1500) NOT NULL DEFAULT '',
  `created` TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO static (id, text, created) 
	VALUES 
	(1, 'sample text_1', NOW()), 
	(2, 'sample text_2', NOW()),
	(3, 'sample text_3', NOW());
*/


