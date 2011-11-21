<?php
class Tematicas extends Controller
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
	
	public function index($busqueda="")
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		$variables['modulo_id'] = 6;
		$variables['padre_id'] = 6;
		if ($permiso['Listado'])
		{
			$variables['search'] = $busqueda;
			$this->load->model("tematica","tematica",true);
			$variables['listado'] = $this->tematica->listado($user['perfil_id'],$busqueda);
			$this->load->view("admin/tematicas/listado",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function formulario($tematica_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 6;
		$variables['padre_id'] = 6;
		$this->load->model("permiso","permiso",true);
		$permisos = $this->permiso->check($user['perfil_id'], 6);
		if ($tematica_id > 0)
			$permiso = ($permisos['Modificacion'])?1:0;
		else
			$permiso = ($permisos['Alta'])?1:0;
			
		if ($permiso)
		{
			$this->load->model("tematica","tematica",true);
			$variables['padres'] = $this->tematica->dameTematicas();
			if ($tematica_id > 0)
			{
				$variables['tematica'] = $this->tematica->dameTematica($tematica_id);
			}
			else
			{
				$variables['tematica'] = array("id"=>0);
			}
			$this->load->view("admin/tematicas/formulario",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
}
?>