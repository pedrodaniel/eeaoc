<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function buscar()
	{
		window.location="<?=site_url("admin/tematicas/index")?>/"+$("#search").val();
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
	Tem&aacute;ticas &nbsp;&nbsp;<span style="font-size:11px"><a href="<?=site_url("admin/tematicas/formulario")?>">Nueva</a></span>
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
			<th>Im&aacute;gen</th>
			<th>Nombre</th>
			<th>Tem&aacute;tica Padre</th>
			<th>Fecha Carga</th>
			<th>Usuario</th>
		</tr>
		<? if ($listado):?>
			<? foreach ($listado as $tem):?>
			<tr bgcolor="#ffffff">
			<td><?=$tem['id']?></td>
			<? 
			$imagen = "";
			if ($tem['imagen']!="")
			{
				if (file_exists("upload/img/tematicas/th_".$tem['imagen']))
				{
					$imagen = '<img src="'.site_url("upload/img/tematicas/th_".$tem['imagen']).'" width="70" />';
				}
			}
			?>
			<td><?=$imagen?></td>
			<td><a href="<?=site_url("admin/tematicas/formulario/".$tem['id'])?>" title="Editar tem&aacute;tica"><?=$tem['nombre']?></a></td>
			<td><?=$tem['tematica_padre']?></td>
			<td><?=$tem['fecha_carga']?></td>
			<td><?=$tem['usuario_nombre']." ".$tem['usuario_apellido']?></td>
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