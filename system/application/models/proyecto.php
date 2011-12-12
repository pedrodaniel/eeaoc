<?php
class Proyecto extends Model
{
	public function listado($busqueda)
	{
		 $sql = "select p.id, p.titulo, p.destacada, p.fecha,p.tipo, u.apellido as usuario_apellido, u.nombre as usuario_nombre,
 		 (select nombre from tematica where id = p.tematica_id) as tematica
		 
		 from proyectos p 
		 inner join usuario u on (u.id = p.usuario_id)";
		 
		 if ($busqueda!="")
		 	$sql .= " where p.titulo like '%$busqueda%'";
		 	
		 $sql .= " order by p.fecha desc";
		 $query = $this->db->query($sql);
		 if ($query->num_rows() > 0)
		 {
		 	$res = $query->result_array();
		 	return $res;
		 }
		 else
		 	return false;
	}
	
	public function dameProyecto($proyectos_id)
	{
		$sql = "select id, titulo, tematica_id, servicio_id, destacada, texto, tipo from proyectos where id = ".$proyectos_id;
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
		$sql = "select id, img, url, target, proyectos_id, destacada from proyectos_imagen where id = ".$imagen_id;
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
	
	public function dameImgProyecto($proyectos_id)
	{
		$sql = "select id, img, url, target, destacada, proyectos_id from proyectos_imagen where proyectos_id = ".$proyectos_id;
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
		if ($this->db->insert("proyectos",$datos))
			return true;
		else
			return false;
	}
	
	public function insertar_imagen($datos)
	{
		if ($this->db->insert("proyectos_imagen",$datos))
			return true;
		else
			return false;
	}
	
	public function update($datos,$proyecto_id)
	{
		$this->db->where("id",$proyecto_id);
		if ($this->db->update("proyectos",$datos))
			return true;
		else
			return false;
	}
	
	public function eliminarProyecto($proyectos_id)
	{
		$caracteristica=$this->dameCaracteristicas($proyectos_id);
		if($caracteristica){
			return 'no';
		}else{
			$this->db->where("id",$proyectos_id);
			if ($this->db->delete("proyectos"))
			{
				$this->borradoImagenesGeneral($proyectos_id);
				return 'si';
			}
			else
				return false;
		}		
	}
	
	public function borradoImagenesGeneral($proyectos_id)
	{
		$sql = "select id, img from proyectos_imagen where proyectos_id = ".$proyectos_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			foreach ($res as $img)
			{
				$this->quitarImagen($img['id'],$img['img'],$proyectos_id);
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
		if ($this->db->update("proyectos_imagen",$datos))
			return true;
		else
			return false;
	}
	
	public function quitarImagen($imagen_id,$img_borrar,$noticia_id)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->delete("proyectos_imagen"))
		{
			$path_img_borrar = PATH_BASE . "proyecto/" . $noticia_id . "/" . $img_borrar;
			$path_img_borrar2 = PATH_BASE . "proyecto/" . $noticia_id . "/tam2_" . $img_borrar;
			$path_img_borrar3 = PATH_BASE . "proyecto/" . $noticia_id . "/crop_" . $img_borrar;
			$path_img_borrar4 = PATH_BASE . "proyecto/" . $noticia_id . "/th_" . $img_borrar;
							
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
/**************************  Para asociar Caracteristicas *************************************/
		
	public function dameCaracteristicas($proyecto_id)
	{
		$sql = "select c.id, c.nombre, pr.id as relacion_id from caracteristica c 
		inner join proyectos_caract pr on (pr.caracteristica_id = c.id) 
		where pr.proyectos_id = ".$proyecto_id." order by c.nombre";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameCaracteristicaAsociar($proyecto_id)
	{
		$sql = "select c.id, c.nombre from caracteristica c 
		where c.id not in (select caracteristica_id from proyectos_caract where proyectos_id = $proyecto_id) 
		order by c.nombre";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();

			return $res;
		}
		else
			return false;
	}
	public function insertarCaracteristicas($datos)
	{
		if ($this->db->insert("proyectos_caract",$datos))
			return true;
		else
			return false;
	}
	
	public function deleteCaracteristicas($relacion_id)
	{
		$this->db->where("id",$relacion_id);
		if ($this->db->delete("proyectos_caract"))
			return true;
		else
			return false;
	}
	
	/*Metodos usados en el front*/
	public function dameUltimoProyecto($tipo)
	{
		$sql = "select id from proyectos where tipo = $tipo order by fecha desc limit 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res[0]['id'];
		}
		else
			return 0;
	}
	
	public function dameProyectoTipo($tipo)
	{
		$sql = "select id, titulo from proyectos where tipo = $tipo order by fecha desc limit 3";
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