<?php
class Menu extends Model
{
	function __construct()
	{
		parent::Model();
	}
	
	public function dameMenu($pid,$padre=0)
	{
		$this -> db -> select('m.id, m.accion, m.nombre, m.hijos');
		$this -> db -> from('modulos m');
		$this -> db -> join('permiso pe', 'pe.modulo_id = m.id', 'inner');
		$this -> db -> where("m.menu",1);
		$this -> db -> where("m.padre_id",$padre);  
		$this -> db -> where("pe.perfil_id",$pid); 
		$this -> db -> order_by("m.orden");
		$query = $this -> db -> get();
		if ($query->num_rows() > 0)
		{
			$res = $query->result_array();
			return $res;
		}
		else
			return false;
	}
	
	public function dameHijosAdmin($pid,$mid)
	{
		$this -> db -> select('m.id,m.accion, m.nombre, m.hijos');
		$this -> db -> from('modulos m');
		$this -> db -> join('permiso pe', 'pe.modulo_id = m.id', 'inner');
		$this -> db -> where("m.padre_id",$mid);
		$this -> db -> where("m.menu",1);
		$this -> db -> where("pe.perfil_id",$pid);
		$this -> db -> order_by("m.orden");
		$query = $this -> db -> get();
		if($query -> num_rows() > 0)
		{
			$hijos = "<ul>";
			foreach ($query->result() as $row)
			{
				$hijos .= "<li>".anchor("admin/".$row->accion,$row->nombre)."</li>";
			}
			$hijos .= "</ul>";
			return $hijos;
		}
		else
			return false;
	}
}
?>