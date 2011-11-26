<?php
class Tematica extends Model
{
	public function listado($busqueda)
	{
		 $sql = "select t.id, t.nombre, t.padre_id, t.fecha_carga, u.apellido as usuario_apellido, u.nombre as usuario_nombre,
		 (select nombre from tematica where id = t.padre_id) as tematica_padre 
		 from tematica t 
		 inner join usuario u on (u.id = t.usuario_id)";
		 
		 if ($busqueda!="")
		 	$sql .= " where t.nombre like '%$busqueda%'";
		 	
		 $sql .= " order by t.id";
		 $query = $this->db->query($sql);
		 if ($query->num_rows() > 0)
		 {
		 	$res = $query->result_array();
		 	return $res;
		 }
		 else
		 	return false;
	}
	
	public function dameTematicas()
	{
		$sql = "select id, nombre from tematica order by id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameTematica($tematica_id)
	{
		$sql = "select id, nombre, padre_id, descripcion from tematica where id = ".$tematica_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res[0];
		}
		else
		{
			return false;
		}
	}
	
	public function insert($datos)
	{
		if ($this->db->insert("tematica",$datos))
			return true;
		else
			return false;
	}
	
	public function update($datos,$tematica_id)
	{
		$this->db->where("id",$tematica_id);
		if ($this->db->update("tematica",$datos))
			return true;
		else
			return false;
	}
	
	public function dameTematicasMenuFront($padre_id=0)
	{
		$sql = "select id, nombre from tematica where padre_id = $padre_id order by orden";
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