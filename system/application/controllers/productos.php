<?php
class Productos extends Controller
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
			$this->load->model("producto","producto",true);
			$info_pagina = $this->pagina->dameInfoPagina($pagina_id);
			$imagenes = $this->pagina->dameImgPagina($pagina_id);
			$productos = $this->producto->dameProductos();
			
			$variables['info'] = $info_pagina;
			$variables['info']['imagenes'] = $imagenes;
			$variables['productos'] = $productos;
			$variables['pagina_id'] = $pagina_id;
			$this->load->library("varios");
			$this->load->view("productos_a",$variables);
		}
		else
			show_error();
	}
}
?>