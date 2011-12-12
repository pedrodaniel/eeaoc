<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	
	function enviar_form()
	{
		mensaje = "";
		if ($("#titulo").val()=="")
			mensaje += "Ingrese el T&iacute;tulo de la proyecto\n";
			
		if ($("#contenido").val()=="")
			mensaje += "Ingrese el Texto del proyecto\n";
			
		if (mensaje == "")
		{
			$("#save_box").hide();
			$("#save_box_waiting").show();
			$("#proyectoForm").submit();
		}
		else
			jAlert(mensaje,"Error");
	}
	$(document).ready(function(){
	$("#btn_cargar_img").click(function(){
		SexyLightbox.display('<?=site_url("admin/proyectos/imagen/".$proyecto['id'])?>?TB_iframe=true&modal=1&height=300&width=500');
	
	});
	$("#SLB-CloseButton").click(function(){
			$.post('<?=site_url("admin/proyectos/traeGaleria/".$proyecto['id'])?>'
					, function(data){
				  	$('#galeria').html( data);
			 })
		// Función necesaria para cerrar la ventana modal
		//window.parent.SexyLightbox.close();
		// Función necesaria para actualizar la ventana padre
		//window.parent.document.location.reload();
		});
});
		function edita_img(p_id)
		{
			if (p_id > 0)
				SexyLightbox.display('<?=site_url("admin/proyectos/editar_imagen")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
		}
		
		function agregar_caracteristica()
		{
			$.post("<?=site_url("admin/proyectos/agregar_caracteristica")?>",
			{
				proyecto_id: $("#proyecto_id").val(), 
				caracteristica_id: $("#caracteristica_id").val()
			},function(data){
				switch(data)
				{
					case "ok":
						location.reload();
					break;
					case "ko":
						jAlert("Error en la conexi&oacute;n. Aseg&uacute;rese estar conectado a internet.","Error");
					break;
					case "error_permiso":
						jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
					break;
					case "error_metodo":
						jAlert("M&eacute;todo no soportado.","Error");
					break;
				}
			})
		}
		
		function eliminar_caracteristica(p_id)
		{
			$.post("<?=site_url("admin/proyectos/eliminar_caracteristica")?>",
			{
				relacion_id: p_id
			},
			function(data){
				switch(data)
				{
					case "ok":
						location.reload();
					break;
					case "ko":
						jAlert("Error en la conexi&oacute;n. Aseg&uacute;rese estar conectado a internet.","Error");
					break;
					case "error_permiso":
						jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
					break;
					case "error_metodo":
						jAlert("M&eacute;todo no soportado.","Error");
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
			<img src="<?=site_url("img/admin/folder_process.png")?>" />
			<?=($proyecto['id'] > 0)?"Editar Proyecto":"Nuevo Proyecto"?>
		</div>
		<br/>
		<? if ($mensaje_error!=""):?>
			<div class="error"><?=$mensaje_error?></div>
		<? endif; ?>
		<? if ($mensaje_ok!=""):?>
			<div class="success"><?=$mensaje_ok?></div>
		<? endif; ?>
		<div style="width: 100%;">
			<form id="proyectoForm" method="post" action="<?=site_url("admin/proyectos/".$accion)?>">
			<input name="proyecto_id" id="proyecto_id" type="hidden" value="<?=$proyecto['id']?>"/>
			<div style="width: 60%; float: left; margin-right: 30px;">
				<div id="section">T&iacute;tulo</div>
				<div id="section-detail">
					<input type="text" id="titulo" name="titulo" value="<?=(isset($proyecto['titulo']))?$proyecto['titulo']:""?>" style="width: 100%;" />
				</div>
				
				
				<div id="section">Texto</div>
				<div id="section-detail">
					<textarea name="texto" id='contenido' rows="20" style='width: 99%;'><?=(isset($proyecto['texto']))?$proyecto['texto']:""; ?></textarea>
				</div>
				<div id="section">Destacada</div>
				<div id="section-detail">
					<input type="checkbox" id="destacada" name="destacada" value="1" <?=(isset($proyecto['destacada']) and $proyecto['destacada']==1)?"checked":""?> />
				</div>
				<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
					<a class="large green awesome" href="javascript:enviar_form()">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?=site_url("admin/noticias")?>">Cancelar</a>
				</div>
				<div id="save_box_waiting" style="padding: 15px; text-align: right; display: none;">
					<img src="<?=site_url("img/admin/ajax-loader.gif")?>" />
				</div>
			</div>
		
			
			<input name="proyecto_id" id="proyecto_id" type="hidden" value="<?=$proyecto['id']?>"/>
			<div style="float: left; width: 30%;">
			<div id="section">Tipo</div>
				<div id="section-detail">
					<select name="tipo" id="tipo" style="width:350px; height:25px">
					<option value="1" <?=(isset($proyecto['tipo']) and $proyecto['tipo']==1)?"selected":""?>>Proyecto</option>
		  			<option value="2" <?=(isset($proyecto['tipo']) and $proyecto['tipo']==2)?"selected":""?>>Programa</option>
		  			
		  			</select>
				</div>
				<div id="section">Tem&aacute;tica</div>
				<div id="section-detail">
					<select name="tematica_id" id="tematica_id" style="width:350px; height:25px">
					<option value="0"></option>
		  			<? if ($tematicas):?>
		  				<? foreach ($tematicas as $t):
		  					$selected = "";
		  					if (isset($proyecto['tematica_id']) and $t['id'] == $proyecto['tematica_id'])
		  						$selected = "selected";
		  				?>
		  				<option value="<?=$t['id']?>" <?=$selected?>><?=$t['nombre']?></option>
		  				<? endforeach; ?>
		  			<? endif; ?>
		  			</select>
				</div>
					<div id="section">Caracteristica</div>
				<div id="section-detail">
					<select name="caracteristica_id" id="caracteristica_id" style="width:350px; height:25px">
					<option value="0"></option>
		  			<? if ($caracteristicas):?>
		  				<? foreach ($caracteristicas as $c):?>
		  				<option value="<?=$c['id']?>" <?=$selected?>><?=$c['nombre']?></option>
		  				<? endforeach; ?>
		  			<? endif; ?>
		  			</select>
		  				<div id="btn_caract" style="padding: 8px; text-align: right;">
						<a class="small awesome" href="javascript:agregar_caracteristica()">Agregar</a>
						</div>
			
	
		<? if ($proyecto_caracteristicas):?>
			<? foreach ($proyecto_caracteristicas as $cp):?>
			<div style='border-bottom: 1px solid #ddd; padding: 5px;'></div><br/>		
			<?=$cp['id']?> - <?=$cp['nombre']?>
			<a href="javascript:eliminar_caracteristica(<?=$cp['relacion_id']?>)" title="Eliminar Caracteristica">
			<img style="vertical-align: middle;" src="<?=site_url("img/admin/cross.png")?>" width="25" /></a>
			
			<? endforeach; ?>
		<? endif; ?>
			
	</div>
					<? if ($proyecto['id'] > 0):?>
				<div id='section'>Cargar Im&aacute;gen </div>
					<div id="section-detail">	
			
					<a class="large green awesome" href='javascript:void(0)' id="btn_cargar_img">Cargar Imagen</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<div id="galeria">
						<? if (isset($proyecto['imagenes']) and $proyecto['imagenes']):?>
						<div id="section-detail-img" class="imagenes">
						<? foreach ($proyecto['imagenes'] as $img_tem):?>
						<a href="javascript:edita_img(<?=$img_tem['id']?>)" title="Editar imagen">
						<img src="<?=site_url("upload/proyecto/".$proyecto['id']."/th_".$img_tem['img'])?>" />&nbsp;&nbsp;
						</a>
						<? endforeach; ?>
						</div>
						<? endif; ?>
					</div>
					
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