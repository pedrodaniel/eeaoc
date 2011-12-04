<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? $this->load->view("head.php"); ?>
</head>
<body id="home">
<div id="content">
  <? $this->load->view("top") ?>
  <div id="main">
    <div class="center-h">
      <div class="center-h-c">
        <div class="chl">
          <div class="box"></div>
        </div>
        <div class="chr">
          <div class="coda-slider-wrapper">
            <div class="coda-slider preload" id="coda-slider-1">
              <div class="panel">
                <div class="panel-wrapper">Congreso Granos 2010</div>
              </div>
              <div class="panel">
                <div class="panel-wrapper"> Proin nec turpis </div>
              </div>
            </div>
            <div class="slide-b"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-h">
      <div class="bottom-h-c">
        <div class="bhl">
          <div class="list-cont">
            <h1>Campañas</h1>
            <ul>
              <li><a href="#">Safra 2010</a></li>
              <li><a href="#">Soja</a></li>
              <li><a href="#">Picudo Negro</a></li>
            </ul>
          </div>
        </div>
        <div class="bhr">
          <div class="list-cont">
            <h1>Noticias</h1>
            <ul>
              <li><a href="<?=site_url("noticias/Agroindustriales")?>">Agroindustriales</a></li>
              <li><a href="<?=site_url("noticias/Cientificas")?>">Cient&iacute;ficas</a></li>
              <li><a href="<?=site_url("noticias/Institucionales")?>">Institucionales</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <? $this->load->view("footer") ?>
</div>
</body>
</html>