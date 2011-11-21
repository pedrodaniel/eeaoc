<?php
class Pagina extends Model
{
	public function damePaginasMenu($padre_id=0,$tipo=1)
	{
		$sql = "select id, titulo, accion from pagina";
		$sql .= " where padre_id = $padre_id and tipo = $tipo";
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