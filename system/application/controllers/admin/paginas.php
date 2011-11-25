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
						$this->load->view("admin/paginas/paginas",$variables);
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
			
				$this->load->view("admin/paginas/paginas",$variables);
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
		
		if ($permiso['Modificacion'] )
		{
			$this->load->model("pagina","pagina",true);	
			
			/*$config['upload_path'] = './uploads/pagina';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '5000';
			$config['encrypt_name'] = TRUE;*/

			/*$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload("imagen"))
			{
				echo $this->upload->display_errors();
			}
			else
			{	$data = $this->upload->data();
				$_POST['imagen']=$data['file_name'];
			}	*/
	 		
			
			if ($this->pagina->save($_POST, $_POST['id']))
			{
				redirect(site_url("admin/paginas"), "refresh");
			}
			else
			{
				redirect(site_url("admin/paginas/formulario/".$pagina_id), "refresh");
			}
		}
		else
			$this->load->view("admin/error_permiso",$variables);
	}
}

?>