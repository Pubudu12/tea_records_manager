    <?php

    class SimpleImage {

        var $image;
        var $image_type;

        function load($filename) {

            $image_info = getimagesize($filename);
            
            $this->image_type = $image_info[2];

            if( $this->image_type == IMAGETYPE_JPEG ) {

                $this->image = imagecreatefromjpeg($filename);

            } elseif( $this->image_type == IMAGETYPE_GIF ) {

                $this->image = imagecreatefromgif($filename);

            } elseif( $this->image_type == IMAGETYPE_PNG ) {

                $this->image = imagecreatefrompng($filename);
            }

        } //load

        function save($filename, $compression=75, $permissions=null) {

            if( $this->image_type == IMAGETYPE_JPEG ) {
                imagejpeg($this->image,$filename,$compression);
            } elseif( $this->image_type == IMAGETYPE_GIF ) {

                imagegif($this->image,$filename);
            } elseif( $this->image_type == IMAGETYPE_PNG ) {

                imagepng($this->image,$filename);
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


    // Example
    function storeUploadedImage($target_dir, $htmlEle, $new_img_width, $new_img_height = null, $namePrefix = null) {

        $message = '';
        $error = 0;

        $image = new SimpleImage();

        $valid_formats = array("jpg", "png", "jpeg","PNG","JPG","JPEG");
        $extension = $image->getExtension($htmlEle['name']);

        if(!in_array($extension, $valid_formats)) {

            $error = 1;
            $message = "Please upload the valid format";

            return array(
                'error' => $error,
                'message' => $message,
            ); //return name of saved file in case you want to store it in you database or show confirmation message to user
            exit;
        }



        if( ($new_img_height == null) || ($new_img_height == 0) ){
            list($width, $height) = getimagesize($htmlEle['tmp_name']);
            $new_img_height = ($height / $width) * $new_img_width;
        }


        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $newfilename = $namePrefix.rand().date("ymd").".".$extension;
        $target_file = $target_dir.$newfilename;


        $image->load($htmlEle['tmp_name']);
        $image->resize($new_img_width, $new_img_height);
        $image->save($target_file);

        return array(
            'error' => $error,
            'message' => $message,
            'filename' => $newfilename,
            'full_path' => $target_file
        ); //return name of saved file in case you want to store it in you database or show confirmation message to user
    
    }
    ?>