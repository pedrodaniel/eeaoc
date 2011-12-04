<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<? $this->load->view("head.php"); ?>

<script type="text/javascript">

	$(document).ready(function () {		
		$("#nslider").css("width", "667px");
		$("#nslider").css("height", "219px");
		
		//$("#slider").css("height", $(window).height()-80+"px");
		$('#slider').nivoSlider();
		
	});

</script>
</head>
<body>
<div id="content">
  <? $this->load->view("top") ?>
  <div id="main" class="nc">
    <div id="center">
      <div class="center-h">
        <div class="center-h-c">
          <div class="chl">
            <div class="box" id="box">
            <div id="nslider" style="position:absolute; background:url(images/op75.png); ">
			<div id="slider" class="nivoSlider">
		    <? if (isset($info['imagenes']) and $info['imagenes']):?>
				
				<? foreach ($info['imagenes'] as $img_tem):?>
				<? if($img_tem['url']){?>
					<a href="<?=$img_tem['url']?>"  <? if($img_tem['target']==2) echo 'target="_blank"'; ?>>
					<img src="<?=site_url("upload/pagina/".$info['id']."/crop_".$img_tem['img'])?>" width="667" height="219"/></a>
				<? }else{ ?>
					<img src="<?=site_url("upload/pagina/".$info['id']."/crop_".$img_tem['img'])?>" width="667" height="219"/>
				<?  } ?>
				<? endforeach; ?>
				
			<? endif; ?>
			</div>
			</div>
        	<div class="slideshow">
        	</div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-h">
        <div class="bottom-h-c">
          <div class="bhl">
            <div class="list-cont">
             <h1><?=$info['titulo']?></h1>
             
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="right">
      <div id="scroll-con">
        <div id="scrollbar1">
          <div class="scrollbar">
            <div class="track">
              <div class="thumb">
                <div class="end"></div>
              </div>
            </div>
          </div>
          <div class="viewport">
            <div class="overview">
            <?=$info['contenido'] ?> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="menu-bottom">
    	<div class="menu-bottom-c">
    		<? if ($servicios):?>
             <ul>
             	<? foreach ($servicios as $serv):?>
                <li><a href="<?=site_url("servicios/".$serv['id']."/".$this->varios->amigar($serv['nombre']).".html")?>"><?=$serv['nombre']?></a></li>
                <? endforeach; ?>
             </ul>
            <? endif; ?>
    	</div>
    </div>
  </div>
  <? $this->load->view("footer") ?>
</div>
</body>
</html>