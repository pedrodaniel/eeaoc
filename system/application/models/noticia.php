<?php
class Noticia extends Model
{
	public function listado($busqueda)
	{
		 $sql = "select n.id, n.titulo, n.destacada, n.fecha, n.tipo, u.apellido as usuario_apellido, u.nombre as usuario_nombre,
		 (select nombre from tematica where id = n.tematica_id) as tematica, 
		 (select nombre from servicio where id = n.servicio_id) as servicio 
		 from novedades n 
		 inner join usuario u on (u.id = n.usuario_id)";
		 
		 if ($busqueda!="")
		 	$sql .= " where n.titulo like '%$busqueda%'";
		 	
		 $sql .= " order by n.fecha desc";
		 $query = $this->db->query($sql);
		 if ($query->num_rows() > 0)
		 {
		 	$res = $query->result_array();
		 	return $res;
		 }
		 else
		 	return false;
	}
	
	public function dameNoticia($noticia_id)
	{
		$sql = "select id, titulo, tematica_id, servicio_id, destacada, texto, tipo from novedades where id = ".$noticia_id;
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
		$sql = "select id, img, url, target, novedad_id, destacada from foto_novedades where id = ".$imagen_id;
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
	
	public function dameImgNoticia($noticia_id)
	{
		$sql = "select id, img, url, target, destacada, novedad_id from foto_novedades where novedad_id = ".$noticia_id;
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
		if ($this->db->insert("novedades",$datos))
			return true;
		else
			return false;
	}
	
	public function insertar_imagen($datos)
	{
		if ($this->db->insert("foto_novedades",$datos))
			return true;
		else
			return false;
	}
	
	public function update($datos,$noticia_id)
	{
		$this->db->where("id",$noticia_id);
		if ($this->db->update("novedades",$datos))
			return true;
		else
			return false;
	}
	
	public function eliminarNoticia($noticia_id)
	{
		$this->db->where("id",$noticia_id);
		if ($this->db->delete("novedades"))
		{
			$this->borradoImagenesGeneral($noticia_id);
			return true;
		}
		else
			return false;
	}
	
	public function borradoImagenesGeneral($noticia_id)
	{
		$sql = "select id, img from foto_novedades where novedad_id = ".$noticia_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			foreach ($res as $img)
			{
				$this->quitarImagen($img['id'],$img['img'],$noticia_id);
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
		if ($this->db->update("foto_novedades",$datos))
			return true;
		else
			return false;
	}
	
	public function quitarImagen($imagen_id,$img_borrar,$noticia_id)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->delete("foto_novedades"))
		{
			$path_img_borrar = PATH_BASE . "noticia/" . $noticia_id . "/" . $img_borrar;
			$path_img_borrar2 = PATH_BASE . "noticia/" . $noticia_id . "/tam2_" . $img_borrar;
			$path_img_borrar3 = PATH_BASE . "noticia/" . $noticia_id . "/crop_" . $img_borrar;
			$path_img_borrar4 = PATH_BASE . "noticia/" . $noticia_id . "/th_" . $img_borrar;
							
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
	public function dameUltimaNota($tipo)
	{
		$sql = "select id from novedades where tipo = $tipo order by fecha desc limit 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res[0]['id'];
		}
		else
			return 0;
	}
	
	public function dameNotasTipo($tipo)
	{
		$sql = "select id, titulo from novedades where tipo = $tipo order by fecha desc limit 3";
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