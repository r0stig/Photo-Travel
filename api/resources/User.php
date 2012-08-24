<?php
require_once('../class/DBAL.php');

use Tonic\Resource,
    Tonic\Response,
    Tonic\ConditionException;
    

/**
 * @uri /users
 */
class UserCollection extends Resource {

	/**
	 * @method GET
	 */
	function getUsers() {
		return json_encode(DBAL::getInstance()->getUsers());
	}

}