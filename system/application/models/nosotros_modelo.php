<?php
class Nosotros_modelo extends Model
{
	public function listado()
	{
		$sql = "select id, titulo, imagen from nosotros";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			 $res = $query->result_array();
			 return $res;
		}
		else
			return false;
	}
	
	public function insertar($data)
	{
		if ($this->db->insert("nosotros",$data))
			return true;
		else
			return false;
	}
}
?>