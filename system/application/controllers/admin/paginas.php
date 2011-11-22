<?php
class Paginas extends Controller
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
	public function index()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		if ($permiso)
		{
			if ($permiso['Listado'])
			{
				$variables['modulo_id'] = 10;
				$variables['padre_id'] = 0;
				$busqueda = $this->input->post("busqueda");
				$this->load->model("pagina","pagina",true);
				$variables['listado'] = $this->pagina->listado($busqueda);
				$this->load->view("admin/paginas/paginas",$variables);
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
}

?>