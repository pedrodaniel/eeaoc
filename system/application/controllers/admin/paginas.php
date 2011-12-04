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
	public function index($busqueda="")
	{	$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		
			if ($permiso['Listado'])
			{
					if($busqueda){
						$this->load->model("pagina","pagina",true);
						$variables['modulo_id'] = 10;
						$variables['padre_id'] = 0;
						$variables['search'] = $busqueda;
						$variables['listado'] = $this->pagina->listado($busqueda,20,0);
						$variables['page_links']='';
						
						$this->load->view("admin/paginas/listado",$variables);
					}else{
						$this->page();
					}
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		
	}
	public function page($offset=0)
	{
	
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		if ($permiso['Listado'])
			{

				$this->load->model("pagina","pagina",true);
				
				$this->load->library('pagination');
				$config['base_url'] = site_url('admin/paginas/page');
				$config['total_rows'] = $this->pagina->countPages(FALSE);
				$config['per_page'] = 10;
				$config['uri_segment'] = 4;// posicion desde la url para calcular el limit
				$config['num_links'] = 3;
		
				$this->pagination->initialize($config);
		
			
			$variables['page_links'] = $this->pagination->create_links();
		
		
				$variables['modulo_id'] = 10;
				$variables['padre_id'] = 0;
				$variables['search'] ='';
				
			
				$variables['listado'] = $this->pagina->listado('',$config['per_page'],$offset);
			  
			    $variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
				$this->session->unset_userdata("mensaje_ok");
				$this->load->view("admin/paginas/listado",$variables);
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		
		
	}
	
	public function formulario($pagina_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 16;
		$variables['padre_id'] = 15;
		$this->load->model("permiso","permiso",true);
		$permisos = $this->permiso->check($user['perfil_id'], 16);
		
		if ($pagina_id > 0)
			$permiso = ($permisos['Modificacion'])?1:0;
		else
			$permiso = ($permisos['Alta'])?1:0;
			
		if ($permiso)
		{	
			$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
			
			$this->load->model("pagina","pagina",true);
			// ver si conviene poner una tabla con los estado
				$valor[]=array("id"=>0,
					  "nombre"=>'sin menu');
				$valor[]=array("id"=>1,
					  "nombre"=>'principal');
				$valor[]=array("id"=>2,
					  "nombre"=>'sub menu');
				$valor[]=array("id"=>3,
					  "nombre"=>'tercer menu');
			// si viene el id es por que modifica el contenido	
			if ($pagina_id > 0)
			{
				$variables['pagina'] = $this->pagina->damePagina($pagina_id);
				$variables['pagina']['imagenes'] = $this->pagina->dameImgPagina($pagina_id);
				if (!$variables['pagina'])
					{
						redirect(site_url("admin/paginas"), "refresh");
						exit();
					}
					$variables['pagina']["tipo_array"] =$valor;
			}
			else
			{ // no hay id entonces puede ser que sea nuevo salvo que haya intentado carga algo y salio mal entonces entra por from_pagina
				
				if ($this->session->userdata("form_pagina"))
				{
					$variables['pagina'] = $this->session->userdata("form_pagina");
					$variables['pagina']['id'] = 0;
					$this->session->unset_userdata("form_pagina");
				}
				else{
				$variables['pagina'] = array(
											"id"=>0,
											"habilitado"=>0,
											"tipo"=>0,
											"tipo_array"=>$valor);
				}
			}
				
			$this->load->view("admin/paginas/formulario",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	/**
	 * 
	 * Permite habilitar y deshabilitar una pagina para no mostrar en menu principal
	 * @param $p_pagina_id
	 * @return $string
	 */
	public function habilita()
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 16);
		if ($permiso['Modificacion'])
		{
			$pagina_id = $this->input->post("pagina_id");
			$valor =$this->input->post("valor");
			if ($pagina_id > 0)
			{
				$this->load->model("pagina","pagina",true);
				$datos['habilitado'] = $valor;
				if ($this->pagina->save($datos,$pagina_id))
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
	
	public function guardar(){
		
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 16;
		$variables['padre_id'] = 15;
		$pagina_id = $this->input->post("id");
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 16);
		
		if ($permiso['Alta'] )
		{
			$this->load->model("pagina","pagina",true);	
			
			$this->session->set_userdata("form_tematica",$_POST);
			
			$id=$this->pagina->save($_POST, $_POST['id']);
			
			if ($id)
			{
					$mensaje = "La Pagina fue cargada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/paginas";
				
			}else{
				
				$mensaje = "Error de conexi&oacute;n a la base de datos.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/paginas/formulario";		
				
			}
			
						
			
			$this->session->set_userdata($mensaje_nombre,$mensaje);
			redirect(site_url($url), "refresh");
		}
		else
			$this->load->view("admin/error_permiso",$variables);
	}
	
	public function modificar(){
		
		
	$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 16;
		$variables['padre_id'] = 15;
		$pagina_id = $this->input->post("id");
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 16);
		
		if ($permiso['Modificacion'] )
		{ 
			$error="";
			$id= $this->input->post("id");
			$titulo= $this->input->post("titulo");
			$accion = $this->input->post("accion");
			$contenido = $this->input->post("contenido");
			$habilitado = $this->input->post("habilitado");
			$tipo = $this->input->post("tipo");
			
					
			$datos['id']= $id;
			$datos['titulo']= $titulo;
			$datos['accion']= $accion;
			$datos['contenido'] = $contenido;
			$datos['habilitado'] = $habilitado;
			$datos['tipo'] =$tipo;
			
		
					
					
					$this->load->model("pagina","pagina",true);	
					
					$id=$this->pagina->save($datos,$id);
				if ($id)
				{
					$mensaje = "La Pagina fue modificada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/paginas";		
				}
				else
				{
					$mensaje = "Error de conexi&oacute;n a la base de datos.";
					$mensaje_nombre = "mensaje_error";
					$url = "admin/paginas/formulario/".$id;	
				}
				
				$this->session->set_userdata($mensaje_nombre,$mensaje);
				redirect(site_url($url), "refresh");
			
		}else{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function CreaImg()
	{
		$error = "";
		$ok = "";
		$pagina_id = $this->input->post("pagina_id");
		if ($_FILES['imagen']['name']!="")
		{
			
			
			$this->load->library("archivos");
			$this->load->library("imageresize");
			$this->archivos->imageresize = $this->imageresize;
			$this->archivos->file = $_FILES['imagen']; 
			$this->archivos->path = 'pagina/'.$pagina_id."/";
			$this->archivos->tipos = "jpg,png,gif,jpeg";
			
			$res = $this->archivos->subir();
			
			if ($res['error']=="")
			{
				$datos['img'] = $res['img'];
				$datos['url'] = $this->input->post("link");
				$datos['target'] = $this->input->post("target");
				$datos['pagina_id'] = $pagina_id;
						
				$this->load->model("pagina","pagina",true);
				if (!$this->pagina->insertar_imagen($datos))
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
			redirect(site_url("admin/paginas/imagen/".$pagina_id), "refresh");
		}
		else
		{
			$this->session->set_userdata("mensaje_error",$error);
			redirect(site_url("admin/paginas/imagen/".$pagina_id), "refresh");
		}
	}
	/**
	 * 
	 * Se carga el formulario de carga de imagenes ajax
	 */
 public function imagen($p_pagina_id){
 	$variables['pagina']['id']=$p_pagina_id;
 	$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
 	$this->load->view("admin/paginas/imagen",$variables);
 	
 }	
 
 public function traeGaleria($p_pagina_id){
 	   $user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		if ($permiso['Listado'])
			{
				 	$this->load->model("pagina","pagina",true);	
				 	$variables['pagina']['id']=$p_pagina_id;
				 	$variables['pagina']['imagenes'] = $this->pagina->dameImgPagina($p_pagina_id);
				 	$this->load->view("admin/paginas/galeria",$variables);
				 	
			}else{
			$this->load->view("admin/error_permiso",$variables);
			}
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
				$this->load->model("pagina","pagina",true);
				$variables['permiso'] = $permiso['Baja'];
				$variables['imagen'] = $this->pagina->dameImagen($imagen_id);
				if ($variables['imagen'])
					$variables['pagina'] = $this->pagina->damePagina($variables['imagen']['pagina_id']);
				else
					$variables['pagina'] = false;
				$this->load->view("admin/paginas/editar_imagen",$variables);
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
			$this->load->model("pagina","pagina",true);
			if ($this->pagina->updateImagen($imagen_id,$datos))
				echo "ok";
			else
				echo "ko";
		}
		else
		{
			echo "error_permiso";
		}
	}
	
public function borrar_imagen()
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 6);
		if ($permiso['Baja'])
		{
			$pagina_id = $this->input->post("pagina_id");
			$imagen_id = $this->input->post("imagen_id");
			$img_borrar = $this->input->post("img");
			$this->load->model("pagina","pagina",true);
			if ($this->pagina->quitarImagen($imagen_id, $img_borrar, $pagina_id))
			{
				echo "ok";
			}
			else
				echo "ko";
		}
		else
			echo "error_permiso";
	}
}

?>