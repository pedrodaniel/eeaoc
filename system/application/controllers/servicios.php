<?php
class Servicios extends Controller
{
	function __construct()
	{
		parent::Controller(); 
	}
	
	public function index($pagina_id=0)
	{
		if ($pagina_id > 0)
		{
			$this->load->model("front/pagina","pagina",true);
			$this->load->model("servicio","servicio",true);
			$info_pagina = $this->pagina->dameInfoPagina($pagina_id);
			$imagenes = $this->pagina->dameImgPagina($pagina_id);
			$servicios = $this->servicio->dameServicios();
			
			$variables['info'] = $info_pagina;
			$variables['info']['imagenes'] = $imagenes;
			$variables['servicios'] = $servicios;
			$variables['pagina_id'] = $pagina_id;
			$this->load->library("varios");
			$this->load->view("servicios_a",$variables);
		}
		else
			show_error();
	}
}
?>