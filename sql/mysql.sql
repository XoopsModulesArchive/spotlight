CREATE TABLE spotlight (
  sid int(5) unsigned NOT NULL default '0',
  item int(5) unsigned NOT NULL default '1',
  auto int(5) unsigned NOT NULL default '0',
  module varchar(25) NOT NULL default 'news',
  image varchar(50) NOT NULL default 'spotlight.png',
  auto_image int(5) unsigned NOT NULL default '0',
  imagealign varchar(6) NOT NULL default 'left'
) TYPE=MyISAM;

INSERT INTO spotlight VALUES (2, 1, 0, 'wfsection', 'spotlight.png', 0, 'left');
INSERT INTO spotlight VALUES (1, 1, 0, 'news', 'spotlight.png', 0, 'left');

CREATE TABLE `spotlight_mini` (
  `mini_id` smallint(2) unsigned NOT NULL auto_increment,
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `mini_img` varchar(50) NOT NULL default '',
  `mini_text` text NOT NULL,
  `mini_align` tinyint(1) NOT NULL default '0',
  `mini_show` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`mini_id`)
) TYPE=MyISAM;

CREATE TABLE `spotlight_xml` (
  `xml_id` mediumint(8) unsigned NOT NULL auto_increment,
  `xml_url` varchar(255) NOT NULL default '',
  `xml_title` varchar(255) NOT NULL default '',
  `xml_text` text NOT NULL,
  `xml_order` smallint(2) NOT NULL default '0',
  PRIMARY KEY  (`xml_id`)
) TYPE=MyISAM;
