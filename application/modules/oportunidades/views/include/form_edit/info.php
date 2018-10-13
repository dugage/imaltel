
<div class="portlet light bordered">

    <div class="portlet-title">

        <h3>Información Específica</h3>

    </div>
    <div class="portlet-body flip-scroll">

        <div class="row">
            
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Operadora</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="operadora" value="<?= $oportunidad->getOperadora() ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Lineas Móviles</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="lineamo" value="<?= $oportunidad->getLineasmoviles() ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Linea Datos</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="lineada" value="<?= $oportunidad->getLineasdatos() ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>ADSL</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="adsl" value="<?= $oportunidad->getAdsl() ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Conecta PYMES</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="pymes" value="<?= $oportunidad->getConectapyme() ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Historial Cliente</label>

                    <textarea name="historial" class="form-control" rows="3"><?= $oportunidad->getHistorial() ?></textarea>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Teleoperadora</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="teleoperadora" value="<?= $oportunidad->getTeleoperadora() ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Tipo CP</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="cp" value="" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Canguro</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="canguro" value="" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Vol</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="vol" value="" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
    </div>
    </div>
</div>