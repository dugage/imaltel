<div class="portlet light bordered">

    <div class="portlet-title">

        <h3>Seguimiento de Oportunidad</h3>

    </div>


    <div class="portlet-body flip-scroll">

        <div class="row">

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                         <label>Factura CRM</label>
  
                        <select name="facturacrm" class="form-control">
                                <option value=""></option>
                                <option <?php if($oportunidad->getFacturacrm() == 1) echo 'selected'  ?> value="1">Si</option>
                                <option <?php if($oportunidad->getFacturacrm() == 0) echo 'selected'  ?> value="0">No</option>
                        </select>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Factura</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="factura" value="<?= $oportunidad->getFecfactura()->format('d-m-Y') ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Presupuesto CRM</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="presupuestocrm" value="<?= $oportunidad->getPresupuestocrm()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Cobertura CRM</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="coberturacrm" value="<?= $oportunidad->getCoberturacrm()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Presupuesto entregado al Cliente</label>
  
                        <select name="presupuestocli" class="form-control">
                        
                                <option value=""></option>
                                <option <?php if($oportunidad->getPreentrcliente() == 1) echo 'selected'  ?> value="1">Si</option>
                                <option <?php if($oportunidad->getPreentrcliente() == 0) echo 'selected'  ?> value="0">No</option>
                                
                        </select>

                        

                    </div>

                </div>

            </div>
            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Cita entrega  Presupuesto</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="citapre" value="<?= $oportunidad->getCitaentrpresupuesto()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Fecha Próxima Llamada</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="fechalla" value="<?= $oportunidad->getFecproxllamada()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label><span style="color:red">*</span> Fecha Cita</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="fechaci" value="<?= $oportunidad->getFechacita()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Tarea</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="tarea" value="<?= $oportunidad->getTarea() ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>N2</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="n2" value="<?= $oportunidad->getN2()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>
<div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>N3</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="n3" value="<?= $oportunidad->getN3()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Oferta 2</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="oferta2" value="<?= $oportunidad->getOferta2()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Oferta 3</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="oferta3" value="<?= $oportunidad->getOferta3()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Cierre</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="cierre" value="<?= $oportunidad->getCierra()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Fecha KO</label>

                        <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>
                            <input name="fechako" value="<?= $oportunidad->getFechako()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Converg</label>

                        <select name="presupuestocli" class="form-control">
                                <option value=""></option>
                                <?php 
                                    for ($i=0; $i < 2; $i++) { 
                                       $a=array("Si","No");
                                       $b=array(1,0);
                                       if ($i==$oportunidad->getConverg()) {
                                           echo "<option value='".$i."' selected>".str_replace($b, $a, $i)."</option>";
                                       }else{
                                            echo "<option value='".$i."'>".str_replace($b, $a, $i)."</option>";
                                       }
                                    }
                                 ?>
                        </select>

                    </div>

                </div>

            </div>








        </div>

    </div>

</div>