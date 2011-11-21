<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<script type="text/javascript">

	</script>
</head>
<body>	
<? $this->load->view("admin/top")?>
<? $this->load->view("admin/menu_top")?>	
<div style="margin-left: 25px; margin-right: 25px;">
<br/>
	<div class="content">
		<div class="head">
			<? if ($tematica['id'] > 0):?>
			<img src="<?=site_url("img/admin/page_edit.png")?>" />
			Editar Tem&aacute;tica
			<? else:?>
			<img src="<?=site_url("img/admin/page_add.png")?>" />
			Nueva Tem&aacute;tica
			<? endif; ?>
		</div>
		<br/>
		<form id="userForm" method="post" enctype="multipart/form-data" action="<?=site_url("admin/tematicas/guardar")?>">
		<input name="tematica_id" id="tematica_id" type="hidden" value="<?=$tematica['id']?>"/>
		<div style="width: 100%;">
			<div id="section">Nombre</div>
			<div id="section-detail">
				<input type="text" name="nombre" value="<?=(isset($tematica['nombre']))?$tematica['nombre']:""?>" style="width: 100%;" />
			</div>
			<div id="section">Padre</div>
			<div id="section-detail">
				<select name="padre_id" id="padre_id">
	  			<? if ($padres):?>
	  				<? foreach ($padres as $p):
	  					$selected = "";
	  					if (isset($tematica['padre_id']) and $p['id'] == $tematica['padre_id'])
	  						$selected = "selected";
	  				?>
	  				<option value="<?=$p['id']?>" <?=$selected?>><?=$p['nombre']?></option>
	  				<? endforeach; ?>
	  			<? endif; ?>
	  			</select>
			</div>
			<div id="section">Descripci&oacute;n</div>
			<div id="section-detail">
				<textarea name="detail" id='detail' rows="20" style='width: 99%;'><?=(isset($p['descripcion']))?stripslashes($p['descripcion']):""; ?></textarea>
				<div id='wmd-preview-box' style='display: none; margin: 0 auto; position: absolute; top: 100px; border: 10px solid silver; width: 600px; padding: 10px; background-color: #fff;'>
					<div id='wmd-preview' class="wmd-preview" style='width: 500px;'></div>
				</div>
			</div>
			<div id="section">Im&aacute;gen</div>
			<div id="section-detail">
				<input type="file" name="imagen" size="40" />
			</div>
			<div id="save_box" style="background-color: rgb(224, 224, 224); padding: 15px; text-align: right;">
				<a class="large green awesome" href="javascript:cargar_form()">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="<?=site_url("admin/tematicas")?>">Cancelar</a>
			</div>
		</div>
		</form>
	</div>
</div>
<? $this->load->view("admin/footer")?>
</body>
</html>