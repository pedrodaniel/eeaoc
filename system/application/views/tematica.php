<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<? $this->load->view("head.php"); ?>

<script type="text/javascript">
$(document).ready(function() {
    $('.slideshow').cycle({
		fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});
</script>
</head>
<body id="home">
<div id="content">
  <? $this->load->view("top") ?>
  <div id="main" class="nov nc">
    <div id="center">
      <div class="center-h">
        <div class="center-h-c">
          <div class="chl">
            <div class="box" id="box">
            <div class="slideshow">

		    <? if (isset($imagenes) and $imagenes):?>
				<? foreach ($imagenes as $img_tem):?>
					<a href="<?=$img_tem['url']?>" title="IR">
					<img src="<?=site_url("upload/tematica/".$info['id']."/crop_".$img_tem['img'])?>" width="667" height="219" />
					</a>
				<? endforeach; ?>
				
				<? endif; ?>
        
        	</div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-h">
        <div class="bottom-h-c">
          <div class="bhl">
            <div class="list-cont">
             <h1><?=$info['nombre']?></h1>
             
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
            <?=$info['descripcion'] ?> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="menu-bottom">
    	<div class="menu-bottom-c">
    		<? if ($hijas):?>
    		<ul>
    			<? foreach ($hijas as $h):?>
    			<li><a href="<?=site_url("tematica/".$h['id']."/".$this->varios->amigar($h['nombre']).".html")?>"><?=$h['nombre']?></a></li>
    			<? endforeach; ?>
    		</ul>
    		<? elseif($rubros):?>
    		<ul>
    			<? foreach ($rubros as $r):?>
    			<li><a href="#"><?=$r['nombre']?></a></li>
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