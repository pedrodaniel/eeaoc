<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">
	$(document).ready(function(){
			
		
		$("#btn_guardar").click(function(){
			
			var validado = true;
			if ($("#titulo").val()=="")
			{
				$("#titulo").css('border-color', 'red');
				validado = false;
			}
			if (validado)
			{
				$("#page_form").submit();
			}
			else
			{
				jAlert("Debe ingresar el t&iacute;tulo,","Error");
			}	
			
		});
	});
	</script>
</head>
<body>	
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>	
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="content">
		<div class="head">
		
			<? if ($pagina['id'] > 0):?>
			<img src="<?=site_url("img/admin/page_edit.png")?>" />
			Editar Pagina
			<form id="page_form" method="post" enctype="multipart/form-data" action="<?=site_url("admin/paginas/modificar")?>">
			<? else:?>
			<img src="<?=site_url("img/admin/page_add.png")?>" />
			Nueva Pagina
			<form id="page_form" method="post" enctype="multipart/form-data" action="<?=site_url("admin/paginas/guardar")?>">
			<? endif; ?>
		</div>
		<br/>
		
<div style='width: 100%;'>
	<div style='width: 60%; float: left; margin-right: 30px;'>		
	
		<input name="id" id="id" type="hidden" value="<?=$pagina['id']?>"/>
		
			<div id="section">Titulo</div>
			<div id="section-detail">
				<input type="text" name="titulo" id="titulo" value="<?=(isset($pagina['titulo']))?$pagina['titulo']:""?>" style="width: 100%;" />
			</div>
			<div id="section">Descripci&oacute;n</div>
			<div id="section-detail">
				<textarea name="contenido" id='contenido' rows="20" style='width: 99%;' ><?=(isset($pagina['contenido']))?stripslashes($pagina['contenido']):""; ?></textarea>
				<div id='wmd-preview-box' style='display: none; margin: 0 auto; position: absolute; top: 100px; border: 10px solid silver; width: 600px; padding: 10px; background-color: #fff;'>
					<div id='wmd-preview' class="wmd-preview" style='width: 500px;'></div>
				</div>
			</div>
			
			
			<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
			
				<a class="large green awesome" href='javascript:void(0)' id="btn_guardar">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="<?=site_url("admin/paginas")?>">Cancelar</a>
			</div>
		
	</div>
	<div style='float: left; width: 30%;'>
		  		<div id='section'>Cargar Im&aacute;gen</div>
				  		
						<div id="section-detail">
							<input type="file" name="imagen" size="40" />
						</div>	
						
				
				 <div id='section'>otro</div>
			    		<div id="section-detail">
			    			<img src='<?=site_url('img/admin/world_bw.gif')?>' style='vertical-align: middle'/> Estado: 
							

    			<select name='habilitado' id='habilitado' style='margin-top: 5px; '>
    				<option value='0' <?php  if($pagina['habilitado'] == 1) echo 'selected'; ?>>Publicar</option>
    				<option value='1' <?php  if($pagina['habilitado'] == 0) echo 'selected'; ?>>Sin Publicar</option>
    			
    			</select>
    		<div style='border-bottom: 1px solid #ddd; padding: 5px;'></div><br/>	
    		<img src='<?=site_url('img/admin/link-small.png')?>' style='vertical-align: middle'/> Tipo de Menu: 
			    <select name='tipo' id='tipo'>
				<?php 
					foreach ($pagina['tipo_array'] as $key => $list) {
						if ($pagina['tipo']==$list['id']){
						echo "<option value='". $list['id'] . "' selected>" . $list['nombre'] . "</option>";
						}else {
							echo "<option value='". $list['id'] . "' >" . $list['nombre'] . "</option>";
						}
					}		
				?>
			</select>
			</div>
				</div>			

    			
			
			</div>
			</div>
		</form>
		
			<div style='clear: both;'></div>
	</div>
</div><script type="text/javascript" src="<?=site_url("js")?>/wmd/wmd.js"></script>
</div>
<? $this->load->view("admin/footer")?>
</body>
</html>