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
		$this->load->model("front/pagina","pagina",true);
		if ($hija_id == 0 or !is_numeric($hija_id))
		{
			$info_pagina = $this->pagina->dameInfoPagina($pagina_id);
			$tipo = $info_pagina['tipo']+1;
			$variables['hijas'] = $this->pagina->damePaginasMenu($info_pagina['id'],$tipo);
		}
		else
		{
			$info_pagina = $this->pagina->dameInfoPagina($hija_id);
			$tipo = $info_pagina['tipo'];
			$variables['hijas'] = $this->pagina->damePaginasMenu($pagina_id,$tipo);
		}
		$variables['info'] = $info_pagina;
		$this->load->library("varios");
		$this->load->view("pagina",$variables);
	}
}
?>