<?php
class Caracteristica extends Model{
	function __construct()
	{
		parent::Model();
	}
	public function listado($busqueda,$per_page,$segment)
	{
		$sql = "select * from caracteristica r";

		if ($busqueda!="")
		{
			$sql .= " where (r.nombre like '%$busqueda%' or r.descripcion like '%$busqueda%' )";
		}
		
		$sql .= " order by r.nombre asc  ";
	    $sql.=" limit ".$segment.",".$per_page;
		
		$query = $this->db->query($sql); 
	

		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameCaracteristica($p_caracteristica_id)
	{
		$sql = "select * from caracteristica where  id=".$p_caracteristica_id;
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
	 * Permite guardar los campos del caracteristica atravez de una funcion del framework
	 * @param $datos
	 * @param $p_caracteristica_id
	 */
	public function save($datos, $p_caracteristica_id)
	{
		if ($p_caracteristica_id > 0)
		{
			$this->db->where("id",$p_caracteristica_id);
			if ($this->db->update("caracteristica",$datos))
				return $p_caracteristica_id;
			else
				return false;
		}
		else
		{
			if ($this->db->insert("caracteristica",$datos))
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
			return $this->db->count_all('caracteristica');
		else
			return $this->db->query("
				SELECT count(*) cnt 
				FROM caracteristica
				")->first_row()->cnt;
	}
	
	function getPages($per_page,$segment){
		$query = $this->db->get('caracteristica',$per_page,$segment);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function quitarImagen($img_borrar,$caracteristica_id)
	{
		$this->db->where("id",$caracteristica_id);
		$dato['imagen']='';
		if ($this->db->update("caracteristica",$dato))
		{
			$path_img_borrar = PATH_BASE . "caracteristica/" . $caracteristica_id . "/" . $img_borrar;
			$path_img_borrar2 = PATH_BASE . "caracteristica/" . $caracteristica_id . "/tam2_" . $img_borrar;
			$path_img_borrar3 = PATH_BASE . "caracteristica/" . $caracteristica_id . "/crop_" . $img_borrar;
			$path_img_borrar4 = PATH_BASE . "caracteristica/" . $caracteristica_id . "/th_" . $img_borrar;
							
			if (file_exists($path_img_borrar))
				unlink($path_img_borrar);
			if (file_exists($path_img_borrar2))
				unlink($path_img_borrar2);
			if (file_exists($path_img_borrar3))
				unlink($path_img_borrar3);
			if (file_exists($path_img_borrar4))
				unlink($path_img_borrar4);
					
			return true;
		}
		else
			return false;
	}
}