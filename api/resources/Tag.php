<?php
require_once('../class/DBAL.php');

use Tonic\Resource,
    Tonic\Response,
    Tonic\ConditionException;
    
/**
 * @uri /tags
 *
 */
class TagCollection extends Resource {
	/**
	 * @method GET
	*/
	function getTags() {
		return json_encode(DBAL::getInstance()->getTopTags());
	}
}