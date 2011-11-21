<?php
class Tematica extends Model
{
	public function listado($busqueda)
	{
		 $sql = "select t.id, t.nombre, t.imagen, t.padre_id, t.fecha_carga, u.apellido as usuario_apellido, u.nombre as usuario_nomnbre,
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
}
?>