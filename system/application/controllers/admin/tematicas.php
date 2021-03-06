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
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_ok");
			$this->load->model("tematica","tematica",true);
			$variables['listado'] = $this->tematica->listado($busqueda);
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
			$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
			if ($tematica_id > 0)
			{
				$variables['tematica'] = $this->tematica->dameTematica($tematica_id);
				$variables['tematica']['imagenes'] = $this->tematica->dameImgTematica($tematica_id);
				if (!$variables['tematica'])
				{
					redirect(site_url("admin/tematicas"), "refresh");
					exit();
				}
				$variables['tematica']['id'] = $tematica_id;
				$variables['accion'] = "modificar"; 
			}
			else
			{
				$variables['accion'] = "guardar"; 
				if ($this->session->userdata("form_tematica"))
				{
					$variables['tematica'] = $this->session->userdata("form_tematica");
					$variables['tematica']['id'] = 0;
					$this->session->unset_userdata("form_tematica");
				}
				else
					$variables['tematica'] = array("id"=>0);
			}
			$this->load->view("admin/tematicas/formulario",$variables);
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
		$variables['modulo_id'] = 6;
		$variables['padre_id'] = 6;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Alta'])
		{
			$nombre = $this->input->post("nombre");
			$padre_id = $this->input->post("padre_id");
			$descripcion = $this->input->post("descripcion");
			$mensaje = "";
			if ($nombre!="")
			{
				$datos['nombre'] = $nombre;
				$datos['descripcion'] = $descripcion;
				$datos['padre_id'] = $padre_id;
				$datos['usuario_id'] = $user['id'];
				$datos['imagen'] = "";
				$datos['fecha_carga'] = date("Y-m-d H:i:s");
				$this->session->set_userdata("form_tematica",$datos);
				
				$this->load->model("tematica","tematica",true);
				if ($this->tematica->insert($datos))
				{
					$this->session->unset_userdata("form_tematica");
					$mensaje = "La Tem&aacute;tica fue cargada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/tematicas";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/tematicas/formulario";	
				}	
			}
			else
			{
				$mensaje = "Error de conexi&oacute;n a la base de datos.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/tematicas/formulario";
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
		$tematica_id = $this->input->post("tematica_id");
		if ($_FILES['imagen']['name']!="")
		{
			$this->load->library("archivos");
			$this->load->library("imageresize");
			$this->archivos->imageresize = $this->imageresize;
			$this->archivos->file = $_FILES['imagen']; 
			$this->archivos->path = 'tematica/'.$tematica_id."/";
			$this->archivos->tipos = "jpg,png,gif,jpeg";
			
			$res = $this->archivos->subir();
			
			if ($res['error']=="")
			{
				$datos['img'] = $res['img'];
				$datos['url'] = $this->input->post("link");
				$datos['target'] = $this->input->post("target");
				$datos['tematica_id'] = $tematica_id;
						
				$this->load->model("tematica","tematica",true);
				if (!$this->tematica->insertar_imagen($datos))
					$error = "Error al intentar adjuntar im&aacute;gen. Aseg&uacute;rese estar conectado.";
			}
			else
				$error = $res['error'];
			
			/*if($_FILES['imagen']['error'] == 0)
			{
				$extension = strtolower(end(explode(".",$_FILES['imagen']['name'])));
				if ($extension == "jpg" or $extension == "png" or $extension == "gif" or $extension == "jpeg")
				{
					$nombre = date("YmdHisu").".".$extension;
					$ruta_absoluta = PATH_BASE.'tematica/'.$tematica_id."/";
					if (!is_dir($ruta_absoluta))
						mkdir($ruta_absoluta);
						
					$info_imagen=getimagesize($_FILES['imagen']['tmp_name']);
					$ancho = $info_imagen[0];
					$alto = $info_imagen[1];
					if ($ancho <= 2048 and $ancho >= 400)
					{
						move_uploaded_file($_FILES['imagen']['tmp_name'],$ruta_absoluta.$nombre);
						
						$dest_size1 = $ruta_absoluta.$nombre;
						$dest_size2= $ruta_absoluta."tam2_".$nombre;
						$dest_size3= $ruta_absoluta."tam3_".$nombre;
						$dest_th = $ruta_absoluta."th_".$nombre;
						
						$this->load->library("imageresize");
						
						//Size 1
						if ($ancho > TAM_1)
						{		
							$this->imageresize->setImage($ruta_absoluta.$nombre);
							$this->imageresize->resizeWidth(TAM_1); // 900
							$this->imageresize->save($dest_size1);
						}
						else
						{
							$this->imageresize->setImage($ruta_absoluta.$nombre);
							$this->imageresize->resizeWidth($ancho); // 900
							$this->imageresize->save($dest_size1);
						}
						
						//Size 2
						$this->imageresize->setImage($ruta_absoluta.$nombre);
						$this->imageresize->resizeWidth(TAM_2); // 400
						$this->imageresize->save($dest_size2);
						
						//Size 3
						$this->imageresize->setImage($ruta_absoluta.$nombre);
						$this->imageresize->resizeWidth(TAM_3); // 200
						$this->imageresize->save($dest_size3);
						
						//Size Th
						$this->imageresize->setImage($ruta_absoluta.$nombre);
						$this->imageresize->resizeWidth(TH); // 80
						$this->imageresize->save($dest_th);
						
						$datos['img'] = $nombre;
						$datos['url'] = $this->input->post("link");
						$datos['target'] = $this->input->post("target");
						$datos['tematica_id'] = $tematica_id;
						
						$this->load->model("tematica","tematica",true);
						if (!$this->tematica->insertar_imagen($datos))
							$error = "Error al intentar adjuntar im&aacute;gen. Aseg&uacute;rese estar conectado.";
					}
					else
						$error = "Tama&ntilde;o de imagen no permitido. Debe tener un ancho m&iacute;nimo de 400 px y m&aacute;mo a 2048 px.";
				}
				else
					$error = "Formato de archivo no permitido. Los formatos permitidos son <b>jpg, png y gif</b>.";
			}
			else
			{
				$error = "Error al intentar subir la imagen. Aseg&uacute;rese que su tama&ntilde;o no supere los 2M.";
			}*/
		}
		else
		{
			$error = "Debe seleccionar una im&aacute;gen.";
		}
		
		if ($error == "")
		{
			redirect(site_url("admin/tematicas/formulario/".$tematica_id), "refresh");
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
		$variables['modulo_id'] = 6;
		$variables['padre_id'] = 6;
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Alta'])
		{
			$tematica_id = $this->input->post("tematica_id");
			$nombre = $this->input->post("nombre");
			$padre_id = $this->input->post("padre_id");
			$descripcion = $this->input->post("descripcion");
			$mensaje = "";
			if ($nombre!="")
			{
				$datos['nombre'] = $nombre;
				$datos['descripcion'] = $descripcion;
				$datos['padre_id'] = $padre_id;
								
				$this->load->model("tematica","tematica",true);
				if ($this->tematica->update($datos,$tematica_id))
				{
					$mensaje = "La Tem&aacute;tica fue modificada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/tematicas";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/tematicas/formulario/".$tematica_id;	
				}
			}
			else
			{
				$mensaje = "Error de conexi&oacute;n a la base de datos.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/tematicas/formulario/".$tematica_id;
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
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Baja'])
		{
			$tematica_id = $this->input->post("tematica_id");
			$this->load->model("tematica","tematica",true);
			if ($this->tematica->checkDependencias($tematica_id))
			{
				if ($this->tematica->eliminarTematica($tematica_id))
				{
					echo "ok";
				}
				else
					echo "ko";
			}
			else
				echo "error_dependencias";
		}
		else
			echo "error_permiso";
	}
	
	public function borrar_imagen()
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Baja'])
		{
			$tematica_id = $this->input->post("tematica_id");
			$imagen_id = $this->input->post("imagen_id");
			$img_borrar = $this->input->post("img");
			$this->load->model("tematica","tematica",true);
			if ($this->tematica->quitarImagen($imagen_id, $img_borrar, $tematica_id))
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
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Modificacion'])
		{
			if ($imagen_id > 0)
			{
				$this->load->model("tematica","tematica",true);
				$variables['permiso'] = $permiso['Baja'];
				$variables['imagen'] = $this->tematica->dameImagen($imagen_id);
				if ($variables['imagen'])
					$variables['tematica'] = $this->tematica->dameTematica($variables['imagen']['tematica_id']);
				else
					$variables['tematica'] = false;
				$this->load->view("admin/tematicas/editar_imagen",$variables);
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
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Modificacion'])
		{
			$imagen_id = $this->input->post("imagen_id");
			$datos['url'] = $this->input->post("url");
			$datos['target'] = $this->input->post("target");
			$this->load->model("tematica","tematica",true);
			if ($this->tematica->updateImagen($imagen_id,$datos))
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
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Modificacion'])
		{
			if ($imagen_id > 0)
			{
				$this->load->model("tematica","tematica",true);
				$variables['permiso'] = $permiso['Baja'];
				$variables['imagen'] = $this->tematica->dameImagen($imagen_id);
				$img = PATH_BASE . "tematica/".$variables['imagen']['tematica_id']."/".$variables['imagen']['img'];
				$size = getimagesize($img);
				$variables['alto'] = $size[1];
				$variables['ancho'] = $size[0];
				
				$this->load->view("admin/tematicas/crop_imagen",$variables);
			}
			else
				 print "Error. M&eacute;todo no soportado.";
		}
		else
		{
			print "Error. Usted no tiene permiso para usar el m&oacute;dulo seleccionado";
		}
	}
}
?>