<?php
class Pagina extends Model{
	function __construct()
	{
		parent::Model();
	}
	public function listado($busqueda)
	{
		$sql = "select p.*, (select titulo from pagina where id = p.padre_id) as pagina_padre 
		from pagina  p";
		
		if ($busqueda!="")
		{
			$sql .= " where (p.titulo like '%$busqueda%' or p.contenido like '%$busqueda%' )";
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
	
	public function damePagina($p_pagina_id)
	{
		$sql = "select * from pagina where  id=".$p_pagina_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res[0];
		}
		else
			return false;
	}
	/**
	 * 
	 * Permite guardar los campos de la pagina atravez de una funcion del framework
	 * @param $datos
	 * @param $p_pagina_id
	 */
	public function save($datos, $p_pagina_id)
	{
		if ($p_pagina_id > 0)
		{
			$this->db->where("id",$p_pagina_id);
			if ($this->db->update("pagina",$datos))
				return true;
			else
				return false;
		}
		else
		{
			if ($this->db->insert("pagina",$datos))
				return true;
			else
				return false;
		}
	}
}