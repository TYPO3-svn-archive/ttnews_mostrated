<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied');
}

// Hook to ratings
$TYPO3_CONF_VARS['EXTCONF']['ratings']['updateRatings'][] = 'EXT:' . $_EXTKEY . '/class.tx_ttnewsmostrated_hooks.php:&tx_ttnewsmostrated_hooks->updateRatingHook';
$TYPO3_CONF_VARS['EXTCONF']['tt_news']['selectConfHook'][] = 'EXT:' . $_EXTKEY . '/class.tx_ttnewsmostrated_hooks.php:&tx_ttnewsmostrated_hooks';
$TYPO3_CONF_VARS['EXTCONF']['tt_news']['extraCodesHook'][] = 'EXT:' . $_EXTKEY . '/class.tx_ttnewsmostrated_hooks.php:&tx_ttnewsmostrated_hooks';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['what_to_display'][] = array('MOST RATED', 'tx_ttnewsmostrated_1');

?>