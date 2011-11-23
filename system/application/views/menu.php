<? 
$CI =& get_instance();
$CI->load->model("front/pagina","pagina",true);
$menu = $CI->pagina->damePaginasMenu();
?>
<div id="nav">
   <ul>
   <? if ($menu):?>
   	<? foreach ($menu as $m):?>
   		<? if ($pagina_id > 0 and $pagina_id == $m['id']) $selected = 'class="act"'; else $selected = "";?>
   		<li <?=$selected?>><a href="<?=site_url("pagina/".$m['id']."/".$m['accion'])?>"><?=$m['titulo']?></a></li>
    <? endforeach; ?>
    <? endif;?>
    <li class="ulti"><a href="#">Contacto</a></li>
	</ul>
</div>