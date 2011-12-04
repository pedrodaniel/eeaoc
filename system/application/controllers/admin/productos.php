<?php
class Productos extends Controller
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
		$permiso = $this->permiso->check($user['perfil_id'], 11);
		$variables['modulo_id'] = 11;
		$variables['padre_id'] = 11;
		if ($permiso['Listado'])
		{
			$variables['search'] = $busqueda;
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_ok");
			$this->load->model("producto","producto",true);
			$variables['listado'] = $this->producto->listado($busqueda);
			$this->load->view("admin/productos/listado",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function formulario($producto_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 11;
		$variables['padre_id'] = 11;
		$this->load->model("permiso","permiso",true);
		$permisos = $this->permiso->check($user['perfil_id'], 11);
		if ($producto_id > 0)
			$permiso = ($permisos['Modificacion'])?1:0;
		else
			$permiso = ($permisos['Alta'])?1:0;
			
		if ($permiso)
		{
			$this->load->model("producto","producto",true);
			$this->load->model("tematica","tematica",true);
			$this->load->model("servicio","servicio",true);
			$variables['tematicas'] = $this->tematica->dameTematicas();
			$variables['servicios'] = $this->servicio->dameServicios();
			$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
			if ($producto_id > 0)
			{
				$variables['producto'] = $this->producto->dameProducto($producto_id);
				$variables['producto']['imagenes'] = $this->producto->dameImgProducto($producto_id);
				if (!$variables['producto'])
				{
					redirect(site_url("admin/productos"), "refresh");
					exit();
				}
				$variables['producto']['id'] = $producto_id;
				$variables['accion'] = "modificar"; 
			}
			else
			{
				$variables['accion'] = "guardar"; 
				if ($this->session->userdata("form_producto"))
				{
					$variables['producto'] = $this->session->userdata("form_producto");
					$variables['producto']['id'] = 0;
					$this->session->unset_userdata("form_producto");
				}
				else
					$variables['producto'] = array("id"=>0);
			}
			$this->load->view("admin/productos/formulario",$variables);
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
		$variables['modulo_id'] = 11;
		$variables['padre_id'] = 11;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 11);
		if ($permiso['Alta'])
		{
			$nombre = $this->input->post("nombre");
			$tematica_id = $this->input->post("tematica_id");
			$servicio_id = $this->input->post("servicio_id");
			$descripcion = $this->input->post("descripcion");
			$mensaje = "";
			if ($nombre!="")
			{
				$datos['nombre'] = $nombre;
				$datos['descripcion'] = $descripcion;
				$datos['tematica_id'] = $tematica_id;
				$datos['servicio_id'] = $servicio_id;
				$datos['usuario_id'] = $user['id'];
				$datos['fecha_carga'] = date("Y-m-d H:i:s");
				$this->session->set_userdata("form_producto",$datos);
				
				$this->load->model("producto","producto",true);
				if ($last_id=$this->producto->insert($datos))
				{
					$this->session->unset_userdata("form_producto");
					$mensaje = "El producto fue cargada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/productos/formulario/".$last_id;		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/productos/formulario";	
				}	
			}
			else
			{
				$mensaje = "Error de conexi&oacute;n a la base de datos.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/productos/formulario";
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
		$produto_id = $this->input->post("producto_id");
		if ($_FILES['imagen']['name']!="")
		{
			$this->load->library("archivos");
			$this->load->library("imageresize");
			$this->archivos->imageresize = $this->imageresize;
			$this->archivos->file = $_FILES['imagen']; 
			$this->archivos->path = 'producto/'.$produto_id."/";
			$this->archivos->tipos = "jpg,png,gif,jpeg";
			
			$res = $this->archivos->subir();
			
			if ($res['error']=="")
			{
				$datos['imagen'] = $res['img'];
				$datos['url'] = $this->input->post("link");
				$datos['target'] = $this->input->post("target");
				$datos['producto_id'] = $produto_id;
						
				$this->load->model("producto","producto",true);
				if (!$this->producto->insertar_imagen($datos))
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
			redirect(site_url("admin/productos/formulario/".$produto_id), "refresh");
		}
		else
		{
			$this->session->set_userdata("mensaje_error",$error);
			redirect(site_url("admin/productos/formulario/".$produto_id), "refresh");
		}
	}
	
	public function modificar()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 11;
		$variables['padre_id'] = 11;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 11);
		if ($permiso['Alta'])
		{
			$producto_id = $this->input->post("producto_id");
			$nombre = $this->input->post("nombre");
			$tematica_id = $this->input->post("tematica_id");
			$servicio_id = $this->input->post("servicio_id");
			$descripcion = $this->input->post("descripcion");
			$mensaje = "";
			if ($nombre!="")
			{
				$datos['nombre'] = $nombre;
				$datos['descripcion'] = $descripcion;
				$datos['tematica_id'] = $tematica_id;
				$datos['servicio_id'] = $servicio_id;
								
				$this->load->model("producto","producto",true);
				if ($this->producto->update($datos,$producto_id))
				{
					$mensaje = "El producto fue modificado con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/productos";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/productos/formulario/".$producto_id;	
				}
			}
			else
			{
				$mensaje = "Error de conexi&oacute;n a la base de datos.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/productos/formulario/".$producto_id;
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
		$permiso = $this->permiso->check($user['perfil_id'], 11);
		if ($permiso['Baja'])
		{
			$producto_id = $this->input->post("producto_id");
			$this->load->model("producto","producto",true);
			if ($this->producto->eliminarProducto($producto_id))
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
		$permiso = $this->permiso->check($user['perfil_id'], 11);
		if ($permiso['Baja'])
		{
			$producto_id = $this->input->post("producto_id");
			$imagen_id = $this->input->post("imagen_id");
			$img_borrar = $this->input->post("imagen");
			$this->load->model("producto","producto",true);
			if ($this->producto->quitarImagen($imagen_id, $img_borrar, $producto_id))
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
		$permiso = $this->permiso->check($user['perfil_id'], 11);
		if ($permiso['Modificacion'])
		{
			if ($imagen_id > 0)
			{
				$this->load->model("producto","producto",true);
				$variables['permiso'] = $permiso['Baja'];
				$variables['imagen'] = $this->producto->dameImagen($imagen_id);
				if ($variables['imagen'])
					$variables['producto'] = $this->producto->dameProducto($variables['imagen']['producto_id']);
				else
					$variables['producto'] = false;
				$this->load->view("admin/productos/editar_imagen",$variables);
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
		$permiso = $this->permiso->check($user['perfil_id'], 11);
		if ($permiso['Modificacion'])
		{
			$imagen_id = $this->input->post("imagen_id");
			$datos['url'] = $this->input->post("url");
			$datos['target'] = $this->input->post("target");
			$this->load->model("producto","producto",true);
			if ($this->producto->updateImagen($imagen_id,$datos))
				echo "ok";
			else
				echo "ko";
		}
		else
		{
			echo "error_permiso";
		}
	}
	
	public function rubros($producto_id)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 11);
		if ($perm['Modificacion'])
		{
			if ($producto_id > 0)
			{
				$this->load->model("rubro","rubro",true);
				$this->load->model("producto","producto",true);
				$variables['rubros_productos'] = $this->producto->dameRubros($producto_id);
				$variables['rubros'] = $this->rubro->dameRubrosAsociar($producto_id);
				$variables['producto_id'] = $producto_id;
				$this->load->view("admin/productos/rubros_productos",$variables);
			}
			else	
				print "Error. M&eacute;todo no soportado.";
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
	
	public function agregar_rubro()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 11);
		if ($perm['Modificacion'])
		{
			$producto_id = $this->input->post("producto_id");
			$rubro_id = $this->input->post("rubro_id");
			if ($producto_id > 0 and $rubro_id > 0)
			{
				$this->load->model("producto","producto",true);
				$datos['producto_id'] = $producto_id;
				$datos['rubro_id'] = $rubro_id;
				if ($this->producto->insertarRubro($datos))
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
	
	public function eliminar_rubro()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 11);
		if ($perm['Modificacion'])
		{
			$this->load->model("producto","producto",true);
			$relacion_id = $this->input->post("relacion_id");				
			if ($this->producto->deleteRubro($relacion_id))
				echo "ok";
			else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
}
?>