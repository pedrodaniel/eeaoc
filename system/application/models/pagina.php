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
		
		$sql .= " order by p.id desc, p.padre_id, p.orden asc  ";
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
	
	public function dameImagen($imagen_id)
	{
		$sql = "select id, img, url, target,pagina_id from pagina_imagen where id = ".$imagen_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res[0];
		}
		else
		{
			return false;
		}
	}
	
	public function dameImgPagina($pagina_id)
	{
		$sql = "select id, img, url, target from pagina_imagen where pagina_id = ".$pagina_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
		{
			return false;
		}
	}
	
	public function insertar_imagen($datos)
	{
		if ($this->db->insert("pagina_imagen",$datos))
			return true;
		else
			return false;
	}
	
	public function updateImagen($imagen_id, $datos)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->update("pagina_imagen",$datos))
			return true;
		else
			return false;
	}
	
	public function borradoImagenesGeneral($pagina_id)
	{
		$sql = "select id, img from pagina_imagen where pagina_id = ".$pagina_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			foreach ($res as $img)
			{
				$this->quitarImagen($img['id'],$img['img'],$pagina_id);
			}
		}
	}
	public function quitarImagen($imagen_id,$img_borrar,$pagina_id)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->delete("pagina_imagen"))
		{
			$path_img_borrar = PATH_BASE . "pagina/" . $pagina_id . "/" . $img_borrar;
			$path_img_borrar2 = PATH_BASE . "pagina/" . $pagina_id . "/tam2_" . $img_borrar;
			$path_img_borrar3 = PATH_BASE . "pagina/" . $pagina_id . "/crop_" . $img_borrar;
			$path_img_borrar4 = PATH_BASE . "pagina/" . $pagina_id . "/th_" . $img_borrar;
							
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