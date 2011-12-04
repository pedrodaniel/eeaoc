<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function buscar()
	{
		window.location="<?=site_url("admin/noticias/index")?>/"+$("#search").val();
	}
	
	function destacar(n_id)
	{
		var v_valor = 0;
		if ($("#habilitado_"+n_id).attr('checked'))
			v_valor = 1;
		$.post("<?=site_url("admin/noticias/destacar")?>",
		{
			noticia_id: n_id,
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
	
	function eliminar(p_id)
	{
		$.post("<?=site_url("admin/noticias/borrar")?>",
		{
			noticia_id: p_id
		},function(data){
			switch(data)
			{
				case "ok":
					location.reload();
				break;
				case "ko":
					jAlert("Error al intentar eliminar la noticia. Asegurese estar conectado.","Error");
				break;
				case "error_permiso":
					jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
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
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/noticias.png")?>" />
	Noticias &nbsp;&nbsp;<span style="font-size:11px"><a href="<?=site_url("admin/noticias/formulario")?>">Nueva</a></span>
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
			<th>T&iacute;tulo</th>
			<th>Tipo</th>
			<th>Fecha Carga</th>
			<th>Usuario</th>
			<th>Destacada</th>
			<th></th>
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $nota):?>
			<tr bgcolor="#ffffff">
			<td><?=$nota['id']?></td>
			<td><a href="<?=site_url("admin/noticias/formulario/".$nota['id'])?>" title="Editar noticia"><?=$nota['titulo']?></a></td>
			<td><? if ($nota['tipo']==1) echo "Institucional"; elseif ($nota['tipo']==2) echo "Cient&iacute;fica"; else echo "Agroindustrial";?></td>
			<td><?=$nota['fecha']?></td>
			<td><?=$nota['usuario_nombre']." ".$nota['usuario_apellido']?></td>
			<td><input id="habilitado_<?=$nota['id']?>" type="checkbox" <?=($nota['destacada']==1)?"checked":""?> name="habilitado" onclick="javascript:destacar(<?=$nota['id']?>)" /></td>
			<td><a href="javascript:eliminar(<?=$nota['id']?>)" title="Eliminar noticia"><img width="25" src="<?=site_url("img/admin/delete.png")?>" /></a></td>
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