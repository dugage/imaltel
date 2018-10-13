<div class="page-content">

    <div class="page-head">

        <?= $this->load->view('include/page_head') ?>

    </div>

    <?= $this->load->view('include/page_breadcrumb') ?>

    <div class="row">

        <div class="col-md-12">

            <div class="portlet profile-content light bordered">

				<div style="float: right;" class="checkbox">

				    <label>

				      <input class="md-check" multi="false" field="oculto" table="Registros" key="<?= $getRegistro->getId() ?>" <?php if($getRegistro->getOculto() == 1) echo 'checked' ?> type="checkbox"> Ocultar

				    </label>

				</div>

                <?= $this->load->view('include/portlet_title') ?>

                <div class="portlet-body flip-scroll">

                    <?= $this->load->view('include/form_edit') ?>

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