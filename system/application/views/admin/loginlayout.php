<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? $this->load->view("admin/head")?>
	<link rel="STYLESHEET" type="text/css" href="<?=site_url('css/admin.css')?>"></link>
</head>

<body>
	<table width="100%" align="center" cellpadding="0" cellspacing="0" id="contPanel">

	<!-- ENCABEZADO -->
	<tr class="tituloAdmin" style="height:55px;" >
		<td bgcolor="#000">
			<div id="iconoPanel"><a href="<?=site_url("admin"); ?>"><img src="<?=site_url("img/admin/Control-Panel.png")?>" width="64" height="64" /></a></div>
			<div id="linkPanel"><?=anchor('admin','Panel de Administraci&oacute;n','class="panel"')?></div>
		</td>
		<td width="30%" align="right" valign="middle" bgcolor="#000"> 
			&nbsp;
		</td>
	</tr>

	<!-- MENU -->
	<tr class="menuPrincipal">
		<td height="25" colspan="2" valign="top">
				
		</td>
	</tr>
	
	<tr>
		<td height="20"></td>
	</tr>
	</table>
	
	<?= form_open('admin/verificar', 'id="formLogin"') ?>
	<table class="conBordes" width="30%" style="margin:0 auto;">
	<tr align="center">
		<td height="30" colspan="2" class="barraTituloLog" bgcolor="#aaa">
		&nbsp;<b>LOG-IN</b>			
		</td>
	</tr>
	<tr>
		<td id="fondoLogin">
			<table cellpadding="3" cellspacing="0" style="float:right;" width="250" >
			<tr>
				<td align="right" height="30">
					<font color="#000">&nbsp;<?='Email';?>:</font>					
				</td>
				<td>
					<?= form_input(array('name'=>'useremail','id'=>'useremail')) ?>					
				</td>
			</tr>
			<tr>
				<td align="right" height="30">
					<font color="#000">&nbsp;<?='Contraseña';?>:</font>					
				</td>
				<td>
					<?= form_password(array('name'=>'password','id'=>'password')) ?>					
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" height="30">
					&nbsp;
					<input name="login" type="submit" value="<?='Ingresar';?>" class="boton" id="btnlog" />					
				</td>
			</tr>
			<? if ($error!="") { ?>
			<tr>
				<td colspan="2" align="center" height="40">
					<font color="#990000"><b><?=$error?></b></font>					
				</td>
			</tr>
			<? } ?>
			</table>			
		</td>
	</tr>
	</table>
	<?= form_close() ?>
	<? $this->load->view("admin/pie");?>
</body>
</html>