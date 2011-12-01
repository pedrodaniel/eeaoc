<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estación Experimental Agroindustrial Obispo Colombres</title>
<link rel="icon" type="image/ico" href="<?=site_url("img/icono.jpg")?>" />
<link href="<?=site_url("css/estilo.css")?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=site_url("js/jquery-1.3.2.min.js")?>"></script>
<script type="text/javascript" src="<?=site_url("js/jquery.easing.1.3.js")?>"></script>
<!-- Slider -->
<link href="<?=site_url("css/slider.css")?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=site_url("js/jquery.coda-slider-2.0.js")?>"></script>
<script type="text/javascript">
	$().ready(function() {
		
		$('#coda-slider-1').codaSlider({
           autoSlide: false,
		   dynamicTabs: false
		});
	});
</script>
<!-- Slider fin-->
<!-- Scroll-->
<script type="text/javascript" src="<?=site_url("js/jquery.tinyscrollbar.min.js")?>"></script>
<script type="text/javascript">
		$(document).ready(function(){

			$('#scrollbar1').tinyscrollbar({ sizethumb: 20 });
		});
	</script>
<link rel="stylesheet" href="<?=site_url("css/scroll.css")?>" type="text/css" media="screen"/>
<!-- Scroll fin-->
<!-- include Cycle plugin -->
<script type="text/javascript" src="<?=site_url("js/jquery.cycle.all.js")?>"></script>