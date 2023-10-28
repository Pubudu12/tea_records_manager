<?php

class CropSaveImage {

    var $image;
    var $image_type;

    function load($filename) {

        $image_info = getimagesize($filename);
        
        $this->image_type = $image_info[2];

        if( $this->image_type == IMAGETYPE_JPEG ) {

            $this->image = imagecreatefromjpeg($filename);

        } else if( $this->image_type == IMAGETYPE_GIF ) {

            $this->image = imagecreatefromgif($filename);

        } else if( $this->image_type == IMAGETYPE_PNG ) {

            $this->image = imagecreatefrompng($filename);
        }

    } //load

    function save($filename, $compression, $permissions=null) {

        if( $this->image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename, $compression);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {

            imagegif($this->image, $filename);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {

            imagepng($this->image, $filename);
        }
        if( $permissions != null) {

            chmod($filename,$permissions);
        }
    }

    function output() {

        if( $this->image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {

            imagegif($this->image);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {

            imagepng($this->image);
        }
    }

    function getWidth() {

        return imagesx($this->image);
    }

    function getHeight() {

        return imagesy($this->image);
    }

    function resizeToHeight($height) {

        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }

    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width,$height);
    }

    function scale($scale) {
        $width = $this->getWidth() * $scale/100;
        $height = $this->getheight() * $scale/100;
        $this->resize($width,$height);
    }

    function rotate($angle){
        // rotate the rezized image
        $rotated_image = imagerotate($this->image, -$angle, 0);

        $this->image = $rotated_image;
        
        // find new width & height of rotated image
        $rotated_width = imagesx($rotated_image);
        $rotated_height = imagesy($rotated_image);
        // diff between rotated & original sizes
        $dx = $rotated_width - $this->getWidth();
        $dy = $rotated_height - $this->getHeight();

        // crop rotated image to fit into original rezized rectangle
        $cropped_rotated_image = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
        imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());

        // Now image after rotated
        $this->image = $cropped_rotated_image;
        
    } //rotate

    function crop($cropW, $cropH, $imgX1, $imgY1){

        // crop image into selected area
        $final_image = imagecreatetruecolor($cropW, $cropH);
        imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
        imagecopyresampled($final_image, $this->image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);

        $this->image = $final_image;

    }// crop

    function resize($width,$height) {
        $new_image = imagecreatetruecolor($width, $height);

        if($this->image_type == IMAGETYPE_PNG){
            imagecolortransparent($new_image, imagecolorallocatealpha($new_image, 0, 0, 0, 127));
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        
        if (!$i) {
            return "";
        }

        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

}



    $imgUrl = $_POST['imgUrl'];

    // original sizes
    $imgInitW = $_POST['imgInitW'];
    $imgInitH = $_POST['imgInitH'];

    // resized sizes
    $imgW = $_POST['imgW'];
    $imgH = $_POST['imgH'];

    // offsets
    $imgX1 = $_POST['imgX1'];
    $imgY1 = $_POST['imgY1'];

    // crop box
    $cropW = $_POST['cropW'];
    $cropH = $_POST['cropH'];

    // rotation angle
    $angle = $_POST['rotation'];

    $imgDirectory = $_POST['saveDirectory'];

    // Image Quality
    $quality = $_POST['img_quality'];

    // Type Check
    $what = getimagesize($imgUrl);
    switch(strtolower($what['mime'])) {
        case 'image/png':
            $type = '.png';
            break;
        case 'image/jpeg':
            $type = '.jpeg';
            break;
        case 'image/gif':
            $type = '.gif';
            break;
        default: die('image type not supported');
    }
    
    // New name
    $newName = "pThumb".rand().$type;

    // Create Directory If Not Exist
    if (!file_exists($imgDirectory)) {
        mkdir($imgDirectory, 0777, true);
    }
    $output_filename = $imgDirectory.$newName;


    // Operations
    $image = new CropSaveImage();
    $image->load($imgUrl);
    $image->resize($imgW, $imgH);
    $image->rotate($angle);
    $image->crop($cropW, $cropH, $imgX1, $imgY1);
    $image->save($output_filename, $quality);


    $result = 1;
    $message = 'success';

    $response = Array(
        'result' => $result,
        'status' => $message,
        'url' => $output_filename,
        'newName' => $newName,
    );

    print json_encode($response);


?>