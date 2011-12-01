<?php
            if (isset($pagina['imagenes']) and $pagina['imagenes']):?>
				<div id="section-detail-img" class="imagenes">
				<? foreach ($pagina['imagenes'] as $img_tem):?>
					<a href="javascript:edita_img(<?=$img_tem['id']?>)" title="Editar imagen">
					<img src="<?=site_url("upload/pagina/".$pagina['id']."/th_".$img_tem['img'])?>" />&nbsp;&nbsp;
					</a>
				<? endforeach; ?>
				</div>
			<? endif; ?>