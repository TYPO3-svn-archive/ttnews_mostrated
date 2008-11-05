<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Dmitry Dulepov (dmitry@typo3.org)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Hook for ratings and tt_news.
 *
 * Comment management script.
 *
 * $Id: $
 *
 * @author Dmitry Dulepov <dmitry@typo3.org>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   55: class tx_ttnewsmostrated_hooks
 *   66:     function updateRatingHook(array &$params, &$pObj)
 *   87:     function processSelectConfHook(tx_ttnews &$pObj, array &$selectConf)
 *  103:     function extraCodesProcessor(tx_ttnews &$pObj)
 *
 * TOTAL FUNCTIONS: 3
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Hook for ratings and tt_news.
 *
 */
class tx_ttnewsmostrated_hooks {

	private $addWhere = false;

	/**
	 * Called when ratings are updated
	 *
	 * @param	array		$params	Parameters to the hook
	 * @param	tx_ratings_ajax		$pObj
	 * @return	void
	 */
	function updateRatingHook(array &$params, &$pObj) {
		if (preg_match('/^tt_news_\d+$/', $params['ref'])) {
			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('rating/vote_count AS t',
						'tx_ratings_data',
						'reference=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($params['ref'], 'tx_ratings_data'));
			if (count($rows) == 1) {
				$uid = substr($params['ref'], 8);
				$ratingVal = $rows[0]['t'];
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tt_news', 'uid=' . intval($uid),
						array(
							'tx_ttnewsmostrated_ratingval' => $ratingVal,
							'tx_ttnewsmostrated_ratingnum' => 'tx_ttnewsmostrated_ratingnum+1'
						), array(
							'tx_ttnewsmostrated_ratingnum'
						));
			}
		}
	}

	/**
	 * Modifies select configuration if necessary
	 *
	 * @param	tx_ttnews		$pObj	Reference to parent object
	 * @param	array		$selectConf	Select configuration
	 * @return	array		Modified configuration
	 */
	function processSelectConfHook(tx_ttnews &$pObj, array &$selectConf) {
		if ($this->addWhere) {
			if (trim($selectConf['where'])) {
				$selectConf['where'] .= ' AND ';
			}
			$selectConf['where'] .= 'tt_news.tx_ttnewsmostrated_ratingval>=' .
							floatval($pObj->conf['tx_ttnewsmostrated_ratingValue']) .
							' AND tt_news.tx_ttnewsmostrated_ratingnum>=' .
							intval($pObj->conf['tx_ttnewsmostrated_ratingNumber']);
			// Make sure that page browser does not affect us
			$selectConf['begin'] = 0;
			unset($pObj->config['listStartId']);
		}
		return $selectConf;
	}

	/**
	 * Processes our custom code
	 *
	 * @param	tx_ttnews		$pObj	Reference to parent object
	 * @return	string		Generated content
	 */
	function extraCodesProcessor(tx_ttnews &$pObj) {
		$content = '';
		if (strcasecmp($pObj->theCode, 'tx_ttnewsmostrated_1') == 0) {
			$orderBy = $pObj->config['orderBy'];
			$ascDesc = $pObj->config['ascDesc'];
			$pObj->config['orderBy'] = intval($pObj->conf['tx_ttnewsmostrated_orderBy']) == 0 ?
								'tx_ttnewsmostrated_ratingnum' : 'tx_ttnewsmostrated_ratingval';
			$pObj->config['ascDesc'] = 'DESC';
			$pObj->theCode = 'LIST';
			$this->addWhere = true;

			// Make sure that page browser does not affect us
			$savedValues['orderBy'] = $pObj->config['orderBy'];
			$savedValues['ascDesc'] = $pObj->config['ascDesc'];
			$savedValues['latestWithPagebrowser'] = $pObj->conf['latestWithPagebrowser'];
			$savedValues['excludeAlreadyDisplayedNews'] = $pObj->conf['excludeAlreadyDisplayedNews'];
			$savedValues['excludeLatestFromList'] = $pObj->conf['excludeLatestFromList'];
			$savedValues['pointer'] = $pObj->piVars['pointer'];
			$pObj->piVars['pointer'] = 0;
			$pObj->config['orderBy'] = $orderBy;
			$pObj->config['ascDesc'] = $ascDesc;
			$pObj->conf['latestWithPagebrowser'] = 0;
			$pObj->conf['excludeAlreadyDisplayedNews'] = 0;
			$pObj->conf['excludeLatestFromList'] = 0;

			$content = $pObj->displayList();

			$pObj->config['orderBy'] = $savedValues['orderBy'];
			$pObj->config['ascDesc'] = $savedValues['ascDesc'];
			$pObj->conf['latestWithPagebrowser'] = $savedValues['latestWithPagebrowser'];
			$pObj->conf['excludeAlreadyDisplayedNews'] = $savedValues['excludeAlreadyDisplayedNews'];
			$pObj->conf['excludeLatestFromList'] = $savedValues['excludeLatestFromList'];
			$pObj->piVars['pointer'] = $savedValues['pointer'];

			$this->addWhere = false;
		}
		return $content;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ttnews_mostrated/class.tx_ttnewsmostrated_hooks.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ttnews_mostrated/class.tx_ttnewsmostrated_hooks.php']);
}

?>