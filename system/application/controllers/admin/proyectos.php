<?php
class Proyectos extends Controller
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
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		$variables['modulo_id'] = 20;
		$variables['padre_id'] = 15;
		if ($permiso['Listado'])
		{
			$variables['search'] = $busqueda;
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_ok");
			$this->load->model("proyecto","proyecto",true);
			$variables['listado'] = $this->proyecto->listado($busqueda);
			$this->load->view("admin/proyectos/listado",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function formulario($proyecto_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 20;
		$variables['padre_id'] = 15;
		$this->load->model("permiso","permiso",true);
		$permisos = $this->permiso->check($user['perfil_id'], 20);
		if ($proyecto_id > 0)
			$permiso = ($permisos['Modificacion'])?1:0;
		else
			$permiso = ($permisos['Alta'])?1:0;
			
		if ($permiso)
		{
			$this->load->model("proyecto","proyecto",true);
			$this->load->model("tematica","tematica",true);
			$this->load->model("caracteristica","caracteristica",true);
			$variables['tematicas'] = $this->tematica->dameTematicas();
			
			$variables['proyecto_caracteristicas'] = $this->proyecto->dameCaracteristicas($proyecto_id);
			$variables['caracteristicas'] = $this->proyecto->dameCaracteristicaAsociar($proyecto_id);
			//$variables['caracteristicas'] = $this->caracteristica->dameCaracteristicas();
			$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
			if ($proyecto_id > 0)
			{
				$variables['proyecto'] = $this->proyecto->dameProyecto($proyecto_id);
				$variables['proyecto']['imagenes'] = $this->proyecto->dameImgProyecto($proyecto_id);
				if (!$variables['proyecto'])
				{
					redirect(site_url("admin/proyectos"), "refresh");
					exit();
				}
				$variables['proyecto']['id'] = $proyecto_id;
				$variables['accion'] = "modificar"; 
			}
			else
			{
				$variables['accion'] = "guardar"; 
				if ($this->session->userdata("form_proyecto"))
				{
					$variables['proyecto'] = $this->session->userdata("form_proyecto");
					$variables['proyecto']['id'] = 0;
					$this->session->unset_userdata("form_proyecto");
				}
				else
					$variables['proyecto'] = array("id"=>0);
			}
			$this->load->view("admin/proyectos/formulario",$variables);
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
		$variables['modulo_id'] = 20;
		$variables['padre_id'] = 15;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 20);
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
				$this->session->set_userdata("form_proyecto",$datos);
				
				$this->load->model("proyecto","proyecto",true);
				if ($this->proyecto->insert($datos))
				{
					$this->session->unset_userdata("form_proyecto");
					$mensaje = "La Proyecto fue cargada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/proyectos";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/proyectos/formulario";	
				}	
			}
			else
			{
				$mensaje = "T&iacute;tulo y Texto son obligatorios.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/proyectos/formulario";
			}
			$this->session->set_userdata($mensaje_nombre,$mensaje);
			redirect(site_url($url), "refresh");
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	
	
	public function modificar()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 20;
		$variables['padre_id'] = 15;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Modificacion'])
		{
			$proyecto_id = $this->input->post("proyecto_id");
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
				$this->load->model("proyecto","proyecto",true);
				if ($this->proyecto->update($datos,$proyecto_id))
				{
					$mensaje = "La Proyecto fue modificada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/proyectos";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/proyectos/formulario/".$proyecto_id;	
				}
			}
			else
			{
				$mensaje = "T&iacute;tulo y Texto son obligatorios.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/proyectos/formulario/".$proyecto_id;
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
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Baja'])
		{
			$proyecto_id = $this->input->post("proyecto_id");
			$this->load->model("proyecto","proyecto",true);
			
			$borro=$this->proyecto->eliminarProyecto($proyecto_id);
			
			if ($borro=='si')
			{	echo "ok";
			}elseif($borro=='no'){
				echo "caract";
			}else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
	/**
	 * 
	 * Se carga el formulario de carga de imagenes ajax
	 */
 	public function imagen($p_proyecto_id){
 	$variables['proyecto']['id']=$p_proyecto_id;
 	$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
 	$this->load->view("admin/proyectos/imagen",$variables);
 	
 }	
 
	public function CreaImg()
	{
		$error = "";
		$ok = "";
		$proyecto_id = $this->input->post("proyecto_id");
		if ($_FILES['imagen']['name']!="")
		{
			
			
			$this->load->library("archivos");
			$this->load->library("imageresize");
			$this->archivos->imageresize = $this->imageresize;
			$this->archivos->file = $_FILES['imagen']; 
			$this->archivos->path = 'proyecto/'.$proyecto_id."/";
			$this->archivos->tipos = "jpg,png,gif,jpeg";
			
			$res = $this->archivos->subir();
			
			if ($res['error']=="")
			{
				$datos['img'] = $res['img'];
				$datos['url'] = $this->input->post("link");
				$datos['target'] = $this->input->post("target");
				$datos['proyectos_id'] = $proyecto_id;
						
				$this->load->model("proyecto","proyecto",true);
				if (!$this->proyecto->insertar_imagen($datos))
					$error = "Error al intentar adjuntar im&aacute;gen. Aseg&uacute;rese estar conectado.";
				else {
					
				//	echo" <script>parent.location.reload();</script>";
				}	
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
			redirect(site_url("admin/proyectos/imagen/".$proyecto_id), "refresh");
		}
		else
		{
			$this->session->set_userdata("mensaje_error",$error);
			redirect(site_url("admin/proyectos/imagen/".$proyecto_id), "refresh");
		}
	}
 
	public function borrar_imagen()
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Baja'])
		{
			$proyecto_id = $this->input->post("proyecto_id");
			$imagen_id = $this->input->post("imagen_id");
			$img_borrar = $this->input->post("img");
			$this->load->model("proyecto","proyecto",true);
			if ($this->proyecto->quitarImagen($imagen_id, $img_borrar, $proyecto_id))
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
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Modificacion'])
		{
			if ($imagen_id > 0)
			{
				$this->load->model("proyecto","proyecto",true);
				$variables['permiso'] = $permiso['Modificacion'];
				$variables['imagen'] = $this->proyecto->dameImagen($imagen_id);
				if ($variables['imagen'])
					$variables['proyecto'] = $this->proyecto->dameProyecto($variables['imagen']['proyectos_id']);
				else
					$variables['proyecto'] = false;
				$this->load->view("admin/proyectos/editar_imagen",$variables);
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
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Modificacion'])
		{
			$imagen_id = $this->input->post("imagen_id");
			$datos['url'] = $this->input->post("url");
			$datos['target'] = $this->input->post("target");
			$datos['destacada'] = $this->input->post("destacada");
			$this->load->model("proyecto","proyecto",true);
			if ($this->proyecto->updateImagen($imagen_id,$datos))
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
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Modificacion'])
		{
			if ($imagen_id > 0)
			{
				$this->load->model("proyecto","proyecto",true);
				$variables['permiso'] = $permiso['Modificacion'];
				$variables['imagen'] = $this->proyecto->dameImagen($imagen_id);
				$img = PATH_BASE . "proyecto/".$variables['imagen']['proyectos_id']."/".$variables['imagen']['img'];
				$size = getimagesize($img);
				$variables['alto'] = $size[1];
				$variables['ancho'] = $size[0];
				
				$this->load->view("admin/proyectos/crop_imagen",$variables);
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
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Modificacion'])
		{
			$proyecto_id = $this->input->post("proyecto_id");
			$valor = $this->input->post("valor");
			if ($proyecto_id > 0)
			{
				$this->load->model("proyecto","proyecto",true);
				$datos['destacada'] = $valor;
				if ($this->proyecto->update($datos,$proyecto_id))
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
	
	public function traeGaleria($p_proyecto_id){
 	   $user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 20);
		if ($permiso['Listado'])
			{
				 	$this->load->model("proyecto","proyecto",true);	
				 	$variables['proyecto']['id']=$p_proyecto_id;
				 	$variables['proyecto']['imagenes'] = $this->proyecto->dameImgProyecto($p_proyecto_id);
				 	$this->load->view("admin/proyectos/galeria",$variables);
				 	
			}else{
			$this->load->view("admin/error_permiso",$variables);
			}
 		}
/******************* Seccion para asociar Caracteristicas a Proyecto ***************/	
	public function caracteristicas($proyecto_id)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 11);
		if ($perm['Modificacion'])
		{
			if ($proyecto_id > 0)
			{
				
				$this->load->model("proyecto","proyecto",true);
				$variables['proyecto_caracteristicas'] = $this->proyecto->dameCaracteristicas($proyecto_id);
				$variables['caracteristicas'] = $this->proyecto->dameCaracteristicaAsociar($proyecto_id);
				$variables['proyecto_id'] = $proyecto_id;
				$this->load->view("admin/proyectos/proyectos_caracteristicas",$variables);
			}
			else	
				print "Error. M&eacute;todo no soportado.";
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
	
	public function eliminar_caracteristica()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 11);
		if ($perm['Modificacion'])
		{
			$this->load->model("proyecto","proyecto",true);
			$relacion_id = $this->input->post("relacion_id");				
			if ($this->proyecto->deleteCaracteristicas($relacion_id))
				echo "ok";
			else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
	
	public function agregar_caracteristica()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$perm = $this->permiso->check($user['perfil_id'], 11);
		if ($perm['Modificacion'])
		{
			$proyecto_id = $this->input->post("proyecto_id");
			$caracteristica_id = $this->input->post("caracteristica_id");
			if ($proyecto_id > 0 and $caracteristica_id > 0)
			{
				$this->load->model("proyecto","proyecto",true);
				$datos['proyectos_id'] = $proyecto_id;
				$datos['caracteristica_id'] = $caracteristica_id;
				if ($this->proyecto->insertarCaracteristicas($datos))
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