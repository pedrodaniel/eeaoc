<?php
class Usuario extends Model
{
	function __construct()
	{
		parent::Model();
	}
	
	public function listado($perfil_id,$busqueda)
	{
		$sql = "select u.id, u.nombre, u.apellido, u.email, u.habilitado, u.ultimo_acceso, p.perfil 
		from usuario u 
		inner join perfil p on (p.id = u.perfil_id) 
		where u.perfil_id >= ".$perfil_id;
		
		if ($busqueda!="")
		{
			$sql .= " and (u.nombre like '%$busqueda%' or u.apellido like '%$busqueda%' or u.email like '%$busqueda%')";
		}
		$sql .= " order by u.apellido, u.nombre";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameUsuario($usuario_id)
	{
		$sql = "select * from usuario where id = ".$usuario_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			 $res = $query->result_array();
			 return $res[0];
		}
		else
			return false;
	}
	
	public function existeEmail($email, $usuario_id="")
	{
		$this->db->select("id");
		$this->db->from("usuario");
		$this->db->where("email",$email);
		if ($usuario_id!="")
			$this->db->where("id != ".$usuario_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	public function save($datos, $usuario_id)
	{
		if ($usuario_id > 0)
		{
			$this->db->where("id",$usuario_id);
			if ($this->db->update("usuario",$datos))
				return true;
			else
				return false;
		}
		else
		{
			if ($this->db->insert("usuario",$datos))
				return true;
			else
				return false;
		}
	}
	
	public function damePerfile($perfil_id)
	{
		$sql = "select id, perfil from perfil where habilitado = 1 and id >= ".$perfil_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
}
?>