<?php
require_once('../class/DBAL.php');
require_once('../class/ImageInfo.php');
$db = DBAL::getInstance();
$user_id = 1;	// This should be replaced with some sort of authentication service

if(isset($_FILES) && !empty($_FILES) && isset($_GET) && !empty($_GET)) {
	
	$thumbnails = array();
    $filename = $user_id . "_" . rand(0, 10000);
    $phy_path = dirname(__FILE__) . "\..\upload\\";
	$uri_path = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER["REQUEST_URI"]) . '/../upload/';
	$tmp_file = $_FILES["file"]["tmp_name"];
	
	$org_file = $phy_path . $filename . ".jpg";
	move_uploaded_file($tmp_file, $org_file);
	
	
	
	
    $info = ImageInfo::getImageInfo($org_file);
    $latitude = $info['lat'];
    $longitude = $info['lng'];
    $photo_shot = $info['photo_shot'];
    $description = $_GET['description'];
	$tags = explode(',', $_GET['tags']);

    if (!empty($latitude)) {
		// Create three pictures, 2 thumbnails and one main
		// Dimensions
		// Small: 160x120
		// Medium: 260x180
		// Large: 640x480

		
		array_push($thumbnails, array(
			'phy_path' => create_thumb($org_file, $phy_path . $filename . "_small.jpg", 160, 120),
			'uri_path' => $uri_path . $filename . "_small.jpg",
			'type' => 0
		));
		
		array_push($thumbnails, array(
			'phy_path' => create_thumb($org_file, $phy_path . $filename . "_medium.jpg", 260, 180),
			'uri_path' => $uri_path . $filename . "_medium.jpg",
			'type' => 1,
		));
		
		array_push($thumbnails, array(
			'phy_path' => create_thumb($org_file, $phy_path . $filename . "_large.jpg", 640, 480),
			'uri_path' => $uri_path . $filename . "_large.jpg",
			'type' => 2
		));
		$db->insertPicture($user_id, $phy_path . $filename . ".jpg", $uri_path . $filename . ".jpg", $latitude, $longitude, $photo_shot, $description, $tags, $thumbnails);
        echo "Added in DB";
    } else {
        echo "No exif-data found!";
    }
}

function create_thumb($path, $new_path, $new_w, $new_h) {
	// TO-DO: Need to verify path, need to use some faster library for resizing, this is slooow..
	$src_img = imagecreatefromjpeg($path);
	$dst_img=ImageCreateTrueColor($new_w,$new_h);
	
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,$old_x,$old_y); 
	imagejpeg($dst_img,$new_path);
	
	imagedestroy($dst_img); 
	imagedestroy($src_img);
	
	return $new_path;
}
