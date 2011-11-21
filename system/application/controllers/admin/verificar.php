<?php
class Verificar extends Controller
{
	function __construct()
	{
		parent::Controller();	
	}
	
	public function index()
	{
		if($this -> input -> post('useremail'))
		{ // Verificamos si llega mediante post el username
		
			$useremail = $this -> input -> post('useremail');
			$useremail = str_replace("'","",$useremail);
			$useremail = str_replace('"','',$useremail);
			$password = $this -> input -> post('password');
			$this -> load -> model('common','common',true);
			$result = $this -> common -> login($useremail, $password); //Llamamos a la funci�n login dentro del modelo common mandando los argumentos password y username
		
			if ($result)
			{ //login exitoso
				$sess_array = array();
				
				$sess_array = array(
					'id' => $result -> id,
					'nombre' => $result -> nombre,
					'apellido' => $result -> apellido,
					'perfil_id' => $result -> perfil_id,
					'perfil' => $result -> perfil,
					'email' => $result -> email
				);
				$this -> session -> set_userdata('logged_in', $sess_array); //Iniciamos una sesi�n con los datos obtenidos de la base.
				
				$actualizo = $this -> common -> ultimoAcceso($sess_array['id']);
				redirect('admin', 'refresh');
				exit();
			}
			else
			{
				$data['error'] = 'Usuario Incorrecto / Deshabilitado';
			}
			
			$this -> load -> view('admin/loginlayout', $data); //Cargamos el mensaje de error en la vista.
			
		}
		else
		{
			$data['error'] = 'Nombre de usuario / Password Incorrecto';
			$this -> load -> view('admin/loginlayout',$data);
		}
		
	}
}
?>