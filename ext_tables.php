<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = array (
	'tx_ttnewsmostrated_ratingval' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:ttnews_mostrated/locallang_db.xml:tt_news.tx_ttnewsmostrated_ratingval',		
		'config' => array (
			'type' => 'none',
		)
	),
);


t3lib_div::loadTCA('tt_news');
t3lib_extMgm::addTCAcolumns('tt_news',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_news','tx_ttnewsmostrated_ratingval;;;;1-1-1');

t3lib_extMgm::addStaticFile($_EXTKEY,'static/most_rated_news/', 'Most rated news');
?>