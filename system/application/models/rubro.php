<?php
class Rubro extends Model
{
	public function dameRubrosAsociar($producto_id)
	{
		$sql = "select r.id, r.nombre from rubro r 
		where r.id not in (select rubro_id from producto_rubro where producto_id = $producto_id) 
		order by r.nombre";
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