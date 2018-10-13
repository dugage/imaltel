<div class="page-content">

    <div class="page-head">

        <?= $this->load->view('include/page_head') ?>

    </div>

    <?= $this->load->view('include/page_breadcrumb') ?>

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light bordered">

                <?= $this->load->view('include/portlet_title') ?>

                <div class="portlet-body flip-scroll">

                    <?php if( $getResult['is_mine'] == TRUE ): ?>

                        <?= $this->load->view('include/table') ?>

                    <?php elseif( $getResult['is_mine'] == FALSE ): ?>

                        <?php if( $getResult['result'] ): ?>
                            
                            <div class="alert alert-warning" role="alert">Este cliente está asignado a otro Comercial/Equipo consulte con su Coordinador.</div>

                        <?php else: ?>

                            <div class="alert alert-warning" role="alert">El cliente que intenta buscar no se encuentra en nuestra basa de datos.</div>

                        <?php endif ?>
                        
                    <?php endif ?>

                    <div id="footer-table">
                        
                        <div class="col-md-6"></div>

                        <?php if($rol != 3): ?>

                            <div class="col-md-6 paginator">
                                
                                <?= $start + 1 ?> a <?= $next ?> de <?= $totalRecord ?>
                                
                                <?php if($start > 0): ?>

                                <a href="<?= site_url($path.'/'.$previous.$searcher_param) ?>" class="btn btn-default btn-pagination bnt-previous"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>

                                <?php endif ?>
                                
                                <a href="<?= site_url($path.'/'.$next.$searcher_param) ?>" class="btn btn-pagination btn-default bnt-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>

                            </div>

                        <?php endif ?>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>
