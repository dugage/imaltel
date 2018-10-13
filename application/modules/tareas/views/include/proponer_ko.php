<?php if( $proponerKo == null ): ?>

<div class="alert alert-warning" role="alert"> 
	
	Para realizar una propuesta a KO<br/>
	1.Redacta el reporte para la solicitud<br/>
	2.Haz click en el botón Proponer a KO<br/>
	3.Una vez realizado, si accedes de nuevo a la tarea, el botón Proponer a KO aparecerá bloqueado<br/><br/>
	Nota: El campo Reporte es obligatorio, no es posible reportar si el campo está vacío.

</div>

<?php endif ?>

<form action="<?= site_url('maincontroller/proponerKo/'.$id.'/tareas') ?>" method="post">
	
    <div class="form-group">

        <button <?php if( $proponerKo ) echo 'disabled' ?> id="0" style="width: 100%;" name="submit" class="btn red  <?php if( $proponerKo == null ) echo 'checkRequired' ?>" type="submit">Proponer a KO</button>

    </div>

    <div class="form-group">

        <label><span style="color:red">*</span>Reporte</label>

        <textarea name="text-reporte" class="form-control textareaRequired"></textarea>

    </div>

</form>