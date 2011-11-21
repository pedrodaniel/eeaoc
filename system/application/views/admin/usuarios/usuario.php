<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function buscar()
	{
		window.location="<?=site_url("admin/usuarios/index")?>/"+$("#search").val();
	}
	function habilitar(u_id)
	{
		var v_valor = 0;
		if ($("#habilitado_"+u_id).attr('checked'))
			v_valor = 1;
		$.post("<?=site_url("admin/usuarios/modificar_estado")?>",
		{
			usuario_id: u_id,
			valor: v_valor
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
	</script>
</head>
<body>
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>		
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="head">
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/user.png")?>" />
	Usuarios &nbsp;&nbsp;<span style="font-size:11px"><a href="javascript:editame(0)">Nuevo</a></span>
		<div class="setting" style="float:right">
		<input type="text" id="search" name="search" value="<?=$search?>" style="width:200px" />&nbsp;<button onclick="javascript:buscar()">Buscar</button>
		</div>
	</div>
	<br/>
	<table cellspacing="0" cellpadding="9" width="97%">
	<tbody>
		<tr>
			<th>&nbsp;</th>
			<th>Nombre</th>
			<th>Email</th>
			<th>Perfil</th>
			<th>Habilitado</th>
			<th>Ultimo Acceso</th>
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $usuario):?>
			<tr bgcolor="#ffffff">
			<td><?=$usuario['id']?></td>
			<td><a href="javascript:editame(<?=$usuario['id']?>)" title="Editar usuario"><?=$usuario['nombre']." ".$usuario['apellido']?></a></td>
			<td><?=$usuario['email']?></td>
			<td><?=$usuario['perfil']?></td>
			<td><input id="habilitado_<?=$usuario['id']?>" type="checkbox" <?=($usuario['habilitado']==1)?"checked":""?> name="habilitado" onclick="javascript:habilitar(<?=$usuario['id']?>)" /></td>
			<td><?=$usuario['ultimo_acceso']?></td>
			</tr>
			<? endforeach; ?>
		<? endif; ?>
	</tbody>
	</table>
	<div class="page-links"></div>
</div>
<? //$this->load->view("admin/footer")?>
</body>
</html>