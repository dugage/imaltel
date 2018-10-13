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

                        
                            <select name="facturacrm"  class="form-control">
                                <option value=""></option>
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>



                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Factura</label>

                            <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                            <span class="input-group-btn">

                                <button class="btn default" type="button">

                                    <i class="fa fa-calendar"></i>

                                </button>

                            </span>

                            <input name="factura" value="" class="form-control" type="text">

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
                            <input name="presupuestocrm" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="coberturacrm" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Presupuesto entregado al Cliente</label>

                        <select name="presupuestocli"  class="form-control">
                                <option value=""></option>
                                <option value="0">NO</option>
                                <option value="1">SI</option>
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
                            <input name="citapre" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="fechalla" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="fechaci" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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

                            <input name="tarea" value="" class="form-control" type="text">

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
                            <input name="n2" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="n3" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="oferta2" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="oferta3" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="cierre" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

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
                            <input name="fechako" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Converg</label>

                        <select name="converg"  class="form-control">
                                <option value=""></option>
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>

                    </div>

                </div>

            </div>








        </div>

    </div>

</div>