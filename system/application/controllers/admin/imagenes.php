<?php
class Imagenes extends Controller
{
	function __construct()
	{
		parent::Controller();
		$user=$this->session->userdata('logged_in');
		if (!$user)
		{
			redirect(site_url("admin"), "refresh");
		}
	}
	
	public function recortar()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;

		$id = $this->input->post("id");
		$imagen = $this->input->post("imagen");
		$folder = $this->input->post("folder");
		$x1 = $this->input->post("x1");
		$y1 = $this->input->post("y1");
		$x2 = $this->input->post("x2");
		$y2 = $this->input->post("y2");
		$w = $this->input->post("w");
		$h = $this->input->post("h");
		
		$origen = PATH_BASE . $folder . "/" . $id . "/" . $imagen;
		
		$extension = strtolower(end(explode(".",$imagen)));
		
		if ($extension=="jpg") $img = imagecreatefromjpeg($origen);
		if ($extension=="jpeg") $img = imagecreatefromjpeg($origen);
		if ($extension=="gif") $img = imagecreatefromgif($origen);
		if ($extension=="png") $img = imagecreatefrompng($origen);
				
		$res = imagecreatetruecolor($w, $h);
		imagecopy($res, $img, 0, 0, $x1, $y1, $w, $h);
				
		$crop_temp = PATH_BASE . "temp_".$imagen;
		$nuevoDestino = PATH_BASE . $folder . "/" . $id . "/" . "crop_".$imagen;
			
		if ($extension=="jpg") $proc_img = imagejpeg(@$res,$crop_temp,80);
		if ($extension=="jpeg") $proc_img = imagejpeg(@$res,$crop_temp,80);
		if ($extension=="gif") $proc_img = imagegif(@$res,$crop_temp,80);
		if ($extension=="png") $proc_img = imagepng(@$res,$crop_temp,80);
		
		if ($proc_img)
		{
			if (file_exists($nuevoDestino))
				unlink($nuevoDestino);
			
			$this->load->library("imageresize");
			$this->imageresize->setImage($crop_temp);
			$this->imageresize->resizeWidth(CROP_W);
			$this->imageresize->save($nuevoDestino);
			unlink($crop_temp);
			imagedestroy($res);
			echo "ok";
		}
		else
		{
			unlink($crop_temp);
			imagedestroy($res);
			echo "ko";
		}
	}
}
?>