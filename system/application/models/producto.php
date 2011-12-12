<?php
class Producto extends Model
{
	public function listado($busqueda)
	{
		 $sql = "select p.id, p.nombre, p.tipo, p.fecha_carga, u.apellido as usuario_apellido, u.nombre as usuario_nombre,
		 (select nombre from tematica where id = p.tematica_id) as tematica,
		 (select nombre from servicio where id = p.servicio_id) as servicio 
		 from producto p 
		 inner join usuario u on (u.id = p.usuario_id)";
		 
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
	
	public function dameProductos()
	{
		$sql = "select id, nombre from producto order by id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameProducto($producto_id)
	{
		$sql = "select id, nombre, tematica_id, servicio_id, descripcion from producto where id = ".$producto_id;
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
		$sql = "select id, imagen, url, target, producto_id from imagen_producto where id = ".$imagen_id;
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
	
	public function dameImgProducto($producto_id)
	{
		$sql = "select id, imagen, url, target from imagen_producto where producto_id = ".$producto_id;
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
		if ($this->db->insert("producto",$datos))
		{
			$id = $this->db->insert_id();
			return $id;
		}
		else
			return false;
	}
	
	public function insertar_imagen($datos)
	{
		if ($this->db->insert("imagen_producto",$datos))
			return true;
		else
			return false;
	}
	
	public function update($datos,$producto_id)
	{
		$this->db->where("id",$producto_id);
		if ($this->db->update("producto",$datos))
			return true;
		else
			return false;
	}
	
	public function eliminarProducto($producto_id)
	{
		$this->db->where("id",$producto_id);
		if ($this->db->delete("producto"))
		{
			$this->borradoImagenesGeneral($producto_id);
			return true;
		}
		else
			return false;
	}
	
	public function borradoImagenesGeneral($producto_id)
	{
		$sql = "select id, imagen from imagen_producto where producto_id = ".$producto_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			foreach ($res as $img)
			{
				$this->quitarImagen($img['id'],$img['imagen'],$producto_id);
			}
		}
	}
	
	/*public function checkDependencias($producto_id)
	{
		$sql = "select id from tematica where padre_id = ".$producto_id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
			return false;
		else
			return true;
	}*/
	
	public function updateImagen($imagen_id, $datos)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->update("imagen_producto",$datos))
			return true;
		else
			return false;
	}
	
	public function quitarImagen($imagen_id,$img_borrar,$producto_id)
	{
		$this->db->where("id",$imagen_id);
		if ($this->db->delete("imagen_producto"))
		{
			$path_img_borrar = PATH_BASE . "producto/" . $producto_id . "/" . $img_borrar;
			$path_img_borrar2 = PATH_BASE . "producto/" . $producto_id . "/tam2_" . $img_borrar;
			$path_img_borrar3 = PATH_BASE . "producto/" . $producto_id . "/crop_" . $img_borrar;
			$path_img_borrar4 = PATH_BASE . "producto/" . $producto_id . "/th_" . $img_borrar;
							
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
	
	public function dameRubros($producto_id)
	{
		$sql = "select r.id, r.nombre, pr.id as relacion_id from rubro r 
		inner join producto_rubro pr on (pr.rubro_id = r.id) 
		where pr.producto_id = ".$producto_id." order by r.nombre";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function insertarRubro($datos)
	{
		if ($this->db->insert("producto_rubro",$datos))
			return true;
		else
			return false;
	}
	
	public function deleteRubro($relacion_id)
	{
		$this->db->where("id",$relacion_id);
		if ($this->db->delete("producto_rubro"))
			return true;
		else
			return false;
	}
	
/**************************  Para asociar Caracteristicas *************************************/
		
	public function dameCaracteristicas($producto_id)
	{
		$sql = "select c.id, c.nombre, pr.id as relacion_id from caracteristica c 
		inner join producto_caract pr on (pr.caracteristica_id = c.id) 
		where pr.producto_id = ".$producto_id." order by c.nombre";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameCaracteristicaAsociar($producto_id)
	{
		$sql = "select c.id, c.nombre from caracteristica c 
		where c.id not in (select caracteristica_id from producto_caract where producto_id = $producto_id) 
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
		if ($this->db->insert("producto_caract",$datos))
			return true;
		else
			return false;
	}
	
	public function deleteCaracteristicas($relacion_id)
	{
		$this->db->where("id",$relacion_id);
		if ($this->db->delete("producto_caract"))
			return true;
		else
			return false;
	}
	
	/*Metodos usados en el front*/
	
}
?>