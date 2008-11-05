<?php

########################################################################
# Extension Manager/Repository config file for ext: "ttnews_mostrated"
#
# Auto generated 05-11-2008 10:33
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Most rated news list',
	'description' => 'Shows most rated news with a defined minimum rating value',
	'category' => 'plugin',
	'author' => 'Dmitry Dulepov',
	'author_email' => 'dmitry@typo3.org',
	'shy' => '',
	'dependencies' => 'tt_news,ratings',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tt_news',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => 'SIA "ACCIO"',
	'version' => '0.3.0',
	'constraints' => array(
		'depends' => array(
			'tt_news' => '2.5.2-2.9.9',
			'ratings' => '1.0.8-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:10:{s:9:"ChangeLog";s:4:"b121";s:34:"class.tx_ttnewsmostrated_hooks.php";s:4:"cd10";s:12:"ext_icon.gif";s:4:"6b26";s:17:"ext_localconf.php";s:4:"c79b";s:14:"ext_tables.php";s:4:"7d31";s:14:"ext_tables.sql";s:4:"5f1f";s:16:"locallang_db.xml";s:4:"66a0";s:14:"doc/manual.sxw";s:4:"314b";s:36:"static/most_rated_news/constants.txt";s:4:"d371";s:32:"static/most_rated_news/setup.txt";s:4:"1e33";}',
	'suggests' => array(
	),
);

?>