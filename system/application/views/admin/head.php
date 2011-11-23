<link rel="icon" type="image/ico" href="<?=site_url("img/icono.jpg")?>" />
<title>:: Panel de Administraci&oacute;n ::</title>
<script language="javascript" src="<?=site_url('js/jquery-1.3.2.min.js')?>"></script>
<script language="javascript" src="<?=site_url('js/jquery.easing.1.3.js')?>"></script>
<script language="javascript" src="<?=site_url('js/jquery.jalerts.js')?>"></script>
<script language="javascript" src="<?=site_url('js/sexylightbox.v2.3.jquery.js')?>"></script>
<script language="javascript" src="<?=site_url('js/jquery.validate.min.js')?>"></script>
<link rel="STYLESHEET" type="text/css" href="<?=site_url('css/manage.css')?>"></link>
<link rel="STYLESHEET" type="text/css" href="<?=site_url('css/jalerts.css')?>"></link>
<link rel="STYLESHEET" type="text/css" href="<?=site_url('css/sexylightbox.css')?>"></link>
<script type="text/javascript">
	$(document).ready(function(){
		SexyLightbox.initialize({dir:'<?=site_url("img/sexyimages")?>'});
	});
	function editame(p_id)
	{
		if (p_id > 0)
			SexyLightbox.display('<?=site_url("admin/usuarios/editar")?>/'+p_id+'?TB_iframe=true&modal=1&height=410&width=500');
		else
			SexyLightbox.display('<?=site_url("admin/usuarios/nuevo")?>?TB_iframe=true&modal=1&height=410&width=500');
	}
</script>