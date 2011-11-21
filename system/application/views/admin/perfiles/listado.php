<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function edita_perfil(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/perfiles/editar")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
		else
			SexyLightbox.display('<?=site_url("admin/perfiles/nuevo")?>?TB_iframe=true&modal=1&height=400&width=500');
	}
	
	function edita_permiso(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/perfiles/permisos")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
	}
</script>
</head>
<body>
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>		
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="head">
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/usuarios.png")?>" />
	Perfiles &nbsp;&nbsp;<span style="font-size:11px"><a href="javascript:edita_perfil(0)">Nuevo</a></span>
	</div>
	<br/>
	<table cellspacing="0" cellpadding="9" width="97%">
	<tbody>
		<tr>
			<th>&nbsp;</th>
			<th>Nombre</th>
			<th>Descripci&oacute;n</th>
			<th>Habilitado</th>
			<th>Permisos</th>
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $perfil):?>
			<tr bgcolor="#ffffff">
			<td><?=$perfil['id']?></td>
			<td><a href="javascript:edita_perfil(<?=$perfil['id']?>)" title="Editar perdil"><?=$perfil['perfil']?></a></td>
			<td><?=$perfil['descripcion']?></td>
			<td><?=($perfil['habilitado'])?"SI":"NO"?></td>
			<td><a href="javascript:edita_permiso(<?=$perfil['id']?>)" title="Editar permisos"><img src="<?=site_url("img/admin/clave.png")?>" width="20" /></a></td>
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