<div class="portlet light bordered">

    <div class="portlet-title">

        <h3>Localidad</h3>

    </div>


    <div class="portlet-body flip-scroll">

        <div class="row">

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>CP</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="nombre" value="<?= $oportunidad->getCp() ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Población</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="poblacion" value="<?= $oportunidad->getPoblacion() ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>