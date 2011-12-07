<?php
class Rubro extends Model{
	function __construct()
	{
		parent::Model();
	}
	public function listado($busqueda,$per_page,$segment)
	{
		$sql = "select * from rubro r";

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
	
	public function dameRubro($p_rubro_id)
	{
		$sql = "select * from rubro where  id=".$p_rubro_id;

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
	 * Permite guardar los campos del rubro atravez de una funcion del framework
	 * @param $datos
	 * @param $p_rubro_id
	 */
	public function save($datos, $p_rubro_id)
	{
		if ($p_rubro_id > 0)
		{
			$this->db->where("id",$p_rubro_id);
			if ($this->db->update("rubro",$datos))
				return $p_rubro_id;
			else
				return false;
		}
		else
		{
			if ($this->db->insert("rubro",$datos))
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
			return $this->db->count_all('rubro');
		else
			return $this->db->query("
				SELECT count(*) cnt 
				FROM rubro
				")->first_row()->cnt;
	}
	
	function getPages($per_page,$segment)
	{
		$query = $this->db->get('rubro',$per_page,$segment);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();

			return $res;
		}
		else
			return false;

	}
	
	public function quitarImagen($img_borrar,$rubro_id)
	{
		$this->db->where("id",$rubro_id);
		$dato['imagen']='';
		if ($this->db->update("rubro",$dato))
		{
			$path_img_borrar = PATH_BASE . "rubro/" . $rubro_id . "/" . $img_borrar;
			$path_img_borrar2 = PATH_BASE . "rubro/" . $rubro_id . "/tam2_" . $img_borrar;
			$path_img_borrar3 = PATH_BASE . "rubro/" . $rubro_id . "/crop_" . $img_borrar;
			$path_img_borrar4 = PATH_BASE . "rubro/" . $rubro_id . "/th_" . $img_borrar;
							
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