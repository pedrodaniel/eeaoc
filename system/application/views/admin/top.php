<div id="top_menu">
	<div style="float: left;"><a href="<?=site_url("admin")?>">Escritorio</a></div>
	<div id="float: right;">
		Hola, <a href="javascript:editame(<?=$user['id']?>)"><?=$user['nombre']." ".$user['apellido']?></a>
		<span style="color: rgb(153, 153, 153);"> | </span>
		<a href="<?=site_url("admin/salir")?>">Salir</a>	
	</div>
</div>