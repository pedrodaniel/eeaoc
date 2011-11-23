<? 
$CI =& get_instance();
$CI->load->model("tematica","tematica",true);
$menu_tematicas = $CI->tematica->dameTematicasMenuFront();
?>
<div id="secciones">
    <div class="secciones-c">
    <? if ($menu_tematicas):?>
    	<ul>
    	<? $i = 0; ?>
    	<? foreach ($menu_tematicas as $tem):?>
    	<? if ($i == 0) $class = ""; else $class = 'class="sc-'.$i.'"';
    	$nom_amogada = $this->varios->amigar($tem['nombre']).".html";
    	?>
          <li <?=$class?>><a href="<?=site_url("tematica/".$tem['id']."/".$nom_amogada)?>"><?=$tem['nombre']?></a></li>
          <? $i++; ?>
        <? endforeach; ?>
        </ul>
    <? endif; ?>
	</div>
</div>