<? 
class ProcesarImagen{

	protected $imgrezise;

	/**
	 * Funcion donde se procesan las imagenes, recibe un $_FILE y valida tama;os,
	 * crea cuatro tipo de tama;o de imagens
	 *   
	 * @param $p_file
	 * @param $p_dir directorio dentro de upload
	 */
	public function imgCrea($p_file,$p_dir=''){
		$ruta_absoluta=PATH_BASE.$p_dir;
		$error = "";
		$this->load->library("imageresize");
 		$imgrezise = $this->imageresize;
				if ($p_file['imagen']['name']!="")
				{
					if($p_file['imagen']['error'] == 0)
					{
						$extension = strtolower(end(explode(".",$p_file['imagen']['name'])));
						if ($extension == "jpg" or $extension == "png" or $extension == "gif" or $extension == "jpeg")
						{
							$nombre = date("YmdHisu").".".$extension;
							
							$info_imagen=getimagesize($p_file['imagen']['tmp_name']);
							$ancho = $info_imagen[0];
							$alto = $info_imagen[1];
							if ($ancho <= 2048 and $ancho >= 400)
							{
								move_uploaded_file($p_file['imagen']['tmp_name'],$ruta_absoluta.$nombre);
								
								/*Diferentes tamanios*/
								$dest_size1 = $ruta_absoluta.$nombre;
								$dest_size2= $ruta_absoluta."tam2_".$nombre;
								$dest_size3= $ruta_absoluta."tam3_".$nombre;
								$dest_th = $ruta_absoluta."th_".$nombre;
								/**********************/
								
								
								
								//Size 1
								if ($ancho > TAM_1)
								{		
									$this->imgrezise->setImage($ruta_absoluta.$nombre);
									$this->imgrezise->resizeWidth(TAM_1); // 900
									$this->imgrezise->save($dest_size1);
								}
								else
								{
									$this->imgrezise->setImage($ruta_absoluta.$nombre);
									$this->imgrezise->resizeWidth($ancho); // 900
									$this->imgrezise->save($dest_size1);
								}
								
								//Size 2
								$this->imgrezise->setImage($ruta_absoluta.$nombre);
								$this->imgrezise->resizeWidth(TAM_2); // 900
								$this->imgrezise->save($dest_size2);
								
								//Size 3
								$this->imgrezise->setImage($ruta_absoluta.$nombre);
								$this->imgrezise->resizeWidth(TAM_3); // 900
								$this->imgrezise->save($dest_size3);
								
								//Size Th
								$this->imgrezise->setImage($ruta_absoluta.$nombre);
								$this->imgrezise->resizeWidth(TH); // 900
								$this->imgrezise->save($dest_th);
								
								$return['tipo']=1;
								$return['valor']=$nombre;
								return $return;
							}
							else
								$error = "Tama&ntilde;o de imagen no permitido. Debe tener un ancho m&iacute;nimo de 400 px y m&aacute;mo a 2048 px.";
						}
						else
							$error = "Formato de archivo no permitido. Los formatos permitidos son <b>jpg, png y gif</b>.";
					}
					else
					{
						$error = "Error al intentar subir la imagen. Aseg&uacute;rese que su tama&ntilde;o no supere los 2M.";
					}
				}
			$return['tipo']=0;
			$return['valor']=$error;
			return $return;
	}



}