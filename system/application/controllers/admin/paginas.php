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
		if ($permiso)
		{
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
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	public function page($offset=0)
	{
	
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 2);
		if ($permiso)
		{
			if ($permiso['Listado'])
			{

				$this->load->model("pagina","pagina",true);
				
				$this->load->library('pagination');
				$config['base_url'] = site_url('admin/paginas/page');
				$config['total_rows'] = $this->pagina->countPages(FALSE);
				$config['per_page'] = 4;
				$config['uri_segment'] = 4;
				$config['num_links'] = 3;
		
				$this->pagination->initialize($config);
		
			
			$variables['page_links'] = $this->pagination->create_links();
		
		
				$variables['modulo_id'] = 10;
				$variables['padre_id'] = 0;
				$variables['search'] ='';
				
			
				$variables['listado'] = $this->pagina->listado('',$config['per_page'],$offset);
			
				$this->load->view("admin/paginas/listado",$variables);
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
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
				
			if ($pagina_id != 0)
			{
				$variables['pagina'] = $this->pagina->damePagina($pagina_id);
				$variables['pagina']["tipo_array"] =$valor;
			}
			else
			{
				
				
				$variables['pagina'] = array(
											"id"=>0,
											"habilitado"=>0,
											"tipo"=>0,
											"tipo_array"=>$valor);
				
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
			$contenido = $this->input->post("contenido");
			$habilitado = $this->input->post("habilitado");
			$tipo = $this->input->post("tipo");
			
					
			
					
			$datos['id']= $id;
			$datos['titulo']= $titulo;
			$datos['contenido'] = $contenido;
			$datos['habilitado'] = $habilitado;
			$datos['tipo'] =$tipo;
						
					
					
					$this->load->model("pagina","pagina",true);	
					
							
					$id=$this->pagina->save($datos, $_POST['id']);
					
					if ($id)
					{
						$mensaje = "La Pagina fue cargada con &eacute;xito";
						$mensaje_nombre = "mensaje_ok";
						$url = "admin/paginas";
						
					    $this->session->set_userdata("form_pagina",$datos);
						$error = "";
						if ($_FILES['imagen']['name']!="")
						{
							if($_FILES['imagen']['error'] == 0)
							{
								$extension = strtolower(end(explode(".",$_FILES['imagen']['name'])));
								if ($extension == "jpg" or $extension == "png" or $extension == "gif" or $extension == "jpeg")
								{
									$nombre = date("YmdHisu").".".$extension;
									$ruta_absoluta = PATH_BASE.'pagina/';
									$info_imagen=getimagesize($_FILES['imagen']['tmp_name']);
									$ancho = $info_imagen[0];
									$alto = $info_imagen[1];
									if ($ancho <= 2048 and $ancho >= 400)
									{
										move_uploaded_file($_FILES['imagen']['tmp_name'],$ruta_absoluta.$nombre);
										
										/*Diferentes tamanios*/
										$dest_size1 = $ruta_absoluta.$nombre;
										$dest_size2= $ruta_absoluta."tam2_".$nombre;
										$dest_size3= $ruta_absoluta."tam3_".$nombre;
										$dest_th = $ruta_absoluta."th_".$nombre;
										/**********************/
										
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
										$this->imageresize->resizeWidth(TAM_2); // 900
										$this->imageresize->save($dest_size2);
										
										//Size 3
										$this->imageresize->setImage($ruta_absoluta.$nombre);
										$this->imageresize->resizeWidth(TAM_3); // 900
										$this->imageresize->save($dest_size3);
										
										//Size Th
										$this->imageresize->setImage($ruta_absoluta.$nombre);
										$this->imageresize->resizeWidth(TH); // 900
										$this->imageresize->save($dest_th);
										
										$datos['imagen'] = $nombre;
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
							}
						}
						
						
						if ($error=="")
						{
							$this->load->model("pagina","pagina",true);
							if ($this->pagina->insert($datos))
							{
								$this->session->unset_userdata("form_pagina");
								$mensaje = "La Pagina fue cargada con &eacute;xito";
								$mensaje_nombre = "mensaje_ok";
								$url = "admin/paginas";
							}
							else
							{
								$mensaje = "Error de conexi&oacute;n a la base de datos.";
								$mensaje_nombre = "mensaje_error";
								$url = "admin/paginas/formulario";
							}
						}
						else
						{
							$mensaje = $error;
							$mensaje_nombre = "mensaje_error";
							$url = "admin/paginas/formulario/".$id;		
						}
					}else
					{
						$mensaje = "Error de conexi&oacute;n a la base de datos.";
						$mensaje_nombre = "mensaje_error";
						$url = "admin/paginas/formulario/".$id;
					}
					$this->session->set_userdata($mensaje_nombre,$mensaje);
					redirect(site_url($url), "refresh");
			
	}else {
			$this->load->view("admin/error_permiso",$variables);
		}
				
			
	}
}

?>