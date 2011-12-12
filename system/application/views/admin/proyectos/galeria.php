<?php
            if (isset($proyecto['imagenes']) and $proyecto['imagenes']):?>
				<div id="section-detail-img" class="imagenes">
				<? foreach ($proyecto['imagenes'] as $img_tem):?>
					<a href="javascript:edita_img(<?=$img_tem['id']?>)" title="Editar imagen">
					<img src="<?=site_url("upload/proyecto/".$proyecto['id']."/th_".$img_tem['img'])?>" />&nbsp;&nbsp;
					</a>
				<? endforeach; ?>
				</div>
			<? endif; ?>