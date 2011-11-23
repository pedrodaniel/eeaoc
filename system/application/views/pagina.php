<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? $this->load->view("head.php"); ?>
</head>
<body id="home">
<div id="content">
  <? $this->load->view("top") ?>
  <div id="main">
    <div id="center">
      <div class="center-h">
        <div class="center-h-c">
          <div class="chl">
            <div class="box"></div>
          </div>
        </div>
      </div>
      <div class="bottom-h">
        <div class="bottom-h-c">
          <div class="bhl">
            <div class="list-cont">
             <h1><?=$info['titulo']?></h1>
             <? if ($hijas):?>
             <ul>
             	<? foreach ($hijas as $h):?>
                <li><a href="<?=site_url("pagina/".$pagina_id."/".$h['id']."/".$h['accion'])?>"><?=$h['titulo']?></a></li>
                <? endforeach; ?>
              </ul>
              <? endif; ?>
              <div class="box-gris">
                <p>100 años de historia</p>
              </div>
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
            <h1><?=$info['titulo']?></h1>
            <?=$info['contenido'] ?> 
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