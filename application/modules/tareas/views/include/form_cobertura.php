<div class="form-group">

	<label>Dirección/es</label>

	<textarea name="descripcion" class="form-control">
		
		<?= $getRow->getTexto() ?>

	</textarea>

</div>

<h3>Documentación Cobertura</h3>

<div style="margin-bottom: 15px;" class="form-group">

	<a href="#" class="btn green" data-toggle="modal" data-target="#AttachModal"><i class=" icon-plus "></i> Adjuntar documento</a>

</div>

<?php $isDocument = false ?>

<?php foreach ($attachments as $key => $attachment): ?>
			
	<?php if(strrpos($attachment->getTipodocumento(),'COBERTURA') !== false): ?>

		<div class="form-group">

			<input disabled="" class="form-control spinner" value=" <?= $attachment->getAttached() ?> " type="text">

		</div>

		<?php $isDocument = true ?>

	<?php endif ?>

<?php endforeach ?>

<?php if($isDocument): ?>

	<div style="margin-top: 10px;" class="form-group">
	    <a href="<?= site_url('tareas/close_tarea/'.$id) ?>" class="btn green" >Cerrar tarea</a>
	</div>

<?php endif ?>

<?php $this->load->view('modals/attach_modal') ?>
