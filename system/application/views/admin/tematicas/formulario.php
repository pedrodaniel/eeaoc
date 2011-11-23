<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function enviar_form()
	{
		mensaje = "";
		if ($("#nombre").val()=="")
			mensaje += "Ingrese el Nombre de la tem&aacute;tica\n";
			
		if (mensaje == "")
		{
			$("#save_box").hide();
			$("#save_box_waiting").show();
			$("#tematicaForm").submit();
		}
		else
			jAlert(mensaje,"Error");
	}
	
	function quitar_imagen()
	{
		$.post("<?=site_url("admin/tematicas/borrar_imagen")?>",
		{
			id: $("#tematica_id").val(), 
			img: $("#imagen_actual").val()
		},function(data)
		{
			switch(data)
			{
				case "1":
					$("#section-detail-img").hide();
				break;
				case "2":
					jAlert("Usted no tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
				break;
				default:
					jAlert("Error de conexi&oacute;n.","Error");
				break;
			}
		});
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
			<? if ($tematica['id'] > 0):?>
			<img src="<?=site_url("img/admin/page_edit.png")?>" />
			Editar Tem&aacute;tica
			<? else:?>
			<img src="<?=site_url("img/admin/page_add.png")?>" />
			Nueva Tem&aacute;tica
			<? endif; ?>
		</div>
		<br/>
		<? if ($mensaje_error!=""):?>
			<div class="error"><?=$mensaje_error?></div>
		<? endif; ?>
		<? if ($mensaje_ok!=""):?>
			<div class="success"><?=$mensaje_ok?></div>
		<? endif; ?>
		<form id="tematicaForm" method="post" enctype="multipart/form-data" action="<?=site_url("admin/tematicas/".$accion)?>">
		<input name="tematica_id" id="tematica_id" type="hidden" value="<?=$tematica['id']?>"/>
		<div style="width: 100%;">
			<div id="section">Nombre</div>
			<div id="section-detail">
				<input type="text" id="nombre" name="nombre" value="<?=(isset($tematica['nombre']))?$tematica['nombre']:""?>" style="width: 100%;" />
			</div>
			<div id="section">Padre</div>
			<div id="section-detail">
				<select name="padre_id" id="padre_id" style="width:350px; height:25px">
				<option value="0"></option>
	  			<? if ($padres):?>
	  				<? foreach ($padres as $p):
	  					$selected = "";
	  					if (isset($tematica['padre_id']) and $p['id'] == $tematica['padre_id'])
	  						$selected = "selected";
	  				?>
	  				<option value="<?=$p['id']?>" <?=$selected?>><?=$p['nombre']?></option>
	  				<? endforeach; ?>
	  			<? endif; ?>
	  			</select>
			</div>
			<div id="section">Descripci&oacute;n</div>
			<div id="section-detail">
				<textarea name="descripcion" id='detail' rows="10" style='width: 99%;'><?=(isset($tematica['descripcion']))?$tematica['descripcion']:""; ?></textarea>
				<div id='wmd-preview-box' style='display: none; margin: 0 auto; position: absolute; top: 100px; border: 10px solid silver; width: 600px; padding: 10px; background-color: #fff;'>
					<div id='wmd-preview' class="wmd-preview" style='width: 500px;'></div>
				</div>
			</div>
			<div id="section">Im&aacute;gen</div>
			<div id="section-detail">
				<input type="file" name="imagen" size="40" />
			</div>
			<? if (isset($tematica['imagen']) and $tematica['imagen']!=""):?>
			<div id="section-detail-img">
				<img src="<?=site_url("upload/tematica/tam3_".$tematica['imagen'])?>" />&nbsp;&nbsp;
				<a href="javascript:quitar_imagen()">Eliminar imagen</a>
				<input type="hidden" value="<?=$tematica['imagen']?>" name="imagen_actual" />
			</div>
			<? endif; ?>
			<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
				<a class="large green awesome" href="javascript:enviar_form()">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="<?=site_url("admin/tematicas")?>">Cancelar</a>
			</div>
			<div id="save_box_waiting" style="padding: 15px; text-align: right; display: none;">
				<img src="<?=site_url("img/admin/ajax-loader.gif")?>" />
			</div>
		</div>
		</form>
	</div>
</div>
<? $this->load->view("admin/footer")?>
</body>
</html>