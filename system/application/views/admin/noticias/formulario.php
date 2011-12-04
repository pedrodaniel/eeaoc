<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
		 
		//$('#contenido').wysiwyg();
		
	});
	function enviar_form()
	{
		mensaje = "";
		if ($("#titulo").val()=="")
			mensaje += "Ingrese el T&iacute;tulo de la noticia\n";
			
		if ($("#contenido").val()=="")
			mensaje += "Ingrese el Texto de la noticia\n";
			
		if (mensaje == "")
		{
			$("#save_box").hide();
			$("#save_box_waiting").show();
			$("#noticiaForm").submit();
		}
		else
			jAlert(mensaje,"Error");
	}
	
	function enviar_form_foto()
	{
		if ($("#noticia_id").val() > 0)
		{	
			if ($("#imagen_file").val() != "")
			{
				$("#save_box_img").hide();
				$("#save_box_waiting_img").show();
				$("#noticiaImageForm").submit();
			}
			else
				jAlert("Debe seleccionar una im&aacute;gen. Los formatos permitidos son JPG, GIF y PNG.","Error");
		}
		else
			jAlert("Debe cargar una nueva noticia paras poder adjuntarle im&aacute;genes.","Error");
	}
	
	function edita_img(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/noticias/editar_imagen")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
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
			<img src="<?=site_url("img/admin/noticias_editar.png")?>" />
			<?=($noticia['id'] > 0)?"Editar Noticia":"Nueva Noticia"?>
		</div>
		<br/>
		<? if ($mensaje_error!=""):?>
			<div class="error"><?=$mensaje_error?></div>
		<? endif; ?>
		<? if ($mensaje_ok!=""):?>
			<div class="success"><?=$mensaje_ok?></div>
		<? endif; ?>
		<div style="width: 100%;">
			<form id="noticiaForm" method="post" action="<?=site_url("admin/noticias/".$accion)?>">
			<input name="noticia_id" id="noticia_id" type="hidden" value="<?=$noticia['id']?>"/>
			<div style="width: 60%; float: left; margin-right: 30px;">
				<div id="section">T&iacute;tulo</div>
				<div id="section-detail">
					<input type="text" id="titulo" name="titulo" value="<?=(isset($noticia['titulo']))?$noticia['titulo']:""?>" style="width: 100%;" />
				</div>
				<div id="section">Tipo</div>
				<div id="section-detail">
					<select name="tipo" id="tipo" style="width:350px; height:25px">
					<option value="1" <?=(isset($noticia['tipo']) and $noticia['tipo']==1)?"selected":""?>>Institucional</option>
		  			<option value="2" <?=(isset($noticia['tipo']) and $noticia['tipo']==2)?"selected":""?>>Cient&iacute;fica</option>
		  			<option value="3" <?=(isset($noticia['tipo']) and $noticia['tipo']==3)?"selected":""?>>Agroindustrial</option>
		  			</select>
				</div>
				<div id="section">Tem&aacute;tica</div>
				<div id="section-detail">
					<select name="tematica_id" id="tematica_id" style="width:350px; height:25px">
					<option value="0"></option>
		  			<? if ($tematicas):?>
		  				<? foreach ($tematicas as $t):
		  					$selected = "";
		  					if (isset($noticia['tematica_id']) and $t['id'] == $noticia['tematica_id'])
		  						$selected = "selected";
		  				?>
		  				<option value="<?=$t['id']?>" <?=$selected?>><?=$t['nombre']?></option>
		  				<? endforeach; ?>
		  			<? endif; ?>
		  			</select>
				</div>
				<div id="section">Servicio</div>
				<div id="section-detail">
					<select name="servicio_id" id="servicio_id" style="width:350px; height:25px">
					<option value="0"></option>
		  			<? if ($servicios):?>
		  				<? foreach ($servicios as $s):
		  					$selected = "";
		  					if (isset($noticia['servicio_id']) and $s['id'] == $noticia['servicio_id'])
		  						$selected = "selected";
		  				?>
		  				<option value="<?=$s['id']?>" <?=$selected?>><?=$s['nombre']?></option>
		  				<? endforeach; ?>
		  			<? endif; ?>
		  			</select>
				</div>
				<div id="section">Texto</div>
				<div id="section-detail">
					<textarea name="texto" id='contenido' rows="20" style='width: 99%;'><?=(isset($noticia['texto']))?$noticia['texto']:""; ?></textarea>
				</div>
				<div id="section">Destacada</div>
				<div id="section-detail">
					<input type="checkbox" id="destacada" name="destacada" value="1" <?=(isset($noticia['destacada']) and $noticia['destacada']==1)?"checked":""?> />
				</div>
				<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
					<a class="large green awesome" href="javascript:enviar_form()">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?=site_url("admin/noticias")?>">Cancelar</a>
				</div>
				<div id="save_box_waiting" style="padding: 15px; text-align: right; display: none;">
					<img src="<?=site_url("img/admin/ajax-loader.gif")?>" />
				</div>
			</div>
			</form>
			<form id="noticiaImageForm" method="post" enctype="multipart/form-data" action="<?=site_url("admin/noticias/upload")?>">
			<input name="noticia_id" id="noticia_id" type="hidden" value="<?=$noticia['id']?>"/>
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
				<b>Destacada:</b><br/><br/>
					<input type="checkbox" id="destacada" name="destacada" value="1" />
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
				<? if (isset($noticia['imagenes']) and $noticia['imagenes']):?>
				<div id="section">Im&aacute;genes cargadas</div><br/>
				<div id="section-detail-img" class="imagenes">
				<? foreach ($noticia['imagenes'] as $img_tem):?>
					<a href="javascript:edita_img(<?=$img_tem['id']?>)" title="Editar imagen">
					<img src="<?=site_url("upload/noticia/".$noticia['id']."/th_".$img_tem['img'])?>" />&nbsp;&nbsp;
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