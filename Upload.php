<?php
class Upload {

    private $error = array();
    private $name;
    private $ext;
    private $orgWidth;
    private $orgHeight;
    private $width;
    private $prefix;
    private $suffix;
    private $uploadedFile;
    private $source;
    private $newImage;

    private $KB = 1024;
    private $MB = 1048576;
    private $GB = 1073741824;
    private $TB = 1099511627776;

    function __construct(array $fileToUpload){
        $this->name = pathinfo($fileToUpload['name'], PATHINFO_FILENAME);
        $this->ext = strtolower(pathinfo($fileToUpload['name'], PATHINFO_EXTENSION));
        $this->filesize = $fileToUpload['size'];
        $this->uploadedFile = $fileToUpload['tmp_name'];

        $this->orgWidth = getimagesize($this->uploadedFile)[0];
        $this->orgHeight = getimagesize($this->uploadedFile)[1];
        $this->setWidth($this->orgWidth);

        if(!is_uploaded_file($this->uploadedFile) OR !file_exists($this->uploadedFile) OR $this->filesize==0){
            $this->error[] = _("You have to upload something!");
        }
    }

    public function errors(){
        return $this->error;
    }

    public function AllowedTypes(array $types){
        if(!in_array(mime_content_type($this->uploadedFile), $types)){
            $this->error[] = _("This type of file is not allowed!");
        }
    }

    public function setMaxSize($size, $type){
        if($this->filesize > $size*$this->$type){
            $this->error[] = _("Your file hits the limit!");
        }
    }

    public function setPrefix($prefix){
        $this->prefix = $prefix;
    }

    public function setSuffix($suffix){
        $this->suffix = $suffix;
    }

    public function setWidth($width){
        $this->width = $width;
    }

    public function setPath($path){
        $this->path = $path;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function Render(){
        if(!empty($this->error)){
            return false;
        }

        $width = $this->width;
        $height = ($this->orgHeight/$this->orgWidth) * $width;


        $this->newImage = imagecreatetruecolor($width, $height);

        switch ($this->ext) {
            case 'png':
                imagealphablending($this->newImage, false);
                imagesavealpha($this->newImage, true);
                $this->source = imagecreatefrompng($this->uploadedFile);
                imagecopyresampled($this->newImage, $this->source,0,0,0,0,$width, $height, $this->orgWidth, $this->orgHeight);
                $filename = $this->path . $this->prefix . $this->name . $this->suffix . "." .$this->ext;
                imagepng($this->newImage,$filename, 9);
                break;
            case 'gif':
                $this->source = imagecreatefromgif($this->uploadedFile);
                imagecopyresampled($this->newImage, $this->source,0,0,0,0,$width, $height, $this->orgWidth, $this->orgHeight);
                $filename = $this->path . $this->prefix . $this->name . $this->suffix . "." .$this->ext;
                imagegif($this->newImage,$filename);
                break;
            case 'jpeg':
            case  'jpg':
                $this->source = imagecreatefromjpeg($this->uploadedFile);
                $exif = exif_read_data($this->uploadedFile);
                switch ($exif['Orientation']){
                    case 3:
                        $this->source = imagerotate($this->source, 180, 0);
                        break;
                    case 6:
                        $this->source = imagerotate($this->source, - 90, 0);
                        break;
                    case 8:
                        $this->source = imagerotate($this->source, 90, 0);
                        break;
                }
                imagecopyresampled($this->newImage, $this->source,0,0,0,0,$width, $height, $this->orgWidth, $this->orgHeight);
                $filename = $this->path . $this->prefix . $this->name . $this->suffix . "." .$this->ext;
                imagejpeg($this->newImage,$filename,100);
                break;
            }
            imagedestroy($this->newImage);
            return $this->prefix . $this->name . $this->suffix . "." .$this->ext;
        }

        public function Clean(){
            imagedestroy($this->uploadedFile);
            imagedestroy($this->source);
        }
    }
