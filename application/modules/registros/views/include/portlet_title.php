<div class="portlet-title">

    <?php if($this->uri->segment(2)  != 'add'): ?>
        <a href="<?= site_url($path.'/add') ?>" class="btn green" type="button"><i class=" icon-plus "></i> Crear</a>
    <?php endif ?>

    <?php if($this->uri->segment(2)  == '' AND ($rol == 1 OR $rol == 6)): ?>

        <a href="<?= base_url('assets/csv/registros.csv') ?>" title="Descarga la plantilla CSV" style="float: right;" class="btn grey-mint" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Plantilla CSV</a>

        <button title="Asignar registros de un operario a otro" style="float: right;" class="btn btn-info" data-toggle="modal" data-target="#reasignarModal" type="button"><i class="fa fa-retweet" aria-hidden="true"></i> Reasignar</button>

        <button title="Subir lote de registros" style="float: right;" class="btn yellow" data-toggle="modal" data-target="#registrosModal" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Registros</button>

    <?php endif ?>

    <?php if($this->uri->segment(2)  == '' AND $rol == 4): ?>
     
    <?php endif ?>

    <?php if($this->uri->segment(2)  == 'view' AND $rol == 4): ?>

        <a target="_blank" href="<?= site_url('calendario') ?>" class="btn green" type="button"><i class="icon-calendar"></i> Calendario</a>

    <?php endif ?>

</div>
