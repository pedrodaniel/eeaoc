<? 
$CI =& get_instance();
$CI->load->model("front/pagina","pagina",true);
$menu = $CI->pagina->damePaginasMenu();
?>
<div id="nav">
	<? if (!isset($home)):?>
	<ul class="camino">
		<li class="inicio ulti"><a href="<?=site_url("")?>">Inicio</a></li>
		<li class="ant"><a href="javascript:history.go(-1)">Anterior</a></li>
	</ul>
	<? endif;?>
   <ul>
   <? if ($menu):?>
   	<? foreach ($menu as $m):?>
   		<? if (isset($pagina_id) and $pagina_id == $m['id']) $selected = 'class="act"'; else $selected = "";?>
   		<? if ($m['accion']=="") $ref = site_url("pagina/".$m['id']); else $ref = site_url($m['accion']);?>
   		<li <?=$selected?>><a href="<?=$ref?>"><?=$m['titulo']?></a></li>
    <? endforeach; ?>
    <? endif;?>
    <li class="ulti"><a href="#">Contacto</a></li>
	</ul>
</div>