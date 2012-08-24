<?php

class ImageInfo {

    public static function getImageInfo($path) {
        $retArr = array();
        try {
            $exif = @exif_read_data ($path);
            //var_dump($exif);
            
            
            $retArr['lat'] = isset($exif['GPSLatitude']) ? ImageInfo::getGps($exif['GPSLatitude'], $exif['GPSLatitudeRef']) : 0;
            $retArr['lng'] = isset($exif['GPSLongitude']) ? ImageInfo::getGps($exif['GPSLongitude'], $exif['GPSLongitudeRef']) : 0;
            $retArr['photo_shot'] = isset($exif['DateTimeOriginal']) ? $exif['DateTimeOriginal'] : 0;
        } catch(Exception $e) {
        
        }
        
        return $retArr;
    }
    //Pass in GPS.GPSLatitude or GPS.GPSLongitude or something in that format
    public static function getGps($exifCoord, $hemi) {

        $degrees = count($exifCoord) > 0 ? ImageInfo::gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? ImageInfo::gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? ImageInfo::gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

    }

    public static function gps2Num($coordPart) {

        $parts = explode('/', $coordPart);

        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }

}