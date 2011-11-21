<?php
class Usuarios extends Controller
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
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		$variables['modulo_id'] = 2;
		$variables['padre_id'] = 1;
		if ($permiso)
		{
			if ($permiso['Listado'])
			{
				//$busqueda = $this->input->post("search");
				$variables['search'] = $busqueda;
				$this->load->model("usuario","usuario",true);
				$variables['listado'] = $this->usuario->listado($user['perfil_id'],$busqueda);
				$this->load->view("admin/usuarios/usuario",$variables);
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function editar($usuario_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		if ($permiso['Modificacion'] or $user['id'] == $usuario_id)
		{
			if ($usuario_id > 0)
			{
				$this->load->model("usuario","usuario",true);
				$variables['permiso'] = $permiso['Modificacion'];
				$variables['usuario'] = $this->usuario->dameUsuario($usuario_id);
				$variables['perfiles'] = $this->usuario->damePerfile($user['perfil_id']);
				$this->load->view("admin/usuarios/editar",$variables);
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
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		if ($permiso)
		{
			if ($permiso['Alta'])
			{
				$variables['usuario'] = array("id"=>0,"apellido"=>"","nombre"=>"","email"=>"","perfil_id"=>"","habilitado"=>1);
				$this->load->model("usuario","usuario",true);
				$variables['perfiles'] = $this->usuario->damePerfile($user['perfil_id']);
				$variables['permiso'] = $permiso['Alta'];
				$this->load->view("admin/usuarios/editar",$variables);
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
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		$usuario_id = $this->input->post("usuario_id");
		if ($permiso['Modificacion'] or $user['id']==$usuario_id)
		{
			$datos['apellido'] = $this->input->post("apellido");
			$datos['nombre'] = $this->input->post("nombre");
			$datos['email'] = $this->input->post("email");
			$datos['perfil_id'] = $this->input->post("perfil");
			if ($this->input->post("pass"))
				$datos['password'] = md5($this->input->post("pass"));
			if ($this->input->post("activo")=="true")
				$datos['habilitado'] = 1;
			else
				$datos['habilitado'] = 0;
						
			$this->load->model("usuario","usuario",true);
			if ($this->usuario->save($datos, $usuario_id))
				echo "ok";
			else
				echo "error_db";
			
		}
		else
			echo "error_permiso";
	}
	
	public function valida_email()
	{
		$this->load->model("usuario","usuario",true);
		$usuario_id = $this->input->post("usuario_id");
		$email = $this->input->post("email");
		if ($email!="")
		{
			if ($this->usuario->existeEmail($email, $usuario_id))
			{
				echo "ko";
			}
			else
				echo "ok";
		}
		else
			echo "ko";
	}
	
	public function modificar_estado()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		if ($permiso['Modificacion'])
		{
			$usuario_id = $this->input->post("usuario_id");
			$valor = $this->input->post("valor");
			if ($usuario_id > 0)
			{
				$this->load->model("usuario","usuario",true);
				$datos['habilitado'] = $valor;
				if ($this->usuario->save($datos,$usuario_id))
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
}
?>