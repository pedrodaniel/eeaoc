<?php
Class Common extends Model
{
	public function login($useremail, $password)
	{
		$sql = "select u.id, u.nombre, u.apellido, u.email, u.perfil_id, u.habilitado, p.perfil 
		from usuario u 
		inner join perfil p on (p.id = u.perfil_id) 
		where u.email = '$useremail' and u.password = md5('$password') and u.habilitado = 1 limit 1";
		
		$query = $this->db->query($sql);
		if($query -> num_rows() == 1)
		{
			$res = $query->result();
			return $res[0];
		}
		else
		{
			return false;
		}

	}
	
	public function ultimoAcceso($usuario_id)
	{
		$dato['ultimo_acceso'] = date('Y-m-d H:i:s');
		$this->db->where("id",$usuario_id);
		$this->db->update("usuario",$dato);
	}
	
	public function existeUser($facebook_id)
	{
		$sql = "select * from usuario where facebook_id = ".$facebook_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res[0];
		}
		else
			return false;
	}
	
	public function alta($datos)
	{
		if ($this->db->insert("usuario",$datos))
		{
			$id = $this->db->insert_id();
			return $id;
		}
		else
			return false;
	}
	
	public function relacionarConFace($usuario_id, $us_face_id)
	{
		$datos['facebook_id'] = $us_face_id;
		$this->db->where("id",$usuario_id);
		if ($this->db->update("usuario",$datos))
			return true;
		else
			return false;
	}
}
?>