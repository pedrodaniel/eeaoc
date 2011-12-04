<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
		 
		$('#contenido').wysiwyg();
		
	});
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
	
	function enviar_form_foto()
	{
		if ($("#tematica_id").val() > 0)
		{	
			if ($("#imagen_file").val() != "")
			{
				$("#save_box_img").hide();
				$("#save_box_waiting_img").show();
				$("#tematicaImageForm").submit();
			}
			else
				jAlert("Debe seleccionar una im&aacute;gen. Los formatos permitidos son JPG, GIF y PNG.","Error");
		}
		else
			jAlert("Debe cargar una nueva temática paras poder adjuntarle im&aacute;genes.","Error");
	}
	
	function edita_img(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/tematicas/editar_imagen")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
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
		<div style="width: 100%;">
			<form id="tematicaForm" method="post" action="<?=site_url("admin/tematicas/".$accion)?>">
			<input name="tematica_id" id="tematica_id" type="hidden" value="<?=$tematica['id']?>"/>
			<div style="width: 60%; float: left; margin-right: 30px;">
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
					<textarea name="descripcion" id='contenido' rows="20" style='width: 99%;'><?=(isset($tematica['descripcion']))?$tematica['descripcion']:""; ?></textarea>
				</div>
				<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
					<a class="large green awesome" href="javascript:enviar_form()">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?=site_url("admin/tematicas")?>">Cancelar</a>
				</div>
				<div id="save_box_waiting" style="padding: 15px; text-align: right; display: none;">
					<img src="<?=site_url("img/admin/ajax-loader.gif")?>" />
				</div>
			</div>
			</form>
			<form id="tematicaImageForm" method="post" enctype="multipart/form-data" action="<?=site_url("admin/tematicas/upload")?>">
			<input name="tematica_id" id="tematica_id" type="hidden" value="<?=$tematica['id']?>"/>
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
				<? if (isset($tematica['imagenes']) and $tematica['imagenes']):?>
				<div id="section">Im&aacute;genes cargadas</div><br/>
				<div id="section-detail-img" class="imagenes">
				<? foreach ($tematica['imagenes'] as $img_tem):?>
					<a href="javascript:edita_img(<?=$img_tem['id']?>)" title="Editar imagen">
					<img src="<?=site_url("upload/tematica/".$tematica['id']."/th_".$img_tem['img'])?>" />&nbsp;&nbsp;
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