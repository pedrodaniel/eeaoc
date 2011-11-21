<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_guardar").click(function(){
			var validado = true;
			if ($("#nombre").val()=="")
			{
				$("#nombre").css('border-color', 'red');
				validado = false;
			}
			if ($("#accion").val()=="")
			{
				$("#accion").css('border-color', 'red');
				validado = false;
			}
				
			if (validado)
			{
				$.post("<?=site_url("admin/modulos/valida_nombre")?>",
				{
					nombre: $("#nombre").val(), 
					modulo_id: <?=$modulo['id'] ?>
				},function(data){
					switch(data)
					{
						case "ok":
						$.post("<?=site_url("admin/modulos/guardar")?>",
						{
							modulo_id: <?=$modulo['id']?>,
							nombre: $("#nombre").val(),
							accion: $("#accion").val(),
							padre: $("#padre").val(),
							orden: $("#orden").val(),
							menu: $("#menu").attr('checked')
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
									jAlert("Error de conexi&oacute;n. Aseg&uacute;rese estar conectado.","Error");
								break;
							}
						});
						break;
						case "ko":
							jAlert("El nombre de m&oacute;dulo ingresado ya existe y debe ser &uacute;nico","Error");
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
			<? if ($modulo['id'] > 0):?>
			<img src="<?=site_url("img/admin/user_edit.png")?>" />
			Editar M&oacute;dulo
			<? else:?>
			<img src="<?=site_url("img/admin/user_add.png")?>" />
			Nuevo M&oacute;dulo
			<? endif; ?>
		</div>
		<br/>
		<div id="userForm" class="setting">
		<input name="modulo_id" id="usuario_id" type="hidden" value="<?=$modulo['id']?>"/>
		<div style="width: 450px;">
			<div id="section">Datos</div>
			<table cellpadding="6" border="0">
	  		<tbody>
	  		<tr>
	  			<td>Nombre </td>
	  			<td><input id="nombre" type="text" name="nombre" value="<?=$modulo['nombre']?>"/></td>
	  		</tr>
	  		<tr>
	  			<td>Acci&oacute;n </td>
	  			<td><input id="accion" type="text" name="accion" value="<?=$modulo['accion']?>" /></td>
	  		</tr>
	  		<tr>
	  			<td>Orden </td>
	  			<td><input id="orden" type="text" name="orden" value="<?=$modulo['orden']?>"/></td>
	  		</tr>
	  		<tr>
	  			<td>Padre </td>
	  			<td><select name="padre" id="padre" >
	  				<option value="0"></option>
	  			<? if ($padres):?>
	  				<? foreach ($padres as $pid):
	  					$selected = "";
	  					if ($pid['id'] == $modulo['padre_id'])
	  						$selected = "selected";
	  				?>
	  				<option value="<?=$pid['id']?>" <?=$selected?>><?=$pid['nombre']?></option>
	  				<? endforeach; ?>
	  			<? endif; ?>
	  			</select></td>
	  		</tr>
	  		<tr>
	  			<td>Visible Men&uacute; </td>
	  			<td><input id="menu" type="checkbox" <?=($modulo['menu']==1)?"checked":""?> name="menu" style="width: 14px;" /></td>
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