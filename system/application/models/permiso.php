<?php
class Permiso extends Model
{
	public function check($perfil_id, $modulo_id)
	{
		$this->db->select("Alta, Baja, Modificacion, Listado");
		$this->db->from("permiso");
		$this->db->where("perfil_id",$perfil_id);
		$this->db->where("modulo_id",$modulo_id);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res[0];
		}
		else
			return false;
	}
	
	public function insertar($datos)
	{
		if ($this->db->insert("permiso",$datos))
			return true;
		else
			return false;
	}
	
	public function update($permiso_id, $datos)
	{
		$this->db->where("id",$permiso_id);
		if ($this->db->update("permiso",$datos))
			return true;
		else
			return false;
	}
	
	public function delete($permiso_id)
	{
		$this->db->where("id",$permiso_id);
		if ($this->db->delete("permiso"))
			return true;
		else
			return false;
	}
}
?>