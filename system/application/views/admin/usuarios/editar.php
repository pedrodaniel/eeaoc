<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_guardar").click(function(){
			var validado = true;
			if ($("#apellido").val()=="")
			{
				$("#apellido").css('border-color', 'red');
				validado = false;
			}
			if ($("#nombre").val()=="")
			{
				$("#nombre").css('border-color', 'red');
				validado = false;
			}
			if ($("#email").val()=="")
			{
				$("#email").css('border-color', 'red');
				validado = false;
			}
			
			if ($("#usuario_id").val()==0)
			{
				if ($("#pass").val()=="")
				{
					$("#pass").css('border-color', 'red');
					validado = false;
				}			
			}
				
			if (validado)
			{
				$.post("<?=site_url("admin/usuarios/valida_email")?>",
				{
					email: $("#email").val(), 
					usuario_id: <?=$usuario['id'] ?>
				},function(data){
					switch(data)
					{
						case "ok":
						$.post("<?=site_url("admin/usuarios/guardar")?>",
						{
							usuario_id: <?=$usuario['id']?>,
							apellido: $("#apellido").val(),
							nombre: $("#nombre").val(),
							email: $("#email").val(),
							pass: $("#pass").val(),
							perfil: $("#perfil").val(),
							activo: $("#activo").attr('checked')
						},function(data){
							switch(data)
							{
								case "ok":
								<? if ($user['id']==$usuario['id']):?>
								parent.SexyLightbox.close();
								parent.location = "<?=site_url("admin/salir")?>";
								<? else:?>
								parent.location.reload();
								parent.SexyLightbox.close();
								<? endif; ?>
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
							jAlert("La cuenta de correo ingresada ya existe","Error");
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
			<? if ($usuario['id'] > 0):?>
			<img src="<?=site_url("img/admin/user_edit.png")?>" />
			Editar Usuario
			<? else:?>
			<img src="<?=site_url("img/admin/user_add.png")?>" />
			Nuevo Usuario
			<? endif; ?>
		</div>
		<br/>
		<div id="userForm" class="setting">
		<input name="usuario_id" id="usuario_id" type="hidden" value="<?=$usuario['id']?>"/>
		<div style="width: 450px;">
			<div id="section">Datos</div>
			<table cellpadding="6" border="0">
	  		<tbody>
	  		<? if ($user['id']==$usuario['id']):?>
	  		<tr>
	  			<td colspan="2">Est&aacute; por modificar informaci&oacute;n de su cuenta. Cuando guarde la misma su sesi&oacute;n se cerrar&aacute;.</td>
	  		</tr>
	  		<? endif;?>
	  		<tr>
	  			<td>Apellido </td>
	  			<td><input id="apellido" type="text" name="apellido" value="<?=$usuario['apellido']?>" /></td>
	  		</tr>
	  		<tr>
	  			<td>Nombre </td>
	  			<td><input id="nombre" type="text" name="nombre" value="<?=$usuario['nombre']?>"/></td>
	  		</tr>
	  		<tr>
	  			<td>Email </td>
	  			<td><input id="email" type="text" name="email" value="<?=$usuario['email']?>" /></td>
	  		</tr>
	  		<tr>
	  			<td>Password </td>
	  			<td><input id="pass" type="password" name="pass" value=""/></td>
	  		</tr>
	  		<? 
	  		$disabled = "disabled";
	  		if ($permiso)
	  			$disabled = "";
	  		?>
	  		<tr>
	  			<td>Perfil </td>
	  			<td><select name="perfil" id="perfil" <?=$disabled?>>
	  			<? if ($perfiles):?>
	  				<? foreach ($perfiles as $perf):
	  					$selected = "";
	  					if ($perf['id'] == $usuario['perfil_id'])
	  						$selected = "selected";
	  				?>
	  				<option value="<?=$perf['id']?>" <?=$selected?>><?=$perf['perfil']?></option>
	  				<? endforeach; ?>
	  			<? endif; ?>
	  			</select></td>
	  		</tr>
	  		<tr>
	  			<td>Habilitado </td>
	  			<td><input id="activo" type="checkbox" <?=($usuario['habilitado']==1)?"checked":""?> name="activo" style="width: 14px;"  <?=$disabled?>/></td>
	  		</tr>
	  		</tbody>
	  		</table>
		</div>
		<button id="btn_guardar" style="font-size: 14px; padding: 5px;">Guardar</button>
		&nbsp;&nbsp;&nbsp;
		<a href="javascript:cerrar()">Cancelar</a>
		</div>
	</div>
</div>
</body>
</html>