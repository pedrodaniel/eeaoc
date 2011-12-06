<?php
class Rubros extends Controller
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
		$permiso = $this->permiso->check($user['perfil_id'], 12);
		
			if ($permiso['Listado'])
			{
					if($busqueda){
						$this->load->model("rubro","rubro",true);
						$variables['modulo_id'] = 10;
						$variables['padre_id'] = 0;
						$variables['search'] = $busqueda;
						$variables['listado'] = $this->rubro->listado($busqueda,20,0);
						$variables['page_links']='';
						$variables['mensaje_ok']='';
						$this->load->view("admin/rubros/listado",$variables);
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
		$permiso = $this->permiso->check($user['perfil_id'], 12);
		if ($permiso['Listado'])
			{

				$this->load->model("rubro","rubro",true);
				
				$this->load->library('pagination');
				$config['base_url'] = site_url('admin/rubros/page');
				$config['total_rows'] = $this->rubro->countPages(FALSE);
				$config['per_page'] = 10;
				$config['uri_segment'] = 4;// posicion desde la url para calcular el limit
				$config['num_links'] = 3;
		
				$this->pagination->initialize($config);
		
			
			$variables['page_links'] = $this->pagination->create_links();
		
		
				$variables['modulo_id'] = 12;
				$variables['padre_id'] = 0;
				$variables['search'] ='';
				
			
				$variables['listado'] = $this->rubro->listado('',$config['per_page'],$offset);
			  
			    $variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
				$this->session->unset_userdata("mensaje_ok");
				$this->load->view("admin/rubros/listado",$variables);
			}
			else
				$this->load->view("admin/error_permiso",$variables);
		
		
	}
	
	public function formulario($rubro_id=0)
	{
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 12;
		$variables['padre_id'] = 0;
		$this->load->model("permiso","permiso",true);
		$permisos = $this->permiso->check($user['perfil_id'], 12);
		
		if ($rubro_id > 0)
			$permiso = ($permisos['Modificacion'])?1:0;
		else
			$permiso = ($permisos['Alta'])?1:0;
			
		if ($permiso)
		{	
			$variables['mensaje_error'] = $this->session->userdata("mensaje_error");
			$variables['mensaje_ok'] = $this->session->userdata("mensaje_ok");
			$this->session->unset_userdata("mensaje_error");
			$this->session->unset_userdata("mensaje_ok");
			
		// si viene el id es por que modifica el contenido	
			if ($rubro_id > 0)
			{	
				$this->load->model("rubro","rubro",true);	
				$variables['rubro'] = $this->rubro->dameRubro($rubro_id);
			
				if (!$variables['rubro'])
					{
						redirect(site_url("admin/rubros"), "refresh");
						exit();
					}
					
			}
			else
			{ // no hay id entonces puede ser que sea nuevo salvo que haya intentado carga algo y salio mal entonces entra por from_pagina
				
				if ($this->session->userdata("form_rubro"))
				{
					$variables['rubro'] = $this->session->userdata("form_rubro");
					$variables['rubro']['id'] = 0;
					
					$this->session->unset_userdata("form_rubro");
				}
				else{
				$variables['rubro'] = array(
											"id"=>0,
											"imagen" => ''
											);
				}
			}
				
			$this->load->view("admin/rubros/formulario",$variables);
		}
		else
		{
			$this->load->view("admin/error_permiso",$variables);
		}
	}
	
	public function guardar(){
		
		$user=$this->session->userdata('logged_in');
		$variables['user'] = $user;	
		$variables['modulo_id'] = 12;
		$variables['padre_id'] = 0;
		
		$this->load->model("permiso","permiso",true);
		$permisos = $this->permiso->check($user['perfil_id'], 12);
		
		$rubro_id= $this->input->post("id");
		
		if ($rubro_id > 0)
			$permiso = ($permisos['Modificacion'])?1:0;
		else
			$permiso = ($permisos['Alta'])?1:0;
			
	
		if ($permiso )
		{
			$this->load->model("rubro","rubro",true);	
			
			$error="";
			
			$nombre= $this->input->post("nombre");
			$descripcion = $this->input->post("descripcion");
								
			$datos['id']= $rubro_id;
			$datos['nombre']= $nombre;
			$datos['descripcion'] = $descripcion;
			$this->session->set_userdata("form_rubro",$_POST);
			
			$id=$this->rubro->save($datos, $datos['id']);
			
			if ($id)
			{
				if ($_FILES['imagen']['name']!="")
					{
					$this->load->library("archivos");
					$this->load->library("imageresize");
					$this->archivos->imageresize = $this->imageresize;
					$this->archivos->file = $_FILES['imagen']; 
					$this->archivos->path = 'rubro/'.$id."/";
					$this->archivos->tipos = "jpg,png,gif,jpeg";
										
					$res = $this->archivos->subir();
			
						if ($res['error']=="")
						{
							$img['imagen']=$res['img'];
							$this->rubro->save($img, $id);
						}
					}			
					
					$mensaje = "La Pagina fue cargada con &eacute;xito";
					$mensaje_nombre = "mensaje_ok";
					$url = "admin/rubros";
				
			}else{
				
				$mensaje = "Error de conexi&oacute;n a la base de datos.";
				$mensaje_nombre = "mensaje_error";
				$url = "admin/rubros/formulario";		
				
			}
			
						
			
			$this->session->set_userdata($mensaje_nombre,$mensaje);
			redirect(site_url($url), "refresh");
		}
		else
			$this->load->view("admin/error_permiso",$variables);
	}
	
	public function borrar_imagen()
	{
		$user=$this->session->userdata('logged_in');
		$this->load->model("permiso","permiso",true);
		$permiso = $this->permiso->check($user['perfil_id'], 12);
		if ($permiso['Baja'])
		{
			$rubro_id = $this->input->post("rubro_id");
			$img_borrar = $this->input->post("img");
			$this->load->model("rubro","rubro",true);
			if ($this->rubro->quitarImagen($img_borrar, $rubro_id))
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