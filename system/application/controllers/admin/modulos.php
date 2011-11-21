<?php
class Modulos extends Controller
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
		$permiso = $this->permiso->check($user['perfil_id'], 5);
		$variables['modulo_id'] = 5;
		$variables['padre_id'] = 1;
		if ($permiso)
		{
			if ($permiso['Listado'])
			{
				$variables['search'] = $busqueda;
				$this->load->model("modulo","modulo",true);
				$variables['listado'] = $this->modulo->listado($busqueda);
				$this->load->view("admin/modulos/listado",$variables);
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function editar($modulo_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 5);
		if ($permiso['Modificacion'])
		{
			if ($modulo_id > 0)
			{
				$this->load->model("modulo","modulo",true);
				$variables['permiso'] = $permiso['Modificacion'];
				$variables['modulo'] = $this->modulo->dameModulo($modulo_id);
				$variables['padres'] = $this->modulo->damePadres($modulo_id);
				$this->load->view("admin/modulos/formulario",$variables);
			}
			else
				 print "Error. M&eacute;todo no soportado.";
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
	
	public function nuevo()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 5);
		if ($permiso['Alta'])
		{
			$variables['modulo'] = array("id"=>0,"nombre"=>"","accion"=>"","padre_id"=>0,"menu"=>0,"orden"=>"");
			$this->load->model("modulo","modulo",true);
			$variables['padres'] = $this->modulo->damePadres(0);
			$variables['permiso'] = $permiso['Alta'];
			$this->load->view("admin/modulos/formulario",$variables);
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
	
	public function guardar()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 5);
		$modulo_id = $this->input->post("modulo_id");
		if ($permiso['Modificacion'])
		{
			$datos['nombre'] = $this->input->post("nombre");
			$datos['accion'] = $this->input->post("accion");
			$datos['orden'] = $this->input->post("orden");
			$datos['hijos'] = 0;
			$datos['padre_id'] = $this->input->post("padre");
	
			if ($this->input->post("menu")=="true")
				$datos['menu'] = 1;
			else
				$datos['menu'] = 0;
						
			$this->load->model("modulo","modulo",true);
			if ($this->modulo->save($datos, $modulo_id))
				echo "ok";
			else
				echo "error_db";
			
		}
		else
			echo "error_permiso";
	}
	
	public function valida_nombre()
	{
		$this->load->model("modulo","modulo",true);
		$modulo_id = $this->input->post("modulo_id");
		$nombre = $this->input->post("nombre");
		if ($nombre!="")
		{
			if ($this->modulo->existeModulo($nombre, $modulo_id))
			{
				echo "ko";
			}
			else
				echo "ok";
		}
		else
			echo "ko";
	}
}
?>