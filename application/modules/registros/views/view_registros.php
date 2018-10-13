<div class="page-content">

    <div class="page-head">

        <?= $this->load->view('include/page_head') ?>

    </div>

    <?= $this->load->view('include/page_breadcrumb') ?>

    <div class="row">

        <div class="col-md-8">

            <div class="portlet light bordered">

                <?= $this->load->view('include/portlet_title') ?>

                <div class="portlet-body flip-scroll">

                    <?= $this->load->view('include/left_view') ?>

                </div>

            </div>

            <div class="portlet light bordered">

                <div class="portlet-title">
                    
                    <h3>Información detallada</h3>

                </div>

                <div class="portlet-body flip-scroll">

                    <?= $this->load->view('include/info_view') ?>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="portlet light bordered">

                <div class="portlet-title">

                    <button id="btn-chronometre" data-user="<?= $getRegistro->getIdusuario()->getId() ?>" data-record="<?= $getRegistro->getId() ?>" style="width: 100%" class="btn grey-mint start" type="button"><i class=" icon-call-end "></i> Comenzar llamada</button>

                </div>

                <div class="portlet-body flip-scroll">

                    <?= $this->load->view('include/right_view') ?>

                </div>

                <div class="portlet-footer">
                    <hr/>
                    <a href="<?= site_url('login/timeout') ?>" style="width: 100%" class="btn green" ><i class="fa fa-coffee" aria-hidden="true"></i> Descanso</a>

                </div>

            </div>

        </div>

        <?php if($getRegistroLlamadas): ?>

            <div class="col-md-12">

                <div class="portlet light bordered">

                    <div class="portlet-body flip-scroll">

                        <?= $this->load->view('include/record_call') ?>

                    </div>

                </div>

            </div>

        <?php endif ?>

    </div>

</div>

<?= $this->load->view('include/modals/registrosllamadas_modal') ?>