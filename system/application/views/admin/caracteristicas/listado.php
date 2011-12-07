<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function buscar()
	{
		window.location="<?=site_url("admin/caracteristicas/index")?>/"+$("#search").val();
	}
	function habilitar(p_id)
	{
		var v_valor = 0;
		if ($("#habilitado_"+p_id).attr('checked'))
			v_valor = 1;
		$.post("<?=site_url("admin/caracteristicas/habilita")?>",
		{
			rubro_id: p_id,
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
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/page.png")?>" />
	Caracteristica &nbsp;&nbsp;<span style="font-size:11px"><a href="<?=site_url("admin/caracteristicas/formulario")?>">Nueva</a></span>
		<div class="setting" style="float:right">
		<input type="text" id="search" name="search" value="<?=$search?>" style="width:200px" />&nbsp;<button onclick="javascript:buscar()">Buscar</button>
		</div></div>
	<? if ($mensaje_ok!=""):?>
		<div class="success"><?=$mensaje_ok?></div>
	<? endif; ?>
	<br/>
	<table cellspacing="0" cellpadding="9" width="100%" id="table-1">
	<tbody>
		<tr >
			<th>&nbsp;</th>
			<th>Nombre</th>
			
			
			
		</tr>
	
		<? if ($listado):?>
			<? foreach ($listado as $rubro):?>
			<tr id="<?=$rubro['id']?>" >
			<td class='td-left' ><?=$rubro['id']?></td>
			<td class='td-mid'><a href="<?=site_url("admin/caracteristicas/formulario/".$rubro['id'])?>" title='Editar esta rubro'><?=$rubro['nombre']?></a></td>
			</tr>
			<? endforeach; ?>
			
		<? endif; ?>
		
	</tbody>
	</table>
	
	<div class="page-links"><?=$page_links; //Imprime la numeración de páginas ?></div>
</div>
<? $this->load->view("admin/footer")?>
</body>
</html>