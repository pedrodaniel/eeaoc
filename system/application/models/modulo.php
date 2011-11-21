<?php
class Modulo extends Model
{
	function __construct()
	{
		parent::Model();
	}
	
	public function listado($busqueda)
	{
		$sql = "select m.*, (select nombre from modulos where id = m.padre_id) as modulo_padre
		from modulos m ";
		
		if ($busqueda!="")
		{
			$sql .= " where m.nombre like '%$busqueda%'";
		}
		$sql .= " order by m.id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameModulo($modulo_id)
	{
		$sql = "select * from modulos where id = ".$modulo_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			 $res = $query->result_array();
			 return $res[0];
		}
		else
			return false;
	}
	
	public function existeModulo($nombre, $modulo_id="")
	{
		$sql = "select id from modulos where nombre like '$nombre'";
	
		if ($modulo_id!="")
			$sql .= " and id <> ".$modulo_id;

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	public function save($datos, $modulo_id)
	{
		if ($modulo_id > 0)
		{
			$this->db->where("id",$modulo_id);
			if ($this->db->update("modulos",$datos))
			{
				if ($datos['padre_id'] > 0)
					$this->marcarConHijos($datos['padre_id']);
				return true;
			}
			else
				return false;
		}
		else
		{
			if ($this->db->insert("modulos",$datos))
			{
				if ($datos['padre_id'] > 0)
					$this->marcarConHijos($datos['padre_id']);
				return true;
			}
			else
				return false;
		}
	}
	
	public function marcarConHijos($modulo_id)
	{
		$datos['hijos'] = 1;
		$this->db->where("id",$modulo_id);
		if ($this->db->update("modulos",$datos))
			return true;
		else
			return false;
	}
	
	public function damePadres($modulo_id)
	{
		$sql = "select id, nombre from modulos where padre_id = 0 and id <> ".$modulo_id;
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