<?php
class Pagina extends Model{
	function __construct()
	{
		parent::Model();
	}
	public function listado($busqueda,$per_page,$segment)
	{
		/*$sql = "select m1.id,m1.padre_id,m1.orden,m1.habilitado,m1.titulo from ( select id,padre_id,orden from pagina where padre_id=0 order by orden asc ) m0
right join ( select id,padre_id,orden ,habilitado,titulo from pagina order by orden asc ) m1 on m1.padre_id=m0.id";*/
		
		$sql = "select *,(select titulo from pagina where id=p.padre_id) as pagina_padre from pagina p";

		if ($busqueda!="")
		{
			$sql .= " where (p.titulo like '%$busqueda%' or p.contenido like '%$busqueda%' )";
		}
		
		$sql .= " order by p.padre_id, p.orden asc  ";
	    $sql.=" limit ".$segment.",".$per_page;
		

		
		$query = $this->db->query($sql); 
		//$this->db->get();

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
				return $p_pagina_id;
			else
				return false;
		}
		else
		{
			if ($this->db->insert("pagina",$datos))
				return $this->db->insert_id();
			else
				return false;
		}
	}
	
	/**
	 * Get a count of pages
	 * 
	 * @deprecated use get('count=1');
	 *
	 * @param bool $published
	 * @return int
	 */
	function countPages($published=TRUE){
		if($published)
			return $this->db->count_all('pagina');
		else
			return $this->db->query("
				SELECT count(*) cnt 
				FROM pagina
				")->first_row()->cnt;
	}
	function getPages($per_page,$segment){
		$query = $this->db->get('pagina',$per_page,$segment);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
}