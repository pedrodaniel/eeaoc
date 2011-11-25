<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<style>
/*  Site Map
--------------------------------------------------------------------------------------*/
#ulsitemap dt, #sitemap_header dt, #ulsitemap dd, #sitemap_header dd {padding: 0.4em 0.5em;}
#ulsitemap dt, #sitemap_header dt {position: relative; width: 29em; text-indent: 16px; padding-right: 7em;}
.sm_type {width: 7.6em;}/*8.6em*/
.sm_desc {width: 14.5em;}/*15em*/
.sm_par {width: 6em;}
.sm_del {position: absolute; top: 0.4em; right: 43px; display: block; width: 16px; height: 16px; text-indent: -5000px;}
.sm_del a {position: absolute; top: 0; right: 0; display: block; width: 16px; height: 16px; text-indent: -5000px; background: url(../img/sm_del.gif) bottom no-repeat; border: none;}
.sm_move {position: relative; width: 4.5em; /*width: 3em; background: url(../img/move_bkg.gif) 0.5em 0.4em no-repeat;*/ min-height: 16px;}
.has_js .sm_move, .has_js .table_move {background: none !important;}
/*.has_js .move_up, .has_js .move_down {display: none !important;}*/
.sm_perm {width: 3.8em;}
.sm_perm + .sm_perm {width: 3em;}
.sm_shortdesc {width: 4.8em;}

#ulsitemap p {margin: 0;}
#ulsitemap dt span {display: none;}


#sitemap_header {float: left; display: block; background: url(../img/table_header.gif) bottom left repeat-x #b8c0c0; color: #fff;}
#sitemap_header {clear: both;}
#sitemap_header dt, #sitemap_header dd {float: left; background: url(../img/table_header.gif) bottom left repeat-x #b8c0c0; color: #fff; padding-top: 0.8em; padding-bottom: 0.7em;}
#sitemap_header dd {border-left: 1px solid #b8c0c0;}

#ulsitemap, #ulsitemap li, #ulsitemap ul {margin:0; font-size: 1em; clear:both; float:left; list-style-image:none; list-style-position:outside; list-style-type:none;width:73.5em;}
#ulsitemap dl {border-bottom:1px solid #EBEBEB; float:left; }
#ulsitemap dt, #ulsitemap dd {display:inline; float:left; }
#ulsitemap dd {border-left:1px solid #DDDDDD; }
#ulsitemap ul dt {text-indent: 32px; width:29em; }
#ulsitemap ul ul dt {text-indent: 48px; width:29em; }
#ulsitemap ul ul ul dt {text-indent: 64px; width:29em; }
#ulsitemap ul ul ul ul dt {text-indent: 80px; width:29em; }
#ulsitemap ul ul ul ul ul dt {text-indent: 96px; width:29em; }
#ulsitemap ul ul ul ul ul ul dt {text-indent: 112px; width:29em; }
#ulsitemap li:last-child {border-bottom: 1px solid #ccc; }
#ulsitemap ul li:last-child {border-bottom: none !important; }
#ulsitemap {border-bottom: 3px solid #ddd; }

#ulsitemap dt a {font-weight: bold;}
#ulsitemap ul dt a {font-weight: normal;}

#ulsitemap dl {background: none; float: left; border-bottom: 1px solid #ebebeb;}
#ulsitemap ul dl {background: #f3f3f3; border-bottom: 1px solid #e3e3e3;}
#ulsitemap ul ul dl {background: #ebebeb; border-bottom: 1px solid #e0e0e0;}
#ulsitemap ul ul ul dl {background: #e3e3e3; border-bottom: 1px solid #dbdbdb;}
#ulsitemap ul ul ul ul dl {background: #e0e0e0; border-bottom: 1px solid #d3d3d3;}

.has_js #ulsitemap li.parent_closed dt a span {position: absolute; top: 50%; left: 0; display: block; width: 13px; height: 2em; background: url(../img/excol_closed.gif) right 55% no-repeat; margin-top: -1em;}
.has_js #ulsitemap li.parent_open dt a span {position: absolute; top: 50%; left: 0; display: block; width: 13px; height: 2em; background: url(../img/excol_open.gif) right 55% no-repeat; margin-top: -1em;}

.has_js #ulsitemap li li.parent_closed dt a span {position: absolute; top: 50%; left: 0; display: block; width: 29px; height: 2em; background: url(../img/excol_closed.gif) right 55% no-repeat; margin-top: -1em;}
.has_js #ulsitemap li li.parent_open dt a span {position: absolute; top: 50%; left: 0; display: block; width: 29px; height: 2em; background: url(../img/excol_open.gif) right 55% no-repeat; margin-top: -1em;}

.has_js #ulsitemap li li li.parent_closed dt a span {position: absolute; top: 50%; left: 0; display: block; width: 45px; height: 2em; background: url(../img/excol_closed.gif) right 55% no-repeat; margin-top: -1em;}
.has_js #ulsitemap li li li.parent_open dt a span {position: absolute; top: 50%; left: 0; display: block; width: 45px; height: 2em; background: url(../img/excol_open.gif) right 55% no-repeat; margin-top: -1em;}

.has_js #ulsitemap li li li li.parent_closed dt a span {position: absolute; top: 50%; left: 0; display: block; width: 61px; height: 2em; background: url(../img/excol_closed.gif) right 55% no-repeat; margin-top: -1em;}
.has_js #ulsitemap li li li li.parent_open dt a span {position: absolute; top: 50%; left: 0; display: block; width: 61px; height: 2em; background: url(../img/excol_open.gif) right 55% no-repeat; margin-top: -1em;}

.has_js #ulsitemap li li li li li.parent_closed dt a span {position: absolute; top: 50%; left: 0; display: block; width: 77px; height: 2em; background: url(../img/excol_closed.gif) right 55% no-repeat; margin-top: -1em;}
.has_js #ulsitemap li li li li li.parent_open dt a span {position: absolute; top: 50%; left: 0; display: block; width: 77px; height: 2em; background: url(../img/excol_open.gif) right 55% no-repeat; margin-top: -1em;}

.has_js #ulsitemap li li li li li li.parent_closed dt a span {position: absolute; top: 50%; left: 0; display: block; width: 93px; height: 2em; background: url(../img/excol_closed.gif) right 55% no-repeat; margin-top: -1em;}
.has_js #ulsitemap li li li li li li.parent_open dt a span {position: absolute; top: 50%; left: 0; display: block; width: 93px; height: 2em; background: url(../img/excol_open.gif) right 55% no-repeat; margin-top: -1em;}

.has_js #ulsitemap li li li li li li li.parent_closed dt a span {position: absolute; top: 50%; left: 0; display: block; width: 109px; height: 2em; background: url(../img/excol_closed.gif) right 55% no-repeat; margin-top: -1em;}
.has_js #ulsitemap li li li li li li li.parent_open dt a span {position: absolute; top: 50%; left: 0; display: block; width: 109px; height: 2em; background: url(../img/excol_open.gif) right 55% no-repeat; margin-top: -1em;}

.has_js #ulsitemap li.parent_open ul li.parent_closed ul {display: none;}
.has_js #ulsitemap li.parent_open ul {display: block;}
.has_js #ulsitemap ul {display: none;}

.sm_par a {font-size: 0.8em;}
.sm_ac {position: absolute; top: 0.7em; right: 66px; display: block; height: 16px; border: none !important;font-style:normal;font-weight:normal !important;font-size:0.8em;}
.sm_ac * {font-weight:normal !important;}

.sm_draft {display: none;}
.approvalrequired .sm_draft {position: absolute; top: 0.4em; right: 3px; display: block; width: 16px; height: 16px; text-indent: -5000px; background: url(../img/draft.gif) bottom no-repeat; border: none;}
.draftexists .sm_draft {position: absolute; top: 0.4em; right: 3px; display: block; width: 16px; height: 16px; text-indent: -5000px; background: url(../img/draft.gif) top no-repeat; border: none;}

#sitemap a {cursor: pointer;}

dl#sitemap_header.urlpicker dt, #ajaxDialogContents dl#sitemap_header dt {width: 24em !important;}
dl#sitemap_header.urlpicker dd.sm_type, #ajaxDialogContents dl#sitemap_header dd.sm_type {width: 8em !important;}
dl#sitemap_header.urlpicker dd.sm_move, #ajaxDialogContents dl#sitemap_header dd.sm_move {width: 4em !important;}

ul.urlpicker li dt, #ajaxDialogContents ul li dt {width: 24em !important;}
ul.urlpicker li dt span, #ajaxDialogContents ul li dt span {display: none;}
ul.urlpicker li dt p, #ajaxDialogContents ul li dt p {margin: 0;}
ul.urlpicker li dd.sm_type, #ajaxDialogContents ul li dd.sm_type {width: 8em !important;}
ul.urlpicker li dd.sm_move, #ajaxDialogContents ul li dd.sm_move {width: 4em !important;}


/*  Site Map (Draggable)
--------------------------------------------------------------------------------------*/
#sitemap2 {}
/*  Tables
--------------------------------------------------------------------------------------*/
table {clear: both; font-size: 0.9em; border-bottom: 3px solid #ddd; margin-bottom: 1.3em;}
tr:last-child td {border-bottom: 1px solid #ccc;}
/*.altrow {background: #f0f0f0;}*/
td { padding: 0.4em 5px 0.3em 10px; border-right: 1px solid #ddd;}
td:last-child {border: none;}
th {background: url(../img/table_header.gif) bottom left repeat-x #b8c0c0; color: #fff; border-right: 1px solid #b8c0c0; padding: 0.8em 5px 0.7em 10px;}
th:last-child {border: none;}
.lev01 {padding-left: 20px;}
.lev02 {padding-left: 40px;}
.lev03 {padding-left: 60px;}

table .img_thumb {width: 35px; height: 35px; margin: 0; border: 1px solid #fff;}
.table_move {float: left; position: relative !important; width: auto; min-height: 0; padding-left: 40px; background: url(../img/move_bkg.gif) 0 50% no-repeat;}
.table_move .move_up {position: absolute; top: 50%; left: 0; display: block; width: 16px; height: 16px; margin-top: -8px; text-indent: -5000px; background: url(../img/move.gif) top left no-repeat; border: none;}
.table_move .move_down {position: absolute; top: 50%; left: 0; display: block; width: 16px; height: 16px; margin-top: -8px; text-indent: -5000px; background: url(../img/move.gif) top  no-repeat; border: none; margin-left: 16px;}
.table_move .move_up:hover {background-position: bottom left;}
.table_move .move_down:hover {background-position: bottom;}
.table_move .move_drag {float: right; display: block; width: 0; height: 16px; text-indent: -5000px; background: url(../img/move.gif) top right no-repeat;}

table .draft {float: right; font-size: 0.9em; text-transform: uppercase; margin: 0.1em 0 0 2em; color: #ff0000;}

#calendar_head {position: relative; width: 100%; padding: 0.5em 0; text-align: center; font: bold 1.3em Arial, Helvetica, sans-serif; margin: 0 0 0.8em 0;background: url(../img/table_header.gif) bottom left repeat-x #b8c0c0; color: #fff; margin: 0;}
#calendar_head a {font-size: 0.7em; color: #fff;}
#calendar_head a.prev {position: absolute; left: 2em; margin-top: 2px; white-space: nowrap;}
#calendar_head a.next {position: absolute; right: 2em; margin-top: 2px; white-space: nowrap;}
#calendar th {background: none; width: 14.285%; color: #000; padding: 0.4em 5px 0.3em 10px; border-right: 1px solid #ddd; border-bottom: 1px solid #ccc; text-align: center;}
#calendar th:last-child {border-right: none;}
#calendar td {padding: 0.1em 5px 0.1em 5px;}
#calendar td a {display: block; text-align: center; border: none; padding: 0.3em 0;}
#calendar a:hover {background: #eee;}
#calendar td table {border-bottom: none; margin-bottom: 0;}
#calendar td table td {border: none; color: #FFFFFF; font-size: 1.3em; font-weight: bold;}
#calendar .nextprev a {font-size: 1em; border-bottom: 1px solid #C2C7C8; padding: 0;}
#calendar .nextprev a:hover {border-bottom: #9FA5A6 !important; background: none !important;}

/*  Sitemap Ajax
--------------------------------------------------------------------------------------*/
#ajaxDialogContents {display: block; overflow: auto;}
#ajaxDialogContents .page .page_inner {background-image: none !important; width: 100%;}
#ajaxDialogContents .page .page_inner .col01 {background-image: none !important; width: 100%; margin: 0;}
#ajaxDialogContents #ulsitemap, #ajaxDialogContents #ulsitemap li:last-child {border-bottom: 0px !important;}
#ajaxDialogContents #ulsitemap dt, #ajaxDialogContents #sitemap_header dt {width: 26.5em;}
#ajaxDialogContents #ulsitemap ul dt {width: 25.5em;}
#ajaxDialogContents #ulsitemap ul ul dt {width: 24.5em;}
#ajaxDialogContents #ulsitemap ul ul ul dt {width: 23.5em;}
#ajaxDialogContents #ulsitemap ul ul ul ul dt {width: 22.5em;}
#ajaxDialogContents #ulsitemap ul ul ul ul ul dt {width: 21.5em;}
#ajaxDialogContents #ulsitemap ul ul ul ul ul ul dt {width: 20.5em;}
#ajaxDialogContents .intro {width: auto;}
#ajaxDialogContents #ulsitemap.urlpicker dt, #ajaxDialogContents #sitemap_header.urlpicker dt {width: 35.5em;}
#ajaxDialogContents #ulsitemap.urlpicker ul dt {width: 34.5em;}
#ajaxDialogContents #ulsitemap.urlpicker ul ul dt {width: 33.5em;}
#ajaxDialogContents #ulsitemap.urlpicker ul ul ul dt {width: 32.5em;}
#ajaxDialogContents #ulsitemap.urlpicker ul ul ul ul dt {width: 31.5em;}
#ajaxDialogContents #ulsitemap.urlpicker ul ul ul ul ul dt {width: 30.5em;}
#ajaxDialogContents #ulsitemap.urlpicker ul ul ul ul ul ul dt {width: 29.5em;}


.fieldPair {margin-bottom: 5px;}


#ajaxDialogContents #fieldWrapper_TextPage-Users .formpair dd, 
#ajaxDialogContents #fieldWrapper_TextPage-Roles .formpair dd {width: 49em;}

#TextPage-Users-qa select, #TextPage-Roles-qa select {margin-bottom: 5px;}
#TextPage-Users-qa table, #TextPage-Roles-qa table {position: relative; top: 4px;}
#TextPage-Users-qa input, #TextPage-Roles-qa input {margin: 0 2px 0 6px;}

#container_userpermissions, #container_rolepermissions {width: 74em; position: relative;}
#TextPage-Users-qa, #TextPage-Roles-qa {width: 74em; position: relative; margin-bottom: 10px;}
#TextPage-Users-qa .button01, #TextPage-Roles-qa .button01 {position: absolute; right: 0; top: 23px;}
#TextPage-Users-qa .button01 input, #TextPage-Roles-qa .button01 input {margin: 0;}

#ajaxDialogContents .backtop {display: none;}

</style>
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	function buscar()
	{
		window.location="<?=site_url("admin/paginas/index")?>/"+$("#search").val();
	}
	function habilitar(p_id)
	{
		var v_valor = 1;
		if ($("#habilitado_"+p_id).attr('checked'))
			v_valor = 0;
		$.post("<?=site_url("admin/paginas/habilita")?>",
		{
			pagina_id: p_id,
			valor: v_valor
		},
		function(data){
			switch(data)
			{
				case "ko":
					jAlert("Error en la conexi&oacute;n. Aseg&uacute;rese estar conectado a internet.","Error");
				break;
				case "error_permiso":
					jAlert("No tiene permiso para realizar la operaci&oacute;n solicitada.","Error");
				break;
				case "error_metodo":
					jAlert("M&eacute;todo no soportado.","Error");
				break;
			}
		});
	}
	</script>
</head>
<body>
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>		
<div style="margin-left: 25px; margin-right: 25px;">
<br/>

	
	<div class="head">
	<img style="vertical-align: middle;" src="<?=site_url("img/admin/page.png")?>" />
	Paginas &nbsp;&nbsp;<span style="font-size:11px"><a href="<?=site_url("admin/paginas/formulario")?>">Nueva</a></span>
		<div class="setting" style="float:right">
		<input type="text" id="search" name="search" value="<?=$search?>" style="width:200px" />&nbsp;<button onclick="javascript:buscar()">Buscar</button>
		</div></div>
	<br/>
	    <div class="col01">
              <h1>Site Map</h1>
              <dl id="sitemap_header">
                <dt>
					<span>Site Structure</span>
                </dt>
              </dl>        
		<? if ($listado):?>
		   <ul id="sitemap">
			<? foreach ($listado as $pagina):?>
			   <? if ($pagina['padre_id']==0 and $pagina['orden']==1):?>
			    <li>
                  <dl class="sm2_s_published"><a href="#"class="sm2_expander">&nbsp;</a>
                    <dt><?=$pagina['padre_id']?>-<?=$pagina['orden']?><a class="sm2_title" href="<?=site_url("admin/paginas/formulario/".$pagina['id'])?>"><?=$pagina['titulo']?></a></dt>
                    <dd class="sm2_actions"><strong>Actions:</strong> <span class="sm2_move" title="Move">Move</span><span class="sm2_delete" title="Delete">Delete</span><a href="#" class="sm2_addChild" title="Add Child">Add Child</a></dd>
                    <dd class="sm2_status"><strong>Status:</strong> <span class="sm2_pub" title="Published">Published<input id="habilitado_<?=$pagina['id']?>" type="checkbox" <?=($pagina['habilitado']==0)?"checked":""?> name="habilitado" onclick="javascript:habilitar(<?=$pagina['id']?>)" /></span><span class="sm2_workFlow" title="Draft Exists">Draft Exists</span></dd>

                  </dl>
				</li>
				<? endif; ?>
				 <? if ($pagina['padre_id']==0 and $pagina['orden']>1):?>
				   <li class="sm2_liOpen">
                   
                   
                     <dl class="sm2_s_published"><a href="#"class="sm2_expander">&nbsp;</a>
                    <dt><a class="sm2_title" href="#">About us</a></dt>
                    <dd class="sm2_actions"><strong>Actions:</strong> <span class="sm2_move" title="Move">Move</span><span class="sm2_delete" title="Delete">Delete</span><a href="#" class="sm2_addChild" title="Add Child">Add Child</a></dd>

                    <dd class="sm2_status"><strong>Status:</strong> <span class="sm2_pub" title="Published">Published</span><span class="sm2_workFlow" title="Draft Exists">Draft Exists</span></dd>
                  </dl>
				
				   </li>
                   <? endif; ?>
			
			
			<? endforeach; ?>
			</ul>
		<? endif; ?>
		  </div>
	</tbody>
	</table>
	<div class="page-links"></div>
</div>
<? $this->load->view("admin/footer")?>
</body>
</html>