<?php
class Paginas extends Controller
{
	function __construct()
	{
		parent::Controller();
	}
	
	public function index($pagina_id=0,$hija_id=0)
	{
		$variables['pagina_id'] = $pagina_id;
		$variables['hija_id'] = $hija_id;
		$this->load->model("front/pagina","pagina",true);
		if ($hija_id == 0)
		{
			$info_pagina = $this->pagina->dameInfoPagina($pagina_id);
			$tipo = $info_pagina['tipo']+1;
			$variables['hijas'] = $this->pagina->damePaginasMenu($info_pagina['id'],$tipo);

			$imagenes =$this->pagina->dameImgPagina($pagina_id);

		}
		else
		{
			$info_pagina = $this->pagina->dameInfoPagina($hija_id);
			$tipo = $info_pagina['tipo'];
			$variables['hijas'] = $this->pagina->damePaginasMenu($pagina_id,$tipo);
			$imagenes = $this->pagina->dameImgPagina($hija_id);
		}
		$variables['info'] = $info_pagina;
		$variables['info']['imagenes'] = $imagenes;
		$this->load->library("varios");
		$this->load->view("pagina",$variables);
	}
}
?>