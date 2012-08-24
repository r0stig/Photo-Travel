<?php
/**
 * Database Abstraction Layer
 *
 * Singleton
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */
class DBAL {

    private $pdo;
    private static $__instance;
    
    private function __construct() {
        $this->pdo = new PDO(
        'mysql:host=localhost;dbname=project_phototravel',
        'root',
        '');
        //$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 1);

    }
    
    public static function getInstance() {
        if (!self::$__instance) {
            self::$__instance = new DBAL();
        }
        return self::$__instance;
    }
	
	public function getPictureById($picture_id) {
		$res = array();
        $query = "SELECT users.name, users.surname, pictures.id, " . 
		"pictures.description,pictures.uri_path as path, pictures.phy_path as phy_path, picture_infos.latitude, " . 
		"picture_infos.longitude, picture_infos.photo_shot, " .
		"thumb_small.phy_path as path_small, thumb_small.uri_path as uri_small, " . 
		"thumb_medium.phy_path as path_medium, thumb_medium.uri_path as uri_medium, " . 
		"thumb_large.phy_path as path_large, thumb_large.uri_path as uri_large " . 
        " FROM pictures " . 
		"INNER JOIN thumbnails thumb_small ON thumb_small.picture_id = pictures.id " . 
		"INNER JOIN thumbnails thumb_medium ON thumb_medium.picture_id = pictures.id " . 
		"INNER JOIN thumbnails thumb_large ON thumb_large.picture_id = pictures.id " . 
		"INNER JOIN users ON users.id = pictures.user_id " . 
		"INNER JOIN picture_infos ON picture_infos.picture_id = pictures.id " . 
		"WHERE pictures.id = :picture_id AND thumb_small.type = 0 AND thumb_medium.type = 1 AND thumb_large.type = 2 " . 
		"ORDER BY picture_infos.photo_shot ASC";
		
		$stmt = $this->pdo->prepare($query);
		# print_r($stmt->errorInfo());
		# echo $query;
        $stmt->execute(array(
            'picture_id' => $picture_id
        ));
		
		$pictures = $stmt->fetch();
		
		# Get the tags
		$tags = $this->getTagsByPictureID($picture_id);
		$tags = array('tags' => $tags);
		
		
		try {
			$res = array_merge($pictures, $tags);
		} catch (Exception $e) {
		}
		
        return $res;
	}
    
    public function getPicturesByUser($userid) {
    
        $query = "SELECT users.name, users.surname, pictures.id, " . 
		"pictures.description,pictures.uri_path as path, picture_infos.latitude, " . 
		"picture_infos.longitude, picture_infos.photo_shot, " .
		"thumb_small.phy_path as path_small, thumb_small.uri_path as uri_small, " . 
		"thumb_medium.phy_path as path_medium, thumb_medium.uri_path as uri_medium, " . 
		"thumb_large.phy_path as path_large, thumb_large.uri_path as uri_large " . 
        " FROM pictures " . 
		"INNER JOIN thumbnails thumb_small ON thumb_small.picture_id = pictures.id " . 
		"INNER JOIN thumbnails thumb_medium ON thumb_medium.picture_id = pictures.id " . 
		"INNER JOIN thumbnails thumb_large ON thumb_large.picture_id = pictures.id " . 
		"INNER JOIN users ON users.id = pictures.user_id " . 
		"INNER JOIN picture_infos ON picture_infos.picture_id = pictures.id " . 
		"WHERE users.id = :user_id AND thumb_small.type = 0 AND thumb_medium.type = 1 AND thumb_large.type = 2 " . 
		"ORDER BY picture_infos.photo_shot ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            'user_id' => $userid
        ));
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// Get tags and include them in the result
		foreach($res as &$row) {
			$row = array_merge($row, array('tags' => $this->getTagsByPictureID($row['id'])));
		}
		
        return $res;
    }

    public function getPicturesByTags($tags) {
		if (is_array($tags)) {
			$tags = implode(',', $tags);
		}
        $query = "SELECT users.name, users.surname, pictures.id, " . 
		"pictures.description,pictures.uri_path as path, picture_infos.latitude, " . 
		"picture_infos.longitude, picture_infos.photo_shot, " .
		"thumb_small.phy_path as path_small, thumb_small.uri_path as uri_small, " . 
		"thumb_medium.phy_path as path_medium, thumb_medium.uri_path as uri_medium, " . 
		"thumb_large.phy_path as path_large, thumb_large.uri_path as uri_large " . 
        " FROM pictures " . 
		"INNER JOIN thumbnails thumb_small ON thumb_small.picture_id = pictures.id " . 
		"INNER JOIN thumbnails thumb_medium ON thumb_medium.picture_id = pictures.id " . 
		"INNER JOIN thumbnails thumb_large ON thumb_large.picture_id = pictures.id " . 
		"INNER JOIN users ON users.id = pictures.user_id " . 
		"INNER JOIN picture_infos ON picture_infos.picture_id = pictures.id " . 
		"WHERE (:tags) IN (SELECT name FROM picture_tags INNER JOIN tags ON tags.id = picture_tags.tag_id WHERE picture_id = pictures.id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            'tags' => $tags
        ));
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// Get tags and include them in the result
		foreach($res as &$row) {
			$row = array_merge($row, array('tags' => $this->getTagsByPictureID($row['id'])));
		}
		
        return $res;
    }
    public function getPicturesByCoordinates($latitude, $longitude, $distance) {
    }
    public function getPicturesByPhotoShot($startTimestamp, $endTimestamp) {
    }
	/**
	 * Deletes the picture from the database
	 * The database has foreign keys CASCADE, so we won't need to delete the entries in picture_infos, picture_tags.
	 */
	public function deletePicture($picture_id, $user_id) {
		$query = 'DELETE FROM pictures WHERE id = :id AND user_id = :user_id';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute(array(
			'id' => $picture_id,
			'user_id' => $user_id
		));
		
		return true;
	}
	
	public function updatePicture($user_id, $picture_id, $description, $tags) {
		$query = 'UPDATE pictures SET description = :description WHERE id = :id';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute(array(
			'description' => $description,
			'id' => $picture_id
		));
		
		$this->updateTags($user_id, $picture_id, $tags);
	}
    
    public function insertPicture($user_id, $phy_path, $uri_path, $latitude, $longitude, $photo_shot, $description, $tags, $thumbnails) {
        //TO-DO: Should add transaction here, to be able to rollback later..
        $query = "INSERT INTO pictures(user_id, phy_path, uri_path, description) VALUES(1, :phy_path,:uri_path ,:description)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            'phy_path' => $phy_path,
            'uri_path' => $uri_path,
            'description' => $description
        ));
        print_r($stmt->errorInfo());
        
        $temp = $stmt->fetch(PDO::FETCH_ASSOC);
        $picture_id = $this->pdo->lastInsertId(); //$temp['pictures_id'];
        print_r($temp);
        echo "<----";
        
        $query = "INSERT INTO picture_infos(picture_id, latitude, longitude, photo_shot) VALUES(:picture_id, :latitude, :longitude, :photo_shot)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            'picture_id' => $picture_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'photo_shot' => $photo_shot
        ));
		
		// Insert thumbnails
		$query = "INSERT INTO thumbnails(picture_id, phy_path, uri_path, type) VALUES(:picture_id, :phy_path, :uri_path, :type)";
		$stmt = $this->pdo->prepare($query);
		for($i = 0; $i < count($thumbnails); $i++) {
			$stmt->execute(array(
				'picture_id' => $picture_id,
				'phy_path' => $thumbnails[$i]['phy_path'],
				'uri_path' => $thumbnails[$i]['uri_path'],
				'type' => $thumbnails[$i]['type']
			));
			//print_r( $stmt->errorInfo());
		}
        
        $this->updateTags($user_id, $picture_id, $tags);
        
        return true;
    }
	/**
	 * Tags
	 */
	function getTopTags() {
		$query = 'SELECT tags.name, COUNT(tags.id) as c FROM tags ' .
			'INNER JOIN picture_tags ON picture_tags.tag_id = tags.id ' .
			'GROUP BY tags.name ' .
			'ORDER BY c DESC ' .
			'LIMIT 20';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
    
    function updateTags($user_id, $picture_id, $tags) {
        // TO-DO: Should start transaction here, to be able to rollback later..
        $query = 'DELETE FROM picture_tags WHERE picture_id = :picture_id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            'picture_id' => $picture_id
        ));
		//print_r($stmt->errorInfo());
        
        $query = 'INSERT INTO picture_tags(picture_id, tag_id) VALUES(:picture_id, :tag_id)';
        $stmt = $this->pdo->prepare($query);
        
        foreach($tags as $tag) {
            $stmt->execute(array(
                'picture_id' => $picture_id,
                'tag_id' => $this->getOrInsertTag($user_id, $tag)
            ));
			//print_r($stmt->errorInfo());
        }
    }
	
	function getOrInsertTag($user_id, $tag) {
		$tag_id = 0;
		
		$query = 'SELECT id FROM tags WHERE user_id = :user_id AND name = :tag';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute(array(
			'user_id' => $user_id,
			'tag' => $tag
		));
		
		
		if ($stmt->rowCount() == 0 ) {
			$query = 'INSERT INTO tags(user_id, name) VALUES(:user_id, :name)';
			$istmt = $this->pdo->prepare($query);
			$istmt->execute(array(
				'user_id' => $user_id,
				'name' => $tag
			));
			//print_r($istmt->errorInfo());
			
			$tag_id = $this->pdo->lastInsertId();
		} else {
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			$tag_id = $res['id'];
		}
		
		return $tag_id;
	}
	
	/**
	 * Users
	*/
	public function getUsers() {
		$query = "SELECT users.id, users.name, users.surname, users.`e-mail`, count(pictures.id) as num_photos FROM users INNER JOIN pictures ON pictures.user_id = users.id GROUP BY users.id ORDER BY surname ASC";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		//print_r($stmt->errorInfo());
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getTagsByPictureID($picture_id) {
		$query = 'SELECT tags.name FROM tags ' .
			'INNER JOIN picture_tags ON picture_tags.tag_id = tags.id ' .
			'WHERE picture_tags.picture_id = :picture_id';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute(array(
			'picture_id' => $picture_id
		));
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getUserByEmail($email) {
		$query = 'SELECT id, `e-mail`, password, salt, name, surname, created ' .
			'FROM users WHERE `e-mail` = :email LIMIT 1';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute(array(
			'email' => $email
		));
		//print_r($stmt->errorInfo());
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
    
    public function getDbObj() {
        return $this->pdo;
    }
    
}