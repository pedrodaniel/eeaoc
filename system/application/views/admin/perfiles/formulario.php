<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_guardar_perfil").click(function(){
			var validado = true;
			if ($("#nombre").val()=="")
			{
				$("#nombre").css('border-color', 'red');
				validado = false;
			}	
			if (validado)
			{
				$.post("<?=site_url("admin/perfiles/valida_nombre")?>",
				{
					nombre: $("#nombre").val(), 
					perfil_id: <?=$perfil['id'] ?>
				},function(data){
					switch(data)
					{
						case "ok":
						$.post("<?=site_url("admin/perfiles/guardar")?>",
						{
							perfil_id: <?=$perfil['id']?>,
							nombre: $("#nombre").val(),
							descripcion: $("#descripcion").val(),
							activo: $("#activo").attr('checked')
						},function(data){
							switch(data)
							{
								case "ok":
								parent.location.reload();
								parent.SexyLightbox.close();
								break;
								case "error_permiso":
									jAlert("No tiene permiso para realizar la operaci&oacute; solicitada.","Error");
								break;
								case "error_db":
									jAlert("Error de conexi&oacute;n. Aseg&uacute;rese estar conectado..","Error");
								break;
							}
						});
						break;
						case "ko":
							jAlert("El nombre de perfil ingresado ya existe","Error");
						break;
					}
				});
			}
			else
				parent.SexyLightbox.shake();
		});
	});
	function cerrar()
	{
		parent.SexyLightbox.close();
	}
	</script>
</head>
<body>	
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="content">
		<div class="head">
			<img src="<?=site_url("img/admin/usuarios.png")?>" />
			<?=($perfil['id']>0)?"Editar":"Nuevo"?> Perfil
		</div>
		<br/>
		<div id="userForm" class="setting">
		<input name="perfil_id" type="hidden" value="<?=$perfil['id']?>"/>
		<div style="width: 450px;">
			<div id="section">Datos</div>
			<table cellpadding="6" border="0">
	  		<tbody>
	  		<tr>
	  			<td>Nombre </td>
	  			<td><input id="nombre" type="text" name="nombre" value="<?=$perfil['perfil']?>"/></td>
	  		</tr>
	  		<tr>
	  			<td>Descripci&oacute;n </td>
	  			<td><textarea id="descripcion" name="descripcion"><?=$perfil['descripcion']?></textarea></td>
	  		</tr>
	  		<tr>
	  			<td>Habilitado </td>
	  			<td><input id="activo" type="checkbox" <?=($perfil['habilitado']==1)?"checked":""?> name="activo" style="width:14px;" /></td>
	  		</tr>
	  		</tbody>
	  		</table>
		</div>
		<button id="btn_guardar_perfil" style="font-size: 14px; padding: 5px;">Guardar</button>
		&nbsp;&nbsp;&nbsp;
		<a href="javascript:cerrar()">Cancelar</a>
		</div>
	</div>
</div>
</body>
</html>