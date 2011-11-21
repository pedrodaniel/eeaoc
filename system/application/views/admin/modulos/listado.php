<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function edita_modulo(m_id)
	{
		if (m_id > 0)
			SexyLightbox.display('<?=site_url("admin/modulos/editar")?>/'+m_id+'?TB_iframe=true&modal=1&height=400&width=500');
		else
			SexyLightbox.display('<?=site_url("admin/modulos/nuevo")?>?TB_iframe=true&modal=1&height=400&width=500');
	}
	function buscar()
	{
		window.location="<?=site_url("admin/modulos/index")?>/"+$("#search").val();
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
	M&oacute;dulos &nbsp;&nbsp;<span style="font-size:11px"><a href="javascript:edita_modulo(0)">Nuevo</a></span>
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
			<th>Acci&oacute;n</th>
			<th>Orden</th>
			<th>Padre</th>
			<th>Visible en Men&uacute;</th>
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $modulo):?>
			<tr bgcolor="#ffffff">
			<td><?=$modulo['id']?></td>
			<td><a href="javascript:edita_modulo(<?=$modulo['id']?>)" title="Editar modulo"><?=$modulo['nombre']?></a></td>
			<td><?=$modulo['accion']?></td>
			<td><?=$modulo['orden']?></td>
			<td><?=$modulo['modulo_padre']?></td>
			<td><?=($modulo['menu'])?"SI":"NO"?></td>
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