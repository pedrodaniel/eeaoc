<?php
class Perfiles extends Controller
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
		$permiso = $this->permiso->check($user['perfil_id'], 3);
		$variables['modulo_id'] = 3;
		$variables['padre_id'] = 1;
		if ($permiso)
		{
			if ($permiso['Listado'])
			{
				$busqueda = $this->input->post("busqueda");
				$this->load->model("perfil","perfil",true);
				$variables['listado'] = $this->perfil->listado($busqueda);
				$this->load->view("admin/perfiles/listado",$variables);
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function editar($perfil_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 3);
		if ($permiso)
		{
			if ($permiso['Modificacion'])
			{
				if ($perfil_id > 0)
				{
					$this->load->model("perfil","perfil",true);
				 	$variables['perfil'] = $this->perfil->damePerfil($perfil_id);
				 	$this->load->view("admin/perfiles/formulario",$variables);
				}
				else
				 	print "Error. M&eacute;todo no soportado.";
			}
			else
			{
				print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
			}
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
		$permiso = $this->permiso->check($user['perfil_id'], 3);
		if ($permiso)
		{
			if ($permiso['Alta'])
			{
				$variables['perfil'] = array("id"=>0,"perfil"=>"","descripcion"=>"","habilitado"=>1);	
				$this->load->view("admin/perfiles/formulario",$variables);
			}
			else
			{
				print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
			}
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
		$permiso = $this->permiso->check($user['perfil_id'], 3);
		if ($permiso['Modificacion'])
		{
			$datos['perfil'] = $this->input->post("nombre");
			$datos['descripcion'] = $this->input->post("descripcion");
			if ($this->input->post("activo")=="true")
				$datos['habilitado'] = 1;
			else
				$datos['habilitado'] = 0;
			$perfil_id = $this->input->post("perfil_id");
			
			$this->load->model("perfil","perfil",true);
			if ($this->perfil->save($datos, $perfil_id))
				echo "ok";
			else
				echo "error_db";
			
		}
		else
			echo "error_permiso";
	}
	
	public function valida_nombre()
	{
		$this->load->model("perfil","perfil",true);
		$perfil_id = $this->input->post("perfil_id");
		$nombre = $this->input->post("nombre");
		if ($nombre!="")
		{
			if ($this->perfil->existePerfil($nombre, $perfil_id))
			{
				echo "ko";
			}
			else
				echo "ok";
		}
		else
			echo "ko";
	}
	
	public function permisos($perfil_id)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 4);
		if ($perm['Modificacion'])
		{
			if ($perfil_id > 0)
			{
				$this->load->model("perfil","perfil",true);
				$variables['permisos'] = $this->perfil->damePermisos($perfil_id);
				$variables['modulos'] = $this->perfil->dameModulos($perfil_id);
				$variables['perfil_id'] = $perfil_id;
				$this->load->view("admin/perfiles/permisos",$variables);
			}
			else	
				print "Error. M&eacute;todo no soportado.";
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
	
	public function agregar_permiso()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 4);
		if ($perm['Alta'])
		{
			$perfil_id = $this->input->post("perfil_id");
			$modulo_id = $this->input->post("modulo_id");
			if ($perfil_id > 0 and $modulo_id > 0)
			{
				$datos['perfil_id'] = $perfil_id;
				$datos['modulo_id'] = $modulo_id;
				if ($this->permiso->insertar($datos))
					echo "ok";
				else
					echo "ko";
			}
			else
				echo "error_metodo";
		}
		else
			echo "error_permiso";
	}
	
	public function modificar_permiso()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 4);
		if ($perm['Modificacion'])
		{
			$permiso_id = $this->input->post("permiso_id");
			$valor = $this->input->post("valor");
			$accion = $this->input->post("accion");
			if ($valor)
				$datos[$accion] = $valor;
			else
				$datos[$accion] = 0;
				
			if ($this->permiso->update($permiso_id,$datos))
				echo "ok";
			else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
	
	public function eliminar_permiso()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 4);
		if ($perm['Baja'])
		{
			$permiso_id = $this->input->post("permiso_id");				
			if ($this->permiso->delete($permiso_id))
				echo "ok";
			else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
}
?>