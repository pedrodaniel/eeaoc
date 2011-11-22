<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function editame(p_id)
	{
		SexyLightbox.display('<?=site_url("admin/usuarios/editar")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
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
	Paginas
	</div>
	<br/>
	<table cellspacing="0" cellpadding="9" width="97%">
	<tbody>
		<tr>
			<th>&nbsp;</th>
			<th>Titulo</th>
			<th>orden</th>
			<th>padre_id</th>
			
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $pagina):?>
			<tr bgcolor="#ffffff">
			<td><?=$pagina['id']?></td>
			<td><?=$pagina['titulo']?></td>
			<td><?=$pagina['orden']?></td>
			<td><?=$pagina['padre_id']?></td>
			</tr>
			<? endforeach; ?>
		<? endif; ?>
	</tbody>
	</table>
	<div class="page-links"></div>
</div>
<? $this->load->view("admin/footer")?>
</body>
</html>