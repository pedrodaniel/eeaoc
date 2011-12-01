<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function enviar_form()
	{
		mensaje = "";
		if ($("#nombre").val()=="")
			mensaje += "Ingrese el Nombre del producto\n";
			
		if (mensaje == "")
		{
			$("#save_box").hide();
			$("#save_box_waiting").show();
			$("#productoForm").submit();
		}
		else
			jAlert(mensaje,"Error");
	}
	
	function enviar_form_foto()
	{
		if ($("#producto_id").val() > 0)
		{	
			if ($("#imagen_file").val() != "")
			{
				$("#save_box_img").hide();
				$("#save_box_waiting_img").show();
				$("#productoImageForm").submit();
			}
			else
				jAlert("Debe seleccionar una im&aacute;gen. Los formatos permitidos son JPG, GIF y PNG.","Error");
		}
		else
			jAlert("Debe cargar un nuevo producto para poder adjuntarle im&aacute;genes.","Error");
	}
	
	function edita_img(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/productos/editar_imagen")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
	}
	</script>
</head>
<body>	
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>	
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="content">
		<div class="head">
			<? if ($producto['id'] > 0):?>
			<img src="<?=site_url("img/admin/page_edit.png")?>" />
			Editar Producto
			<? else:?>
			<img src="<?=site_url("img/admin/page_add.png")?>" />
			Nuevo Producto
			<? endif; ?>
		</div>
		<br/>
		<? if ($mensaje_error!=""):?>
			<div class="error"><?=$mensaje_error?></div>
		<? endif; ?>
		<? if ($mensaje_ok!=""):?>
			<div class="success"><?=$mensaje_ok?></div>
		<? endif; ?>
		<div style="width: 100%;">
			<form id="productoForm" method="post" action="<?=site_url("admin/productos/".$accion)?>">
			<input name="producto_id" id="producto_id" type="hidden" value="<?=$producto['id']?>"/>
			<div style="width: 60%; float: left; margin-right: 30px;">
				<div id="section">Nombre</div>
				<div id="section-detail">
					<input type="text" id="nombre" name="nombre" value="<?=(isset($producto['nombre']))?$producto['nombre']:""?>" style="width: 100%;" />
				</div>
				<div id="section">Tem&aacute;te</div>
				<div id="section-detail">
					<select name="tematica_id" id="tematica_id" style="width:350px; height:25px">
					<option value="0"></option>
		  			<? if ($tematicas):?>
		  				<? foreach ($tematicas as $tem):
		  					$selected = "";
		  					if (isset($producto['tematica_id']) and $tem['id'] == $producto['tematica_id'])
		  						$selected = "selected";
		  				?>
		  				<option value="<?=$tem['id']?>" <?=$selected?>><?=$tem['nombre']?></option>
		  				<? endforeach; ?>
		  			<? endif; ?>
		  			</select>
				</div>
				<div id="section">Servicio</div>
				<div id="section-detail">
					<select name="servicio_id" id="servicio_id" style="width:350px; height:25px">
					<option value="0"></option>
		  			<? if ($servicios):?>
		  				<? foreach ($servicios as $serv):
		  					$selected = "";
		  					if (isset($producto['servicio_id']) and $serv['id'] == $producto['servicio_id'])
		  						$selected = "selected";
		  				?>
		  				<option value="<?=$serv['id']?>" <?=$selected?>><?=$serv['nombre']?></option>
		  				<? endforeach; ?>
		  			<? endif; ?>
		  			</select>
				</div>
				<div id="section">Descripci&oacute;n</div>
				<div id="section-detail">
					<textarea name="descripcion" id='detail' rows="10" style='width: 99%;'><?=(isset($producto['descripcion']))?$producto['descripcion']:""; ?></textarea>
					<div id='wmd-preview-box' style='display: none; margin: 0 auto; position: absolute; top: 100px; border: 10px solid silver; width: 600px; padding: 10px; background-color: #fff;'>
						<div id='wmd-preview' class="wmd-preview" style='width: 500px;'></div>
					</div>
				</div>
				<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
					<a class="large green awesome" href="javascript:enviar_form()">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?=site_url("admin/productos")?>">Cancelar</a>
				</div>
				<div id="save_box_waiting" style="padding: 15px; text-align: right; display: none;">
					<img src="<?=site_url("img/admin/ajax-loader.gif")?>" />
				</div>
			</div>
			</form>
			<form id="productoImageForm" method="post" enctype="multipart/form-data" action="<?=site_url("admin/productos/upload")?>">
			<input name="producto_id" id="producto_id" type="hidden" value="<?=$producto['id']?>"/>
			<div style="float: left; width: 30%;">
				<div id="section">Adjuntar Im&aacute;gen</div>
				<div id="section-detail">
				<b>Link a:</b><br/><br/>
					<input type="text" id="link" name="link" value="" style="width: 100%;" />
				<br/><br/>
				<b>Navegador:</b><br/><br/>
					<select name="target" id="target" style="width:350px; height:25px">
						<option value="1">Interior</option>
						<option value="2">Exterior</option>
					</select>
				<br/><br/>
				<b>Imagen:</b> (jpg, gif, png)<br/><br/>
					<input type="file" id="imagen_file" name="imagen" size="30" />
					<br/><br/>
					<div id="save_box_img" style="padding: 8px; text-align: right;">
						<a class="large green awesome" href="javascript:enviar_form_foto()">Subir</a>
					</div>
					<div id="save_box_waiting_img" style="padding: 8px; text-align: right; display: none;">
						<img src="<?=site_url("img/ajax-loader.gif")?>" />
					</div>
				</div>
				<? if (isset($producto['imagenes']) and $producto['imagenes']):?>
				<div id="section">Im&aacute;genes cargadas</div><br/>
				<div id="section-detail-img" class="imagenes">
				<? foreach ($producto['imagenes'] as $img_tem):?>
					<a href="javascript:edita_img(<?=$img_tem['id']?>)" title="Editar imagen">
					<img src="<?=site_url("upload/producto/".$producto['id']."/th_".$img_tem['imagen'])?>" />&nbsp;&nbsp;
					</a>
				<? endforeach; ?>
				</div>
				<? endif; ?>
			</div>
			</form>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>
<? $this->load->view("admin/footer")?>
</body>
</html>