
<div class="portlet light bordered">

    <div class="portlet-title">

        <h3>Detalles de Oportunidad</h3>

    </div>


    <div class="portlet-body flip-scroll">

        <div class="row">

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>CIF</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="cif" value="<?= $oportunidad->getCif() ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label><span style="color:red">*</span> Nombre de la oportunidad</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="oportunidad" value="<?= $oportunidad->getNombre() ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label><span style="color:red">*</span>Asignado a</label>
  
                        <select name="idUsuario" class="form-control">

                            <option value=""></option>

                            <?php foreach($getUsuarios as $usuario): ?>

                                <option <?php if($usuario->getId() == $oportunidad->getIdUsuario()->getId()) echo 'selected' ?> value="<?= $usuario->getId() ?>"><?= $usuario->getNombre() ?> <?= $usuario->getApellidos() ?></option>

                            <?php endforeach ?>

                        </select>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label><span style="color:red">*</span> Cuenta</label>

                        <div class="input-group">

                            <span class="input-group-btn">

                                <button data-toggle="modal" data-target=".search-modal" class="btn default" type="button"><i class="fa fa-search"></i></button>

                            </span>

                            <input name="cuenta" value="<?php foreach ($getCuentas as $cuenta) { echo $cuenta->getNombre(); }?>" class="form-control" type="text">
                            <input type="hidden" value="<?php foreach ($getCuentas as $cuenta) { echo $cuenta->getId(); }?>" name="idcuenta">

                            <span class="input-group-btn">

                                <button data-toggle="modal" data-target=".add-modal" class="btn default" type="button"><i class="fa fa-plus"></i></button>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label><span style="color:red">*</span>Fase venta</label>
  
                        <select name="venta" class="form-control">

                            <option value=""></option>

                            <?php foreach($getFaseVenta as $fase): ?>

                                <option <?php if($fase->getId() == $oportunidad->getIdfaseventa()->getId()) echo 'selected' ?> value="<?= $fase->getId() ?>"><?= $fase->getValor() ?> </option>

                            <?php endforeach ?>

                        </select>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

            </div>

        </div>

    </div>

</div>

