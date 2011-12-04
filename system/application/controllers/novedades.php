<?php
class Novedades extends Controller
{
	function __construct()
	{
		parent::Controller();
	}
	
	public function listado($tipo=0)
	{
		if ($tipo > 0)
		{
			$this->load->model("noticia","noticia",true);
			$noticia_id = $this->noticia->dameUltimaNota($tipo);
			$this->ver_nota($noticia_id);
		}
	}
	
	public function ver_nota($noticia_id=0)
	{
		if ($noticia_id > 0)
		{
			$this->load->model("noticia","noticia",true);
			$variables['noticia'] = $this->noticia->dameNoticia($noticia_id);
			$variables['imagenes'] = $this->noticia->dameImgNoticia($noticia_id);
			$variables['tipo_1'] = $this->noticia->dameNotasTipo(1);
			$variables['tipo_2'] = $this->noticia->dameNotasTipo(2);
			$variables['tipo_3'] = $this->noticia->dameNotasTipo(3);
		
			$this->load->library("varios");
			$this->load->view("noticias",$variables);
		}
		else
			show_error();
	}
}
?>