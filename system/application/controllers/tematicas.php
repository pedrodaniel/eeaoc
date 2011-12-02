<?php
class Tematicas extends Controller
{
	function __construct()
	{
		parent::Controller();
	}
	
	public function index($tematica_id=0)
	{
		if ($tematica_id > 0)
		{
			$this->load->model("tematica","tematica",true);
			$info = $this->tematica->dameTematica($tematica_id);
			$imagenes = $this->tematica->dameImgTematica($tematica_id);
			$hijas = $this->tematica->dameHijas($tematica_id);
			if (!$hijas)
			{
				$rubros = $this->tematica->dameRubros($tematica_id);
			}
			else
				$rubros = false;
				
			$variables['info'] = $info;
			$variables['imagenes'] = $imagenes;
			$variables['hijas'] = $hijas;
			$variables['rubros'] = $rubros;
			$variables['pagina_id'] = 0;
			
			$this->load->library("varios");
			$this->load->view("tematica",$variables);
		}
		else
			show_error();
	}
}
?>