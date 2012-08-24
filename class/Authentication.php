<?php
require_once('DBAL.php');

session_start();

class Authentication {

	public static function validateUser($email, $password) {
		$user = DBAL::getInstance()->getUserByEmail($email);
		
		if (count($user) == 0) {
			// Throw UserNotFoundException
			return false;
		} else {
			if ( sha1($user['salt'].$password) == $user['password'] ) {
				Authentication::setSession($user['id']);
				return true;
			} else {
				return false;
			}
		}
	}
	
	public static function logoutUser() {
		Authentication::removeSession();
	}
	
	public static function isLogged() {
		return (Authentication::getSignedUserID !== -1);
	}
	/**
	 * Gets the signed user_id
	 *
	 * @return user_id if logged in user
	 * @throw AuthException if no user logged in
	 */
	public static function getSignedUserID() {
		if (! isset($_SESSION['user_id'])) {
			return -1;
		} else {
			return $_SESSION['user_id'];
		}
	}
	
	private static function setSession($user_id) {
		$_SESSION['user_id'] = $user_id;
	}
	
	private static function removeSession() {
		session_destroy();
	}
	
}