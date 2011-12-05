<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_guardar").click(function(){
			$("#botones").hide();
			$("#loading").show();
			$.post("<?=site_url("admin/productos/guardar_cambios_imagen")?>",
			{
				imagen_id: <?=$imagen['id'] ?>,
				url: $("#link").val(),
				target: $("#target").val()
			},function(data){
				switch(data)
				{
					case "ok":
						parent.location.reload();
						parent.SexyLightbox.close();
					break;
					case "ko":
						jAlert("Error al intentar modificar la imagen. Asegurese estar conectado.","Error");
						$("#loading").hide();
						$("#botones").show();
					break;
					case "error_permiso":
						jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
						$("#loading").hide();
						$("#botones").show();
					break;
				}
			});
		});
	});
	
	function borrar()
	{
		$("#botones").hide();
		$("#loading").show();
		$.post("<?=site_url("admin/productos/borrar_imagen")?>",
		{
			imagen_id: <?=$imagen['id'] ?>,
			producto_id: <?=$imagen['producto_id']?>,
			imagen: "<?=$imagen['imagen']?>"
		},function(data){
			switch(data)
			{
				case "ok":
					parent.location.reload();
					parent.SexyLightbox.close();
				break;
				case "ko":
					jAlert("Error al intentar modificar la imagen. Asegurese estar conectado.","Error");
					$("#loading").hide();
					$("#botones").show();
				break;
				case "error_permiso":
					jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
					$("#loading").hide();
					$("#botones").show();
				break;
			}
		});
	}
	
	function recortar()
	{
		parent.SexyLightbox.display('<?=site_url("admin/productos/crop/".$imagen['id'])?>?TB_iframe=true&modal=1&height=750&width=950');
	}
	
	function cerrar()
	{
		parent.SexyLightbox.close();
	}
	</script>
</head>
<body>	
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="content">
		<div class="head">
			<img src="<?=site_url("img/admin/map.png")?>" />
			Editar Imagen
		</div>
		<br/>
		<div id="userForm" class="setting">
		<input name="imagen_id" id="imagen_id" type="hidden" value="<?=$imagen['id']?>"/>
		<div style="width: 450px;">
			<div id="section">Datos</div>
			<table cellpadding="6" border="0">
	  		<tbody>
	  		<tr>
	  			<td>Link a </td>
	  			<td><input type="text" id="link" name="link" value="<?=$imagen['url']?>" /></td>
	  		</tr>
	  		<tr>
	  			<td>Navegador </td>
	  			<td><select name="target" id="target" style="width:350px; height:25px">
						<option value="1" <?=($imagen['target']==1)?"selected":""?>>Interior</option>
						<option value="2" <?=($imagen['target']==2)?"selected":""?>>Exterior</option>
					</select></td>
	  		</tr>
	  		<tr>
	  			<td>Im&aacute;gen </td>
	  			<td><img src="<?=site_url("upload/producto/".$imagen['producto_id']."/th_".$imagen['imagen'])?>" /></td>
	  		</tr>
	  		</tbody>
	  		</table>
		</div>
		<div id="botones">
		<button id="btn_guardar" style="font-size: 14px; padding: 5px;" class="large green awesome">Guardar</button>
		&nbsp;&nbsp;&nbsp;
		<a href="javascript:recortar()" class='small awesome'>Recortar</a>
		&nbsp;&nbsp;&nbsp;
		<a href="javascript:borrar()" class='small awesome'>Eliminar</a>
		&nbsp;&nbsp;&nbsp;
		<a href="javascript:cerrar()">Cancelar</a>
		</div>
		<div id="loading" style="display: none;">
			<img src="<?=site_url("img/ajax-loader.gif")?>" />
		</div>
		</div>
	</div>
</div>
</body>
</html>