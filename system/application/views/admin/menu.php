<? 
$CI =& get_instance();
$CI->load->model("menu","menu",true);
$menu = $CI->menu->dameMenu($user['perfil_id']);
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" >
	<tr class="tituloAdmin" style="height: 55px;">
		<td valign="middle" bgcolor="#000">
			<div id="iconoPanel"><a href="<?=site_url("admin"); ?>"><img src="<?=site_url("img/Control-Panel.png")?>" width="64" height="64" /></a></div>
			<div id="linkPanel"><?=anchor('admin','Panel de Administraci&oacute;n','class="panel"')?></div>
		</td>
		<td width="30%" align="right" valign="bottom" bgcolor="#000"> 
			<font style="color:#fff"><?='Bienvenido '.$user['nombre']." ".$user['apellido'];?></font>&nbsp;
		</td>
	</tr>
	<!-- MENU -->
	<tr class="menuPrincipal">
		<td height="25" colspan="2" valign="top">
		
		<?=$menu;?>
				
		</td>
	</tr>
	<tr>
		<td height="20"></td>
	</tr>
</table>