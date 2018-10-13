<div class="portlet-title">

    <?php if($this->uri->segment(3) != 'add' AND ($rol == 1 OR $rol == 6 OR $rol == 9)): ?>
        <a href="#" class="btn green" data-toggle="modal" data-target="#eventosModal" type="button"><i class=" icon-plus "></i> Evento</a>
    <?php endif ?>

</div>
