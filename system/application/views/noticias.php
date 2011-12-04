<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<? $this->load->view("head.php"); ?>



<script type="text/javascript">

	$(document).ready(function () {		
		$("#nslider").css("width", "718px");
		$("#nslider").css("height", "219px");
		
		$('#slider').nivoSlider();
		
	});

</script>
</head>
<body >
<div id="content">
  <? $this->load->view("top") ?>
 <div id="main" class="g">
    <div id="left">
      <div class="left-c">
        <div class="menu noti">
          <div class="box">
            <div class="top">
              <h1>Noticias</h1>
            </div>
            <div class="center">
              <ul>
                <li><a href="<?=site_url("noticias/Institucionales")?>">Institucionales</a>
                <? if ($tipo_1):?>
                  <div class="subm">
                    <ul>
                    	<? foreach ($tipo_1 as $n1):?>
                      	<li><a href="<?=site_url("noticias/".$n1['id']."/".$this->varios->amigar($n1['titulo']).".html")?>"><?=$n1['titulo']?></a></li>
                      	<? endforeach; ?>
                    </ul>
                  </div>
                <? endif; ?>
                </li>
                <li><a href="<?=site_url("noticias/Agroindustriales")?>">Agroindustriales</a>
                <? if ($tipo_2):?>
                	<div class="subm">
                    <ul>
                    	<? foreach ($tipo_2 as $n2):?>
                      	<li><a href="<?=site_url("noticias/".$n2['id']."/".$this->varios->amigar($n2['titulo']).".html")?>"><?=$n2['titulo']?></a></li>
                      	<? endforeach; ?>
                    </ul>
                  	</div>
                <? endif;?>
                </li>
                <li><a href="<?=site_url("noticias/Cientificas")?>">Científicas</a>
                <? if ($tipo_3):?>
                	<div class="subm">
                    <ul>
                    	<? foreach ($tipo_3 as $n3):?>
                      	<li><a href="<?=site_url("noticias/".$n3['id']."/".$this->varios->amigar($n3['titulo']).".html")?>"><?=$n3['titulo']?></a></li>
                      	<? endforeach; ?>
                    </ul>
                  	</div>
                <? endif; ?>
                </li>
              </ul>
            </div>
          </div>
          <div class="box-vacio"></div>
          <div class="box-vacio oscuro"></div>
        </div>
      </div>
    </div>
    <div id="center">
      <div class="center-h">
        <div class="center-h-c">
          <div class="chl">
            <div class="box">
            <div id="nslider" style="position:absolute; background:url(images/op75.png); ">
			<div id="slider" class="nivoSlider">
		    <? if (isset($imagenes) and $imagenes):?>
				<? foreach ($imagenes as $img_tem):?>
					<? if ($img_tem['url']!=""):?>
					<a href="<?=$img_tem['url']?>" title="IR" <?=($img_tem['target']==2)?"target='_blank'":"";?>>
					<img src="<?=site_url("upload/noticia/".$img_tem['novedad_id']."/crop_".$img_tem['img'])?>" width="718" height="219" />
					</a>
					<? else: ?>
					<img src="<?=site_url("upload/noticia/".$img_tem['novedad_id']."/crop_".$img_tem['img'])?>" width="718" height="219" />
					<? endif; ?>
				<? endforeach; ?>
				
				<? endif; ?>
			</div>
			</div>
			</div>
          </div>
          <div id="scroll-con">
            <h1><?=$noticia['titulo'] ?></h1>
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
                <?=$noticia['texto'] ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <? $this->load->view("footer") ?>
</div>
</body>
</html>