<div class="portlet-title">

    <?php if($this->uri->segment(2) != 'add' AND $this->session->userdata('rol') == 1): ?>
        <a href="<?= site_url($path.'/add') ?>" class="btn green" type="button"><i class=" icon-plus "></i> Crear</a>

      <!--<?php if($this->session->userdata('rol') == 1): ?>  
        <a style="float: right;" href="#" data-path="clientes/exportData" data-title="Exportar clientes" data-toggle="modal" data-target="#MainModal" class="btn green drawModal" type="button"><i class="fa fa-file-excel-o"></i> Exportar</a>
       <?php endif ?>-->
    <?php endif ?>

</div>
