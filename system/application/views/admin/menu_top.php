<? 
$CI =& get_instance();
$CI->load->model("menu","menu",true);
$menu = $CI->menu->dameMenu($user['perfil_id'],0);
$submenu = false;
if ($padre_id > 0)
	$submenu = $CI->menu->dameMenu($user['perfil_id'],$padre_id);
?>
<div id="menu">
	<div id="menu_unsel"></div>
	<? if ($menu):?>
		<? foreach ($menu as $m) :?>
			<? if ($m['id']==$padre_id):?>
			<div id="menu_sel_left"></div>
			<div id="menu_sel"><a href="<?=site_url("admin/".$m['accion'])?>"><?=$m['nombre']?></a></div>
			<div id="menu_sel_right"></div>
			<? else:?>
			<div id="menu_unsel"><a href="<?=site_url("admin/".$m['accion'])?>"><?=$m['nombre']?></a></div>
			<? endif; ?>
		<? endforeach; ?>
	<? endif; ?>
</div>
<div class="sub-nav">
<? if ($submenu):?>
	<? foreach ($submenu as $sm) :
		$marca = "";
		if ($modulo_id == $sm['id'])
			$marca = "selected";
	?>
	<span class="<?=$marca?>"><a href="<?=site_url("admin/".$sm['accion'])?>"><?=$sm['nombre']?></a></span>
	<? endforeach; ?>
<? endif; ?>
</div>