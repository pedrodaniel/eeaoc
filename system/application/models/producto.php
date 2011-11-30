<?php
class Producto extends Model
{
	public function listado($busqueda)
	{
		 $sql = "select p.id, p.nombre, p.tipo, 
		 (select nombre from tematica where id = p.tematica_id) as tematica,
		 (select nombre from servicio where id = p.servicio_id) as servicio 
		 from tematica t";
		 
		 if ($busqueda!="")
		 	$sql .= " where p.nombre like '%$busqueda%'";
		 	
		 $sql .= " order by p.id";
		 $query = $this->db->query($sql);
		 if ($query->num_rows() > 0)
		 {
		 	$res = $query->result_array();
		 	return $res;
		 }
		 else
		 	return false;
	}
	
	public function dameTematicas()
	{
		$sql = "select id, nombre from tematica order by id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameTematica($tematica_id)
	{
		$sql = "select id, nombre, padre_id, descripcion from tematica where id = ".$tematica_id;
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
	
	public function dameImagen($imagen_id)
	{
		$sql = "select id, img, url, target, tematica_id from tematica_imagen where id = ".$imagen_id;
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
	
	public function dameImgTematica($tematica_id)
	{
		$sql = "select id, img, url, target from tematica_imagen where tematica_id = ".$tematica_id;
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
	
	public function insert($datos)
	{
		if ($this->db->insert("tematica",$datos))
			return true;
		else
			return false;
	}
	
	public function insertar_imagen($datos)
	{
		if ($this->db->insert("tematica_imagen",$datos))
			return true;
		else
			return false;
	}
	
	public function update($datos,$tematica_id)
	{
		$this->db->where("id",$tematica_id);
		if ($this->db->update("tematica",$datos))
			return true;
		else
			return false;
	}
	
	public function eliminarTematica($tematica_id)
	{
		$this->db->where("id",$tematica_id);
		if ($this->db->delete("tematica"))
		{
			$this->borradoImagenesGeneral($tematica_id);
			return true;
		}
		else
			return false;
	}
	
	public function borradoImagenesGeneral($tematica_id)
	{
		$sql = "select id, img from tematica_imagen where tematica_id = ".$tematica_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			foreach ($res as $img)
			{
				$this->quitarImagen($img['id'],$img['img'],$tematica_id);
			}
		}
	}
	
	public function checkDependencias($tematica_id)
	{
		$sql = "select id from tematica where padre_id = ".$tematica_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
			return false;
		else
			return true;
	}
	
	public function updateImagen($imagen_id, $datos)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->update("tematica_imagen",$datos))
			return true;
		else
			return false;
	}
	
	public function quitarImagen($imagen_id,$img_borrar,$tematica_id)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->delete("tematica_imagen"))
		{
			$path_img_borrar = PATH_BASE . "tematica/" . $tematica_id . "/" . $img_borrar;
			$path_img_borrar2 = PATH_BASE . "tematica/" . $tematica_id . "/tam2_" . $img_borrar;
			$path_img_borrar3 = PATH_BASE . "tematica/" . $tematica_id . "/tam3_" . $img_borrar;
			$path_img_borrar4 = PATH_BASE . "tematica/" . $tematica_id . "/th_" . $img_borrar;
							
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
	
	/*Metodos usados en el front*/
	public function dameTematicasMenuFront($padre_id=0)
	{
		$sql = "select id, nombre from tematica where padre_id = $padre_id order by orden";
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