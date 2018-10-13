<div class="portlet-title">

    <h3>Reportar</h3>

</div>

<div class="form-group">

    <label>Tipo de reporte</label>

    <select name="tipo-reporte" class="form-control">
		
		<?php foreach ($getEstadosSeguimiento as $key => $estado): ?>

            <option value="<?= $estado->getId() ?>"><?= $estado->getNombre()?></option>

        <?php endforeach ?>

    </select>

</div>


<div class="form-group">
	
	<textarea name="reporte" class="form-control reporte"></textarea>

</div>

<div class="form-group">
	
	<input type="hidden" name="usuario" value="<?= $this->session->userdata('usuarioid') ?>">
	<input type="hidden" name="id" value="<?= $getRow->getIdcliente()->getId() ?>">
	<input type="hidden" name="tabla" value="cuentas">
	<input type="hidden" name="ids" value="<?= $id ?>">
	<input type="hidden" name="tablas" value="tareas">
    <button name="button" class="btn green set-reportar" type="submit">Guardar</button>

</div>

