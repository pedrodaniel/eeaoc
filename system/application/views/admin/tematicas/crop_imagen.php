<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript" src="<?=site_url("js/jquery-pack.js")?>"></script>
	<script type="text/javascript" src="<?=site_url("js/jquery.imgareaselect.min.js")?>"></script>
	<script type="text/javascript">
	function preview(img, selection) { 
		var scaleX = 100 / selection.width; 
		var scaleY = 100 / selection.height; 
		
		$('#thumbnail + div > img').css({ 
			width: Math.round(scaleX * <?php echo $ancho;?>) + 'px', 
			height: Math.round(scaleY * <?php echo $alto;?>) + 'px',
			marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
			marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
		});
		$('#x1').val(selection.x1);
		$('#y1').val(selection.y1);
		$('#x2').val(selection.x2);
		$('#y2').val(selection.y2);
		$('#w').val(selection.width);
		$('#h').val(selection.height);
	} 
	
	/*$(document).ready(function () { 
		$('#save_thumb').click(function() {
			var x1 = $('#x1').val();
			var y1 = $('#y1').val();
			var x2 = $('#x2').val();
			var y2 = $('#y2').val();
			var w = $('#w').val();
			var h = $('#h').val();
			if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
				alert("You must make a selection first");
				return false;
			}else{
				return true;
			}
		});
	}); */
	
	$(window).load(function () { 
		$('#thumbnail').imgAreaSelect({ minWidth: <?=CROP_W?>, minHeight: <?=CROP_H?>, handles: true, aspectRatio: '3:1', onSelectChange: preview }); 
	});
	function cerrar()
	{
		parent.SexyLightbox.close();
	}
	
	function recortar()
	{
		if ($("#x1").val()!="" && $("#x2").val()!="")
		{
			$("#recortar").hide();
			$("#cerrar").hide();
			$("#loading").show();
			$.post('<?=site_url("admin/imagenes/recortar")?>',
			{
				folder: 'tematica',
				imagen: $("#imagen").val(),
				id: $("#id").val(),
				x1: $("#x1").val(),
				y1: $("#y1").val(),
				x2: $("#x2").val(),
				y2: $("#y2").val(),
				w: $("#w").val(),
				h: $("#h").val()
			},function(data){
				switch (data)
				{
					case "ok":
						parent.SexyLightbox.close();
					break;
					case "error_permiso":
						jAlert("Usted no tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
					break;
					case "ko":
						jAlert("Se produjo un error al intentar recortar la imagen.","Error");
					break;
				}
			});
		}
		else
			jAlert("Debe realizar el corte de la im&aacute;gen.","Error");
	}
	</script>
</head>
<body>	
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="content">
		
		<div style="width:100%; float:left">
			<img src="<?=site_url("upload/tematica/".$imagen['tematica_id']."/".$imagen['img'])?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
		</div>
		<br/><br/>
		<a href="javascript:recortar()" id="recortar" class='small awesome'>Recortar</a>
		&nbsp;&nbsp;&nbsp;
		<a href="javascript:cerrar()" id="cerrar">Cancelar</a>
		<img id="loading" src="<?=site_url("img/ajax-loader.gif")?>" style="display: none" />
		<form>
		<input name="id" id="id" type="hidden" value="<?=$imagen['tematica_id']?>"/>
		<input name="imagen" id="imagen" type="hidden" value="<?=$imagen['img']?>"/>
		<input type="hidden" id="x1" name="x1" />
		<input type="hidden" id="y1" name="y1" />
		<input type="hidden" id="x2" name="x2" />
		<input type="hidden" id="y2" name="y2" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		</form>
	</div>
</div>
</body>
</html>