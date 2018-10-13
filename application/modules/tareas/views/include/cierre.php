<div class="portlet-title">
	
	<?php if($getRow->getTipo() == 'cobertura'): ?>

    	<h3>Comprobar cobertura</h3>

    <?php else: ?>
		
		<h3>Acciones</h3>

	<?php endif ?>

</div>

<?php if($getRow->getTipo() != 'cobertura'): ?>

<div class="form-group">

    <label>Seguimiento Oferta</label>
    
    <select data-comercial="<?= $getRow->getIdcliente()->getIdcomercial() ?>" data-toperador="<?= $getRow->getIdcliente()->getIdusuario()->getId() ?>" data-tarea="<?= $getRow->getId()?>" data-cliente="<?= $getRow->getIdcliente()->getId() ?>" data-seguimiento="<?= $getCuSegui->getId()?>" name="realizado" class="form-control select-cierre">
        
        <option value="">Selecciona una opción</option>

        <!--<option value="1">Ausente(reconcertar TMK)</option>-->

        <option value="Volver a llamar">Volver a llamar (DIRECTOR COMERCIAL)</option>

		<option value="2">Fac.Recogida (verificar tmk)</option>

		<option value="Oferta 1">Entrega de oferta (evento para comercial)</option>

		<option value="Oferta 2">Oferta 2 (evento para comercial)</option>

		<option value="Oferta 3">Oferta 3 (evento para comercial)</option>

		<option value="E.O.Modi">E.O.Modi</option>

        <option value="Cierre">Cita cierre</option>

        <option value="Firmado">Firmado (admon)</option>

    </select>

</div>

<?php endif ?>

<div class="form-group">

	<?php if($getRow->getTipo() == 'cobertura'): ?>

		<?= $this->load->view('include/form_cobertura') ?>

	<?php else: ?>

		<?php if( $getRow->getIdusuarioto()->getIdrol()->getId() == 7 ): ?>
			
			<?= $this->load->view('include/proponer_ko') ?>

	    <?php else: ?>
	    
	        <?= $this->load->view('templates/panel/include/form_ko') ?>

	    <?php endif ?>


	<?php endif ?>

</div>

<?= $this->load->view('include/modals/volverLlamar_modal') ?>