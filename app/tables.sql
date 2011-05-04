
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
  `text` varchar(5000) NOT NULL DEFAULT '',
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
	
alter table samples modify  text varchar(5000) NOT NULL DEFAULT '';

