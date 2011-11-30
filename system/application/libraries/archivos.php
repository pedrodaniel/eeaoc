<?php
class Archivos
{
	public $file;
	public $path;
	public $tipos;
	public $imageresize;
	
	function __construct()
	{
		
	}
	
	public function subir()
	{
		if($this->file['error'] == 0)
		{
			$extension = strtolower(end(explode(".",$this->file['name'])));
			$tipos_permitidos = explode(",",$this->tipos);
			if (in_array($extension,$tipos_permitidos))
			{
				$nombre = date("YmdHisu").".".$extension;
				$ruta_absoluta = PATH_BASE . $this->path;
				if (!is_dir($ruta_absoluta))
					mkdir($ruta_absoluta);
						
				$info_imagen=getimagesize($this->file['tmp_name']);
				$ancho = $info_imagen[0];
				$alto = $info_imagen[1];
				if ($ancho <= 2048 and $ancho >= 400)
				{
					move_uploaded_file($this->file['tmp_name'],$ruta_absoluta.$nombre);
						
					/*Diferentes tamanios*/
					$dest_size1 = $ruta_absoluta.$nombre;
					$dest_size2= $ruta_absoluta."tam2_".$nombre;
					$dest_size3= $ruta_absoluta."tam3_".$nombre;
					$dest_th = $ruta_absoluta."th_".$nombre;
					/**********************/
					
					//Size 1
					if ($ancho > TAM_1)
					{		
						$this->imageresize->setImage($ruta_absoluta.$nombre);
						$this->imageresize->resizeWidth(TAM_1); // 900
						$this->imageresize->save($dest_size1);
					}
					else
					{
						$this->imageresize->setImage($ruta_absoluta.$nombre);
						$this->imageresize->resizeWidth($ancho); // 900
						$this->imageresize->save($dest_size1);
					}
					
					//Size 2
					$this->imageresize->setImage($ruta_absoluta.$nombre);
					$this->imageresize->resizeWidth(TAM_2); // 400
					$this->imageresize->save($dest_size2);
					
					//Size 3
					$this->imageresize->setImage($ruta_absoluta.$nombre);
					$this->imageresize->resizeWidth(TAM_3); // 200
					$this->imageresize->save($dest_size3);
					
					//Size Th
					$this->imageresize->setImage($ruta_absoluta.$nombre);
					$this->imageresize->resizeWidth(TH); // 80
					$this->imageresize->save($dest_th);
					
					$img = $nombre;
					$error = "";
				}
				else
				{
					$img = "";
					$error = "Tama&ntilde;o de imagen no permitido. Debe tener un ancho m&iacute;nimo de 400 px y m&aacute;mo a 2048 px.";
				}
			}
			else
			{
				$img = "";
				$error = "Formato de archivo no permitido. Los formatos permitidos son <b>jpg, png y gif</b>.";
			}
		}
		else
		{
			$img = "";
			$error = "Error al intentar subir la imagen. Aseg&uacute;rese que su tama&ntilde;o no supere los 2M.";
		}
		
		$return['img'] = $img;
		$return['error'] = $error;
		
		return $return;
	}
}
?>