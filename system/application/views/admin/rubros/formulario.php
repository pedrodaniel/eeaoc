<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
		
		 //  $('#descripcion').wysiwyg();
		
		$("#btn_guardar").click(function(){
			
			var validado = true;
			if ($("#nombre").val()=="")
			{
				$("#nombre").css('border-color', 'red');
				$("#nombre").focus();
				validado = false;
			}
			if (validado)
			{
				$("#save_box").hide();
				$("#save_box_waiting").show();
				$("#page_form").submit();
				
			}
			else
			{
				jAlert("Debe ingresar el Nombre del Rubro,","Error");
			}	
			
		});

		
		
	});
	
	function borrar_imagen()
	{	
		$("#galeria").hide();
		$("#loading").show();
		$.post("<?=site_url("admin/rubros/borrar_imagen")?>",
		{
			
			rubro_id: <?=$rubro['id']?>,
			img: "<?=$rubro['imagen']?>"
			
		},function(data){
			switch(data)
			{
				case "ok":
					
				break;
				case "ko":
					jAlert("Error al intentar borrar la imagen. Asegurese estar conectado.","Error");
					$("#loading").hide();
					$("#galeria").show();
				break;
				case "error_permiso":
					jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
					$("#loading").hide();
					$("#galeria").show();
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
		
			<? if ($rubro['id'] > 0):?>
			<img src="<?=site_url("img/admin/page_edit.png")?>" />
			Editar Rubro
		
			<? else:?>
			<img src="<?=site_url("img/admin/page_add.png")?>" />
			Nuevo Rubro
	
			<? endif; ?>
		</div>
		<form id="page_form" method="post" enctype="multipart/form-data" action="<?=site_url("admin/rubros/guardar")?>">
		<br/>
		<? if ($mensaje_error!=""):?>
			<div class="error"><?=$mensaje_error?></div>
		<? endif; ?>
		<? if ($mensaje_ok!=""):?>
			<div class="success"><?=$mensaje_ok?></div>
		<? endif; ?>
		<div style='width: 100%;'>
			<div style='width: 60%; float: left; margin-right: 30px;'>		
				<input name="id" id="id" type="hidden" value="<?=$rubro['id']?>"/>
				<div id="section">Nombre</div>
				<div id="section-detail">
					<input type="text" name="nombre" id="nombre" value="<?=(isset($rubro['nombre']))?$rubro['nombre']:""?>" style="width: 100%;" />
				</div>
				<div id="section">Descripci&oacute;n</div>
				<div id="section-detail">
					<textarea name="descripcion" id='descripcion' rows="20" style='width: 99%;'><?=(isset($rubro['descripcion']))?stripslashes($rubro['descripcion']):""; ?></textarea>
				</div>	
				<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
					<a class="large green awesome" href='javascript:void(0)' id="btn_guardar">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?=site_url("admin/rubros")?>">Cancelar</a>
				</div>
				<div id="save_box_waiting" style="padding: 15px; text-align: right; display: none;">
					<img src="<?=site_url("img/admin/ajax-loader.gif")?>" />
				</div>
		
			</div>
			<div style='float: left; width: 30%;'>
		 		<div id='section'>Cargar Im&aacute;gen</div>
			    <div id="section-detail">				
		   			<b>Imagen:</b> (jpg, png)<br/><br/>
					<input type="file" id="imagen_file" name="imagen" size="30" /> 	
					<div id="galeria"><br/>
					<? if (isset($rubro['imagen']) and $rubro['imagen']):?>
						<div id="section-detail-img" class="imagenes">
							<img src="<?=site_url("upload/rubro/".$rubro['id']."/th_".$rubro['imagen'])?>" />
							<a href="javascript:borrar_imagen(<?=$rubro['id']?>)" title="Eliminar imagen">
							Eliminar
							</a>
							<div id="loading" style="padding: 15px; text-align: right; display: none;">
								<img src="<?=site_url("img/admin/ajax-loader.gif")?>" />
							</div>
						</div>
					<? endif; ?>
					</div>	
				</div>
			</div>
		</div>
		</form>					
	</div>
</div>
<div style='clear: both;'></div>
<? $this->load->view("admin/footer")?>
</body>
</html>