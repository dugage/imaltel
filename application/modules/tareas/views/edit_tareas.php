<div class="page-content">

    <div class="page-head">

        <?= $this->load->view('include/page_head') ?>

    </div>

    <?= $this->load->view('include/page_breadcrumb') ?>

    <div class="row">

    <input name="goBackTo" id="goBackTo" data-module="tareas" type="hidden" value="tareas" />

    <?php if($getRow->getIdusuarioto()->getId() == 21): ?>

        <div class="col-md-7">

            <div class="portlet light bordered">
                
                <?= $this->load->view('include/side_left') ?>
            </div>

        </div>

        <div class="col-md-5">

            <div class="portlet light bordered">
                
                <?= $this->load->view('include/side_rigth') ?>

            </div>

        </div>

    <?php elseif($getRow->getIdusuarioto()->getIdrol()->getId() == 3 OR $getRow->getIdusuarioto()->getIdrol()->getId() == 7 ): ?>
    
        <?php if( $getRow->getTipo() == "Cierre" AND $getRow->getIdusuarioto()->getIdrol()->getId() == 7 ): ?>

            <div class="col-md-7">

                <div class="portlet light bordered">
                    
                    <?= $this->load->view('include/side_left') ?>

                </div>

            </div>

            <div class="col-md-5">

                <div class="portlet light bordered">
                    
                    <?= $this->load->view('include/cierre') ?>

                </div>

            </div>

        <?php elseif( $getRow->getTipo() == "verificar ko" AND $getRow->getIdusuarioto()->getIdrol()->getId() == 7 ): ?>

            <div class="col-md-7">

                <div class="portlet light bordered">
                    
                    <?= $this->load->view('include/side_left') ?>

                </div>

            </div>

            <div class="col-md-5">

                <div class="portlet light bordered">
                    
                    <?= $this->load->view('include/proponer_ko') ?>

                </div>

            </div>

        <?php else: ?>

            <div class="col-md-12">

                <div class="portlet light bordered">
                    
                    <?= $this->load->view('include/documentacion') ?>

                </div>

            </div>

            <div class="col-md-12">

                <div class="portlet light bordered">
                    
                    <?= $this->load->view('include/side_left') ?>

                </div>

            </div>

        <?= $this->load->view('modals/attach_modal') ?>

        <?php endif ?>

    <?php elseif($getRow->getIdusuarioto()->getIdrol()->getId() == 8): ?>

         <div class="col-md-7">

            <div class="portlet light bordered">
                
                <?= $this->load->view('include/side_left') ?>

            </div>

        </div>

        <div class="col-md-5">

            <div class="portlet light bordered">
                
                <?= $this->load->view('include/cierre') ?>

            </div>

        </div>


    <?php else: ?>

        <div class="col-md-7">

            <div class="portlet light bordered">
                
                <?= $this->load->view('include/side_left') ?>

            </div>

        </div>

        <div class="col-md-5">

            <div class="portlet light bordered">
                
                <?= $this->load->view('include/side_rigth') ?>

            </div>

        </div>

        <?php if( $getRow->getTipo() != "Ausente-reconcertar(TMK)" ): ?>

            <div class="col-md-5">

                <div class="portlet light bordered">
                    
                    <?= $this->load->view('include/report') ?>

                </div>

            </div>

        <?php endif ?>

    <?php endif ?>


    </div>

</div>

<?= $this->load->view('include/modals/add_se_es_modal') ?>