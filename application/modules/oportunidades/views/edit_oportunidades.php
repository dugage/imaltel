<div class="page-content">

    <div class="page-head">

        <?= $this->load->view('include/page_head') ?>

    </div>

    <?= $this->load->view('include/page_breadcrumb') ?>

    <div class="row">

        <div class="col-md-12">

            <form enctype="multipart/form-data" role="form" method="post">

                    <?= validation_errors(); ?>

                    <?= $this->load->view('include/form_edit/details') ?>

                    <?= $this->load->view('include/form_edit/place') ?>

                    <?= $this->load->view('include/form_edit/info') ?>

                    <?= $this->load->view('include/form_edit/tracing') ?>

                    <div class="form-group">

                        <button name="submit" class="btn green" type="submit">Guardar</button>

                    </div>

            </form>

        </div>

    </div>

</div>

<?= $this->load->view('include/modal/search_modal') ?>
<?= $this->load->view('include/modal/add_modal') ?>

