<?php

class RoutingLib {
    
    const HTTP_METHOD_HEAD = 'HEAD';
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_PUT = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';
    
    public static function getHttpMethod() {
        return isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : self::HTTP_METHOD_GET;
    }
    
    public static function isGet() { return self::getHttpMethod() === self::HTTP_METHOD_GET; }
    public static function isPost() { return self::getHttpMethod() === self::HTTP_METHOD_POST; }
    public static function isPut() { return self::getHttpMethod() === self::HTTP_METHOD_PUT; }

    public static function cleanPost($posts = null, $files = null) {
        $posts = $posts === null ? $_POST : $posts;
        $files = $files === null ? $_FILES : $files;
        if(count($files)) {
            $upload_dir = ConfigLib::g('directory/uploads');
            foreach($files as $id => $file) {
                if(!$file['name']) { continue; }
                do {
                    $upload_file = $upload_dir . DIRECTORY_SEPARATOR . rand(10000,99999) . '-' . $file['name'];
                } while(file_exists($upload_file));
                if(@move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $posts[$id] = $upload_file;
                } else { throw new Exception("Could not upload $upload_file"); }
            }
        }
        return $posts;
    }
    
    
    public static function setHeader($header) {
        header($header);
    }
    
    public $path;
    public $parts;
    
    public function __construct($PATH_INFO = null)
    {
        if($PATH_INFO === NULL && isset($_SERVER['PATH_INFO'])) { $PATH_INFO = $_SERVER['PATH_INFO']; }
        $this->path = trim($PATH_INFO,'/');
        $this->parts = explode('/', $this->path);
    }
    
    public function getController()
    {
        return (isset($this->parts[0]) && $this->parts[0]) ? $this->parts[0] : ConfigLib::g('default/controller');
    }

    public function getView()
    {
        return (isset($this->parts[1]) && $this->parts[1]) ? $this->parts[1] : ConfigLib::g('default/view');
    }
    
    public function getParameters()
    {
        if(count($this->parts) < 3) { return array(); }
        return array_slice($this->parts, 2);
    }
    
}