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
	}
}
?>