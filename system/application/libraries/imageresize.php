<?
class ImageResize {
    var $file_s = "";
    var $gd_s;
    var $gd_d;
    var $width_s;
    var $height_s;
    var $width_d;
    var $height_d;
    var $aCreateFunctions = array(
        IMAGETYPE_GIF=>'imagecreatefromgif',
        //IMAGETYPE_JPG=>'imagecreatefromjpg',
        IMAGETYPE_JPEG=>'imagecreatefromjpeg',
        IMAGETYPE_PNG=>'imagecreatefrompng',
    );
    
    /*function ImageResize($source) 
    {
        $this->file_s = $source;
        list($this->width_s, $this->height_s, $type, $attr) = getimagesize($source, $info2);
        $createFunc = $this->aCreateFunctions[$type];
        if($createFunc) {
            $this->gd_s = $createFunc($source);
        }
    }*/
	function setImage($source) 
    {
        $this->file_s = $source;
        list($this->width_s, $this->height_s, $type, $attr) = getimagesize($source, $info2);
        $createFunc = $this->aCreateFunctions[$type];
        if($createFunc) {
            $this->gd_s = $createFunc($source);
        }
    }
    function resizeWidth($width_d) 
    {
        $height_d = floor(($width_d*$this->height_s) /$this->width_s);
        $this->resizeWidthHeight($width_d, $height_d);
    }
    function resizeHeight($height_d) 
    {
        $width_d = floor(($height_d*$this->width_s) /$this->height_s);
        $this->resizeWidthHeight($width_d, $height_d);
    }
    function resizeArea($perc) 
    {
        $factor = sqrt($perc/100);
        $this->resizeWidthHeight($this->width_s*$factor, $this->height_s*$factor);
    }
    function resizeWidthHeight($width_d, $height_d) 
    {
		//cambiar imagecreatetruecolor(24 bits) por imagecreate(16 bits) para no ocupar tanta memoria en el servidor
        $this->gd_d = @imagecreatetruecolor($width_d, $height_d);
        @imagealphablending($this->gd_d, false);
        @imagesavealpha($this->gd_d, true);
        @imagecopyresampled($this->gd_d, $this->gd_s, 0, 0, 0, 0, $width_d, $height_d, $this->width_s, $this->height_s);
    }
    function save($file_d) 
    {
        imagejpeg($this->gd_d, $file_d);
        imagedestroy($this->gd_d);
    }
}

function crop_image($nombreOriginal , $nombreThumb, $path, $src, $src_w, $src_h, $x, $y, $dest, $dest_w, $dest_h) { 
  	$original = imagecreatefromjpeg($src) or die ("error");
   $ancho = imagesx($original); 
   $alto = imagesy($original); 
   $anchomini = $dest_w; 
   $altomini_tmp = $dest_h; 
   if(($ancho/$anchomini) > ($alto/$altomini_tmp)){ 
      echo('landscape: '); 
      $tmp_height = $altomini_tmp; 
      $tmp_width = $ancho * $altomini_tmp / $alto; 
      $tipo = 'L'; 
   }else{//vertical 
      echo('portrait: '); 
      $tmp_height = $alto * $anchomini / $ancho; 
      $tmp_width = $anchomini; 
      $tipo = 'P'; 
   } 
    
   if($tipo=='L'){ 
      $thumb = imagecreatetruecolor($tmp_width,$tmp_height); 
      imagecopyresampled($thumb,$original,0,0,0,0,$tmp_width,$tmp_height,$ancho,$alto); 
   }elseif($tipo=='P'){ 
      $thumb = imagecreatetruecolor($tmp_width,$tmp_height); 
      imagecopyresampled($thumb,$original,0,0,0,0,$tmp_width,$tmp_height,$ancho,$alto); 
   } 
    
   $nombreTemp = "temp_".$nombreThumb; 
    
   $img = $thumb; 
   $new_img = imagecreatetruecolor($dest_w, $dest_h); 
    
   imagecopyresampled($new_img, $img, 0, 0, $x, $y, $dest_w, $dest_h, $src_w, $src_h); 
   imagejpeg($new_img,$dest,85); 
   imagedestroy($img); 
   imagedestroy($original); 
}
?>
