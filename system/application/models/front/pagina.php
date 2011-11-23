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
	
	public function dameInfoPagina($pagina_id)
	{
		$sql = "select id, titulo, imagen, contenido, tipo, padre_id from pagina where id = ".$pagina_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			$pag = $res[0];
			return $pag;
		}
		else
			return false;
	}
}
?>