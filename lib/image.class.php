<?php

class ImageLib {
    
    private $filename;
    private $img;
    private $type;
    private $width;
    private $height;

    public function __construct($filename)
    {
        if(!file_exists($filename)) { throw Exception("File $filename does not exist."); }
        $this->img = $this->load($filename);
        if(!$this->img) { throw Exception("Error laoding $filename."); }
    }
    
    public function load($filename)
    {
        list($width, $height) = getimagesize($filename);
        $this->width = $width;
        $this->height = $height;
        
        $this->type = $this->findType($filename);
        $img = null;
        switch($this->type)
        {
            case 'png':
                $img = @imagecreatefrompng($filename);
                break;
            case 'jpg':
                $img = @imagecreatefromjpeg($filename);
                break;
            default:
                throw new Exception("File type {$this->type} is not supported.");
        }
        
        $this->filename = $filename;
        return $img;
    }
    
    public function findType($filename)
    {
        $type = substr($filename, strrpos($filename, '.') + 1);
        $type = strcasecmp($type, 'jpeg') ? strtolower($type) : 'jpg';
        return $type;
    }
    
    public function crop($width, $height, $direction = 'center')
    {
        $diff_h = $this->height - $height;
        $diff_w = $this->width - $width;
        if($diff_h < 0 || $diff_w < 0) { return true; }
        
        $left = 0; $top = 0;
        
        switch($direction)
        {
            case 'center':
                $left = floor($diff_w / 2);
                $top = floor($diff_h / 2);
                break;
            default:
                throw new Exception("Cropping direciton $direction is not supported.");                
        }        
        
        $img_new = imagecreatetruecolor($width,$height);
        if(imagecopy($img_new, $this->img, 0, 0, $left, $top, $width, $height))
        {
            $this->width = $width;
            $this->height = $height;
            $this->img = $img_new;
            return true;
        }
        return false;
    }
    
    public function resize($max_width, $max_height, $dont_make_bigger = false, $keep_ratio = true)
    {
        // Ratio
        $ratio1 = $max_width / $this->width;
        $ratio2 = $max_height / $this->height;
        
        if($dont_make_bigger && ($ratio1 > 1 || $ratio2 > 1)) { return true; }
        
        if($keep_ratio)
        {
            if($ratio1 > $ratio2) { $ratio2= $ratio1; }
            else { $ratio1 = $ratio2; }
        }
        
        $new_width = ceil($this->width * $ratio1);
        $new_height = ceil($this->height * $ratio2);
        
        // Resample
        $img_new = imagecreatetruecolor($new_width, $new_height);
        if(imagecopyresampled($img_new, $this->img, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height))
        {
            $this->width = $new_width;
            $this->height = $new_height;
            $this->img = $img_new;
            return true;
        }
        
        return false;
    }
    
    public function save($filename = null)
    {
        if($filename === null) { $filename = $this->filename; }
        
        $ret = null;
        switch ($this->type)
        {
            case 'png':
                $ret = imagepng($this->img, $filename);
                break;
            case 'jpg':
                $ret = imagejpeg($this->img, $filename);
                break;
            default:
                throw new Exception("File type {$this->type} is not supported.");
        }
        
        if($ret)
        {
            $this->filename = $filename;
            return true;
        }
        
        return false;
    }

    public function getType() { return $this->type; }
    
}