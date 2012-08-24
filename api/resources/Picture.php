<?php
require_once('../class/DBAL.php');
require_once('../class/Authentication.php');

use Tonic\Resource,
    Tonic\Response,
    Tonic\ConditionException;
    

/**
 * $uri /picture
 * @uri /picture/:id
 */
class Picture extends Resource {

	/**
	 * @method GET
	 */
	function getPicture($id) {
		return json_encode(DBAL::getInstance()->getPictureById($id));
	}
	/**
	 * @method PUT
	 * @param int $id
	 */
	function savePicture($id) {
		$user_id = Authentication::getSignedUserID();
		if ($user_id !== -1) {
			$data = json_decode($this->request->data);
			DBAL::getInstance()->updatePicture(1, $id, $data->description, explode(',', $data->tags));
		}
	}
	
	/**
	 * @method DELETE
	 * @param int $id
	 */
	function deletePicture($id) {
		$user_id = Authentication::getSignedUserID();
		if ($user_id !== -1) {
			$picture = DBAL::getInstance()->getPictureById($id);
			// Delete all images accociated with this picture, thumbs and such.
			
			unlink($picture['phy_path']);
			unlink($picture['path_small']);
			unlink($picture['path_medium']);
			unlink($picture['path_large']);
			DBAL::getInstance()->deletePicture($id, $user_id);
		}
	}

}
/**
 * @uri /pictures/user/:user_id
 */
class PicturesByUser extends Resource {

    /**
     * @method GET
     * @param int $user_id
     */
    function listPictures($user_id) {
        return json_encode(DBAL::getInstance()->getPicturesByUser($user_id));
    }
}
/**
 * @uri /pictures/tags/:tags
 */
class PicturesByTags extends Resource {
    /**
     * @method GET
     * @param int $user_id
     */
    function listPictures($tags) {
        return json_encode(DBAL::getInstance()->getPicturesByTags($tags));
    }
}
/**
 * @uri /pictures/location/:latitude/:longitude/:distance
 */
class PictureByCoordinates extends Resource {
    /**
     * @method GET
     * @param int $user_id
     */
    function listPictures($latidude, $longitude, $distance) {
        return "pictures via coord";
    }
}
/**
 * @uri /pictures/time/:start/:end
 */
class PictureByTime extends Resource {
    /**
     * @method GET
     * @param int $user_id
     */
    function listPictures($start, $end) {
        return "pictures via tid";
    }
}