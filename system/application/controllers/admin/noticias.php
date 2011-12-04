<?php
class Noticias extends Controller
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
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		$variables['modulo_id'] = 18;
		$variables['padre_id'] = 18;
		if ($permiso['Listado'])
		{
			$variables['search'] = $busqueda;
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_ok");
			$this->load->model("noticia","noticia",true);
			$variables['listado'] = $this->noticia->listado($busqueda);
			$this->load->view("admin/noticias/listado",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function formulario($noticia_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 18;
		$variables['padre_id'] = 18;
		$this->load->model("permiso","permiso",true);
		$permisos = $this->permiso->check($user['perfil_id'], 18);
		if ($noticia_id > 0)
			$permiso = ($permisos['Modificacion'])?1:0;
		else
			$permiso = ($permisos['Alta'])?1:0;
			
		if ($permiso)
		{
			$this->load->model("noticia","noticia",true);
			$this->load->model("tematica","tematica",true);
			$this->load->model("servicio","servicio",true);
			$variables['tematicas'] = $this->tematica->dameTematicas();
			$variables['servicios'] = $this->servicio->dameServicios();
			$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
			if ($noticia_id > 0)
			{
				$variables['noticia'] = $this->noticia->dameNoticia($noticia_id);
				$variables['noticia']['imagenes'] = $this->noticia->dameImgNoticia($noticia_id);
				if (!$variables['noticia'])
				{
					redirect(site_url("admin/noticias"), "refresh");
					exit();
				}
				$variables['noticia']['id'] = $noticia_id;
				$variables['accion'] = "modificar"; 
			}
			else
			{
				$variables['accion'] = "guardar"; 
				if ($this->session->userdata("form_tematica"))
				{
					$variables['noticia'] = $this->session->userdata("form_noticia");
					$variables['noticia']['id'] = 0;
					$this->session->unset_userdata("form_noticia");
				}
				else
					$variables['noticia'] = array("id"=>0);
			}
			$this->load->view("admin/noticias/formulario",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function guardar()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 18;
		$variables['padre_id'] = 18;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Alta'])
		{
			$titulo = $this->input->post("titulo");
			$tipo = $this->input->post("tipo");
			$tematica_id = $this->input->post("tematica_id");
			$servicio_id = $this->input->post("servicio_id");
			$texto = $this->input->post("texto");
			$destacada = $this->input->post("destacada");
			$mensaje = "";
			if ($titulo!="" and $texto!="")
			{
				$datos['titulo'] = $titulo;
				$datos['tipo'] = $tipo;
				$datos['texto'] = $texto;
				$datos['tematica_id'] = $tematica_id;
				$datos['servicio_id'] = $servicio_id;
				$datos['destacada'] = $destacada;
				$datos['usuario_id'] = $user['id'];
				$datos['fecha'] = date("Y-m-d H:i:s");
				$this->session->set_userdata("form_noticia",$datos);
				
				$this->load->model("noticia","noticia",true);
				if ($this->noticia->insert($datos))
				{
					$this->session->unset_userdata("form_noticia");
					$mensaje = "La Noticia fue cargada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/noticias";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/noticias/formulario";	
				}	
			}
			else
			{
				$mensaje = "T&iacute;tulo y Texto son obligatorios.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/noticias/formulario";
			}
			$this->session->set_userdata($mensaje_nombre,$mensaje);
			redirect(site_url($url), "refresh");
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function upload()
	{
		$error = "";
		$ok = "";
		$noticia_id = $this->input->post("noticia_id");
		if ($_FILES['imagen']['name']!="")
		{
			$this->load->library("archivos");
			$this->load->library("imageresize");
			$this->archivos->imageresize = $this->imageresize;
			$this->archivos->file = $_FILES['imagen']; 
			$this->archivos->path = 'noticia/'.$noticia_id."/";
			$this->archivos->tipos = "jpg,png,gif,jpeg";
			
			$res = $this->archivos->subir();
			
			if ($res['error']=="")
			{
				$datos['img'] = $res['img'];
				$datos['url'] = $this->input->post("link");
				$datos['target'] = $this->input->post("target");
				$datos['destacada'] = $this->input->post("destacada");
				$datos['novedad_id'] = $noticia_id;
						
				$this->load->model("noticia","noticia",true);
				if (!$this->noticia->insertar_imagen($datos))
					$error = "Error al intentar adjuntar im&aacute;gen. Aseg&uacute;rese estar conectado.";
			}
			else
				$error = $res['error'];
		}
		else
		{
			$error = "Debe seleccionar una im&aacute;gen.";
		}
		
		if ($error == "")
		{
			redirect(site_url("admin/noticias/formulario/".$noticia_id), "refresh");
		}
		else
		{
			$this->session->set_userdata("mensaje_error",$error);
			redirect(site_url("admin/tematicas/formulario/".$tematica_id), "refresh");
		}
	}
	
	public function modificar()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 18;
		$variables['padre_id'] = 18;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Modificacion'])
		{
			$noticia_id = $this->input->post("noticia_id");
			$titulo = $this->input->post("titulo");
			$tipo = $this->input->post("tipo");
			$servicio_id = $this->input->post("servicio_id");
			$tematica_id = $this->input->post("tematica_id");
			$texto = $this->input->post("texto");
			$destacada = $this->input->post("destacada");
			$mensaje = "";
			if ($titulo!="" and $texto!="")
			{
				$datos['titulo'] = $titulo;
				$datos['tipo'] = $tipo;
				$datos['tematica_id'] = $tematica_id;
				$datos['servicio_id'] = $servicio_id;
				$datos['texto'] = $texto;
				$datos['destacada'] = $destacada;
								
				$this->load->model("noticia","noticia",true);
				if ($this->noticia->update($datos,$noticia_id))
				{
					$mensaje = "La Noticia fue modificada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/noticias";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/noticias/formulario/".$noticia_id;	
				}
			}
			else
			{
				$mensaje = "T&iacute;tulo y Texto son obligatorios.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/noticias/formulario/".$noticia_id;
			}
			$this->session->set_userdata($mensaje_nombre,$mensaje);
			redirect(site_url($url), "refresh");
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function borrar()
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Baja'])
		{
			$noticia_id = $this->input->post("noticia_id");
			$this->load->model("noticia","noticia",true);
			if ($this->noticia->eliminarNoticia($noticia_id))
			{
				echo "ok";
			}
			else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
	
	public function borrar_imagen()
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Baja'])
		{
			$noticia_id = $this->input->post("noticia_id");
			$imagen_id = $this->input->post("imagen_id");
			$img_borrar = $this->input->post("img");
			$this->load->model("noticia","noticia",true);
			if ($this->noticia->quitarImagen($imagen_id, $img_borrar, $noticia_id))
			{
				echo "ok";
			}
			else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
	
	public function editar_imagen($imagen_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Modificacion'])
		{
			if ($imagen_id > 0)
			{
				$this->load->model("noticia","noticia",true);
				$variables['permiso'] = $permiso['Modificacion'];
				$variables['imagen'] = $this->noticia->dameImagen($imagen_id);
				if ($variables['imagen'])
					$variables['noticia'] = $this->noticia->dameNoticia($variables['imagen']['novedad_id']);
				else
					$variables['noticia'] = false;
				$this->load->view("admin/noticias/editar_imagen",$variables);
			}
			else
				 print "Error. M&eacute;todo no soportado.";
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
	
	public function guardar_cambios_imagen()
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Modificacion'])
		{
			$imagen_id = $this->input->post("imagen_id");
			$datos['url'] = $this->input->post("url");
			$datos['target'] = $this->input->post("target");
			$datos['destacada'] = $this->input->post("destacada");
			$this->load->model("noticia","noticia",true);
			if ($this->noticia->updateImagen($imagen_id,$datos))
				echo "ok";
			else
				echo "ko";
		}
		else
		{
			echo "error_permiso";
		}
	}
	
	public function crop($imagen_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Modificacion'])
		{
			if ($imagen_id > 0)
			{
				$this->load->model("noticia","noticia",true);
				$variables['permiso'] = $permiso['Modificacion'];
				$variables['imagen'] = $this->noticia->dameImagen($imagen_id);
				$img = PATH_BASE . "noticia/".$variables['imagen']['novedad_id']."/".$variables['imagen']['img'];
				$size = getimagesize($img);
				$variables['alto'] = $size[1];
				$variables['ancho'] = $size[0];
				
				$this->load->view("admin/noticias/crop_imagen",$variables);
			}
			else
				 print "Error. M&eacute;todo no soportado.";
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
	
	public function destacar()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 18);
		if ($permiso['Modificacion'])
		{
			$noticia_id = $this->input->post("noticia_id");
			$valor = $this->input->post("valor");
			if ($noticia_id > 0)
			{
				$this->load->model("noticia","noticia",true);
				$datos['destacada'] = $valor;
				if ($this->noticia->update($datos,$noticia_id))
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