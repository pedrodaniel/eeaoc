<?php
class Perfil extends Model
{
	function __construct()
	{
		parent::Model();
	}
	
	public function listado($busqueda,$orden="",$dir="")
	{
		$sql = "select * 
		from perfil";
		
		if ($busqueda!="")
		{
			$sql .= " where perfil like '$busqueda'";
		}
		
		if ($orden !="")
			$sql .= " order by $orden $dir";
		else
			$sql .= " order by perfil";
			
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function damePerfil($perfil_id)
	{
		$sql = "select * from perfil where id = ".$perfil_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			 $res = $query->result_array();
			 return $res[0];
		}
		else
			return false;
	}
	
	public function existePerfil($nombre, $perfil_id="")
	{
		$this->db->select("id");
		$this->db->from("perfil");
		$this->db->where("perfil",$nombre);
		if ($perfil_id!="")
			$this->db->where("id != ".$perfil_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	public function save($datos, $perfil_id)
	{
		if ($perfil_id > 0)
		{
			$this->db->where("id",$perfil_id);
			if ($this->db->update("perfil",$datos))
				return true;
			else
				return false;
		}
		else
		{
			if ($this->db->insert("perfil",$datos))
				return true;
			else
				return false;
		}
	}
	
	public function damePermisos($perfil_id)
	{
		$sql = "select m.nombre, p.* 
		from permiso p 
		inner join modulos m on (m.id = p.modulo_id) 
		where p.perfil_id = $perfil_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameModulos($perfil_id)
	{
		$sql = "select id, nombre
		from modulos  
		where id not in (select modulo_id from permiso where perfil_id = $perfil_id)";
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