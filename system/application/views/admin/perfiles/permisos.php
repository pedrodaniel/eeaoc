<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function agregar_permiso()
	{
		$.post("<?=site_url("admin/perfiles/agregar_permiso")?>",
		{
			perfil_id: $("#perfil_id").val(), 
			modulo_id: $("#modulo").val()
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
	
	function mod_permiso(p_id,p_accion)
	{
		var v_valor = 0;
		if ($("#"+p_accion+"_"+p_id).attr('checked'))
			v_valor = 1;
		$.post("<?=site_url("admin/perfiles/modificar_permiso")?>",
		{
			permiso_id: p_id,
			valor: v_valor,
			accion: p_accion
		},
		function(data){
			switch(data)
			{
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
	
	function eliminar_permiso(p_id)
	{
		$.post("<?=site_url("admin/perfiles/eliminar_permiso")?>",
		{
			permiso_id: p_id
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
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="head">
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/clave.png")?>" />
	Permisos
	</div>
	<? if ($modulos):?>
	<br/>
	<select name="modulo" id="modulo">
		<? foreach ($modulos as $mod):?>
		<option value="<?=$mod['id']?>"><?=$mod['nombre']?></option>
		<? endforeach; ?>
	</select>&nbsp;&nbsp;<a href="javascript:agregar_permiso()">Agregar</a>
	<br/>
	<? endif; ?>
	<br/>
	<table cellspacing="0" cellpadding="9" width="97%">
	<tbody>
		<tr>
			<th>M&oacute;dulo</th>
			<th>Listado</th>
			<th>Alta</th>
			<th>Modificaci&oacute;n</th>
			<th>Baja</th>
			<th></th>
		</tr>
		<? if ($permisos):?>
			<? foreach ($permisos as $p):
				$list = ($p['Listado'])?"checked":"";
				$alta = ($p['Alta'])?"checked":"";
				$mod = ($p['Modificacion'])?"checked":"";
				$baja = ($p['Baja'])?"checked":"";
			?>
			<tr bgcolor="#ffffff">
			<td><?=$p['nombre']?></td>
			<td style="text-align:center"><input type="checkbox" value="1" name="listado" id="Listado_<?=$p['id']?>" <?=$list?> onclick="javascript:mod_permiso(<?=$p['id']?>,'Listado')" /></td>
			<td style="text-align:center"><input type="checkbox" value="1" name="alta" id="Alta_<?=$p['id']?>" <?=$alta?> onclick="javascript:mod_permiso(<?=$p['id']?>,'Alta')" /></td>
			<td style="text-align:center"><input type="checkbox" value="1" name="mod" id="Modificacion_<?=$p['id']?>" <?=$mod?> onclick="javascript:mod_permiso(<?=$p['id']?>,'Modificacion')" /></td>
			<td style="text-align:center"><input type="checkbox" value="1" name="baja" id="Baja_<?=$p['id']?>" <?=$baja?> onclick="javascript:mod_permiso(<?=$p['id']?>,'Baja')" /></td>
			<td><a href="javascript:eliminar_permiso(<?=$p['id']?>)" title="Eliminar permiso"><img style="vertical-align: middle;" src="<?=site_url("img/admin/delete.png")?>" width="25" /></a></td>
			</tr>
			<? endforeach; ?>
		<? endif; ?>
	</tbody>
	</table>
	<input name="perfil_id" type="hidden" value="<?=$perfil_id?>" id="perfil_id"/>
	<div class="page-links"></div>
</div>
</body>
</html>