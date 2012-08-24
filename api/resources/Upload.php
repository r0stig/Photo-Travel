<?php
require_once('../class/DBAL.php');

use Tonic\Resource,
    Tonic\Response,
    Tonic\ConditionException;
    

/**
 * @uri /upload
 */
class UploadImage extends Resource {

    /**
     * @method POST
     */
    function uploadAndSaveImage() {
        return $this->request->data;
    }


}
