<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function buscar()
	{
		window.location="<?=site_url("admin/productos/index")?>/"+$("#search").val();
	}
	
	function eliminar(p_id)
	{
		$.post("<?=site_url("admin/productos/borrar")?>",
		{
			producto_id: p_id
		},function(data){
			switch(data)
			{
				case "ok":
					location.reload();
				break;
				case "ko":
					jAlert("Error al intentar modificar la imagen. Asegurese estar conectado.","Error");
				break;
				case "error_dependencias":
					jAlert("Imposible eliminar el producto seleccionado, antes debe eliminar todas sus dependencias.","Error");
				break;
				case "error_permiso":
					jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
				break;
			}
		});
	}
	
	function rubros(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/productos/rubros")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
	}
	</script>
</head>
<body>
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>		
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="head">
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/page.png")?>" />
	Productos &nbsp;&nbsp;<span style="font-size:11px"><a href="<?=site_url("admin/productos/formulario")?>">Nueva</a></span>
		<div class="setting" style="float:right">
		<input type="text" id="search" name="search" value="<?=$search?>" style="width:200px" />&nbsp;<button onclick="javascript:buscar()">Buscar</button>
		</div>
	</div>
	<? if ($mensaje_ok!=""):?>
		<div class="success"><?=$mensaje_ok?></div>
	<? endif; ?>
	<br/>
	<table cellspacing="0" cellpadding="9" width="97%">
	<tbody>
		<tr>
			<th>&nbsp;</th>
			<th>Nombre</th>
			<th>Tem&aacute;tica</th>
			<th>Servicio</th>
			<th>Fecha Carga</th>
			<th>Usuario</th>
			<th width="80"></th>
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $prod):?>
			<tr bgcolor="#ffffff">
			<td><?=$prod['id']?></td>
			<td><a href="<?=site_url("admin/productos/formulario/".$prod['id'])?>" title="Editar producto"><?=$prod['nombre']?></a></td>
			<td><?=$prod['tematica']?></td>
			<td><?=$prod['servicio']?></td>
			<td><?=$prod['fecha_carga']?></td>
			<td><?=$prod['usuario_nombre']." ".$prod['usuario_apellido']?></td>
			<td align="center"><a href="javascript:rubros(<?=$prod['id']?>)" title="Asociar rubro" ><img width="25" src="<?=site_url("img/admin/link_add.png")?>" /></a>&nbsp;&nbsp;
			<a href="javascript:eliminar(<?=$prod['id']?>)" title="Eliminar producto"><img width="25" src="<?=site_url("img/admin/delete.png")?>" /></a></td>
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