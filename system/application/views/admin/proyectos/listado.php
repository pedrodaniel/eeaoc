<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function buscar()
	{
		window.location="<?=site_url("admin/proyectos/index")?>/"+$("#search").val();
	}
	
	function destacar(n_id)
	{
		var v_valor = 0;
		if ($("#destacada_"+n_id).attr('checked'))
			v_valor = 1;
		$.post("<?=site_url("admin/proyectos/destacar")?>",
		{
			proyecto_id: n_id,
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
		$.post("<?=site_url("admin/proyectos/borrar")?>",
		{
			proyecto_id: p_id
		},function(data){
			switch(data)
			{
				case "ok":
					location.reload();
				break;
				case "ko":
					jAlert("Error al intentar eliminar la proyecto. Asegurese estar conectado.","Error");
				break;
				case "error_permiso":
					jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
				break;
				case "caract":
					jAlert("Este Proyecto Tiene Caracteristicas Asociadas.","Error");
				break;
			}
		});
	}
	function caracteristica(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/proyectos/caracteristicas")?>/'+p_id+'?TB_iframe=true&modal=1&height=400&width=500');
	}
	</script>
</head>
<body>
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>		
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="head">
	<img style="vertical-align: middle; width:32px" src="<?=site_url("img/admin/folder_process.png")?>" />
	Proyectos &nbsp;&nbsp;<span style="font-size:11px"><a href="<?=site_url("admin/proyectos/formulario")?>">Nuevo</a></span>
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
			<th>Tematica</th>
			<th>Fecha Carga</th>
			<th>Usuario</th>
			<th>Destacada</th>
			<th>Asociar Caracteristicas</th>
			<th>Eliminar</th>
			<th></th>
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $proyecto):?>
			<tr bgcolor="#ffffff">
			<td><?=$proyecto['id']?></td>
			<td><a href="<?=site_url("admin/proyectos/formulario/".$proyecto['id'])?>" title="Editar noticia"><?=$proyecto['titulo']?></a></td>
			<td><? if ($proyecto['tipo']==1) echo "Proyecto"; elseif ($proyecto['tipo']==2) echo "Programa";?></td>
			<td><?=$proyecto['tematica']?></td>
			<td><?=$proyecto['fecha']?></td>
			<td><?=$proyecto['usuario_nombre']." ".$proyecto['usuario_apellido']?></td>
			<td><input id="destacada_<?=$proyecto['id']?>" type="checkbox" <?=($proyecto['destacada']==1)?"checked":""?> name="habilitado" onclick="javascript:destacar(<?=$proyecto['id']?>)" /></td>
			<td align="center"><a href="javascript:caracteristica(<?=$proyecto['id']?>)" title="Asociar caracteristica" ><img width="25" src="<?=site_url("img/admin/link_add.png")?>" /></a></td>
			
			<td><a href="javascript:eliminar(<?=$proyecto['id']?>)" title="Eliminar noticia"><img width="25" src="<?=site_url("img/admin/delete.png")?>" /></a></td>
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