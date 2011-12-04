<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function agregar_rubro()
	{
		$.post("<?=site_url("admin/productos/agregar_rubro")?>",
		{
			producto_id: $("#producto_id").val(), 
			rubro_id: $("#rubro").val()
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
	
	function eliminar_rubro(p_id)
	{
		$.post("<?=site_url("admin/productos/eliminar_rubro")?>",
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
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="head">
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/link.png")?>" />
	Rubros
	</div>
	<? if ($rubros):?>
	<br/>
	<select name="rubro" id="rubro">
		<? foreach ($rubros as $rub):?>
		<option value="<?=$rub['id']?>"><?=$rub['nombre']?></option>
		<? endforeach; ?>
	</select>&nbsp;&nbsp;<a href="javascript:agregar_rubro()">Agregar</a>
	<br/>
	<? endif; ?>
	<br/>
	<table cellspacing="0" cellpadding="9" width="97%">
	<tbody>
		<tr>
			<th>ID</th>
			<th>Rubro</th>
			<th></th>
		</tr>
		<? if ($rubros_productos):?>
			<? foreach ($rubros_productos as $rp):?>
			<tr bgcolor="#ffffff">
			<td><?=$rp['id']?></td>
			<td><?=$rp['nombre']?></td>
			<td><a href="javascript:eliminar_rubro(<?=$rp['relacion_id']?>)" title="Eliminar rubro"><img style="vertical-align: middle;" src="<?=site_url("img/admin/delete.png")?>" width="25" /></a></td>
			</tr>
			<? endforeach; ?>
		<? endif; ?>
	</tbody>
	</table>
	<input name="producto_id" type="hidden" value="<?=$producto_id?>" id="producto_id"/>
	<div class="page-links"></div>
</div>
</body>
</html>