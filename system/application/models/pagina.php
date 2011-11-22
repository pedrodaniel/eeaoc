<?php
class Pagina extends Model{
	function __construct()
	{
		parent::Model();
	}
	public function listado($busqueda)
	{
		$sql = "select p.id,p.titulo,p.contenido,p.tipo,p.padre_id,p.orden,p.imagen,p.accion 
		from pagina p";
		
		if ($busqueda!="")
		{
			$sql .= "where (p.titulo like '%$busqueda%' or u.contenido like '%$busqueda%' )";
		}
		$sql .= " order by p.orden";
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