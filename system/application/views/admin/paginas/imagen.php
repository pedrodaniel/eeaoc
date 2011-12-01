<? $this->load->view("admin/head")?>
<script type="text/javascript">

	$(document).ready(function(){
		$("#btn_subir").click(function(){
			    
				$("#save_img_box").hide();
				$("#save_img_box_waiting").show();
				$("#page_img_form").submit();
				
				
				//parent.location.reload();
		});
		$.post('<?=site_url("admin/paginas/traeGaleria/".$pagina['id'])?>'
				, function(data){
			$('#galeria',window.parent.document).html( data);
		 })
		
	});	
	</script>
	<img src='<?=site_url("img/admin/picture_add.png")?>'> <span class='head'>Subir Imagen</span>
	<? if ($mensaje_error!=""):?>
			<div class="error"><?=$mensaje_error?></div>
		<? endif; ?>
		<? if ($mensaje_ok!=""):?>
			<div class="success"><?=$mensaje_ok?></div>
		<? endif; ?>
<div id='section'>Carga de Im&aacute;gen </div>	
<form id="page_img_form" method="post" enctype="multipart/form-data" action="<?=site_url("admin/paginas/CreaImg")?>">
		  		
				<table cellpadding="6" border="0">
	  		<tbody>	  		
			<tr>
	  			<td>  Seleccione una imagen (jpg, gif, png)  </td>
	  			
	  			<input type="hidden" name="pagina_id" value="<?=$pagina['id']?>" />
	  			<td><input type="file" name="imagen" size="30" /></td>
	  		</tr>	
			<tr>
	  			<td><img src='<?=site_url('img/admin/link-small.png')?>' style='vertical-align: middle'/> Link a:
					
				</td>
				<td>	<input type="text" name="link" id="link" value="<?=(isset($pagina['link']))?$pagina['link']:""?>" style="width: 70%;" />
				</td>
	  		</tr>
	  			<tr>
	  			<td>	Navegador:
				</td>
				<td>	<select name="target" id="target" style="width:80px; height:25px">
						<option value="1">Interior</option>
						<option value="2">Exterior</option>
					</select>
				</td>
	  		</tr>
	  			<tr>
	  			<td>
	  			
	  				<div id="save_img_box" style="padding: 8px; text-align: right;">
						<a class="large green awesome" href='javascript:void(0)' id="btn_subir">Subir</a>
					</div>
					
				</td>
				<td>	<div id="save_img_box_waiting" style="padding: 8px; text-align: right; display: none;">
						<img src="<?=site_url("img/ajax-loader.gif")?>" />
			</div>
				</td>
	  		</tr>
	  				
	  			
	  		</tbody>
				</table>	
				
</form>	