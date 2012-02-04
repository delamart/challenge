<html>
    <head>
        <title>Update Thumbnails</title>
    </head>    
<body>
<pre>
<?php

    error_reporting(E_ALL);
        
    $BASE_DIR = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
    
    require_once( $BASE_DIR . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'config.class.php' );    
    ConfigLib::parse( $BASE_DIR . DIRECTORY_SEPARATOR . 'config.ini');

    $url =  '/img/uploads/';
    $web = ConfigLib::g('directory/web');
    $dir = $web . $url;
    
    try {
        
    $db = DbLib::getInstance();
    
    $files = glob($dir . '*-avatar.*');
    foreach($files as $file)
    {
        $name = basename($file);
        $u = $url . $name;
        echo "<a href=\"$u\">$file</a> ";
 
        
        $img = new ImageLib($file);
        $file_thumb = dirname($file) . DIRECTORY_SEPARATOR . substr($name,0,-4) . '-thumb.' . $img->getType();
        echo " ...$file_thumb ";
        //if(file_exists($file_thumb)) { echo " ...already exists\n"; continue; }

        $img->resize(110, 110, true);
        $img->crop(110, 110);
        if($img->save($file_thumb)) 
        { 
            echo " ...done "; 
            $from = str_replace($web, '', $file);
            $to   = str_replace($web, '', $file_thumb);
            $update = "UPDATE user SET avatar = '$to' WHERE avatar = '$from'";
            if(($res = $db->query($update)))
            {
                if($res->rowCount())
                {
                    echo " ...updated ";
                }
                else
                {
                    echo " ...no updates ";
                }
            }
        }
        
        echo "\n";
    }
    
    } catch(Exception $e) { echo $e->getMessage(); }
    
?>        
</pre>
</body>    
</html>
