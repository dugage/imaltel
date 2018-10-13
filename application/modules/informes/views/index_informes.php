<div class="page-content">

    <div class="page-head">

        <?= $this->load->view('include/page_head') ?>

    </div>

    <?= $this->load->view('include/page_breadcrumb') ?>

    <div class="m-heading-1 border-green m-bordered">

        <h3>Cómo funciona informes</h3>
        <p> Para crear un informe, selecciona un rango de fechas en el selector de calendario, selecciona el tipo de informe que deseas generar y el perfil del usuario, luego selecciona el usuario al que quieres que afecte. Puedes seleccionar todos para obtener un informe de todos los usuarios.</p>
        <hr/>
        <h3>Cómo realizar búsquedas</h3>
        <p>Para poder realizar búsquedas una vez obtenga el informe, sigue estos pasos:</p>
        <p>
            -Pulsa la combinación de teclas Ctrl+F. Esto abrirá un buscador en la parte baja del navegador.<br/>
            -En el campo de búsqueda, teclea el texto, o partes de este que deseas buscar, veras que mientras escribes
            la primera coincidencia se coloreará. Puedes usar las teclas de arriba y abajo para encontrar otro coincidencia.
            -El botón Resaltar todo, resaltará todas las coincidencias que va encontranto el buscador mientras escribes.
            -El botón Coincidencia de mayúscular y minúsculas, realiza un filtro y encuentra si coinciden las mayúscular y minúsculas con la cadena a encontrar.
            -El botón Palabras completas, busca por coincidencia de palabra completa.

        </p>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light bordered">

                <div style="float: right;" class="form-group ishidden">
                                                
                    <div class="col-md-4">

                        <div class="input-group input-large date-picker input-daterange" data-date="<?= date('d-m-Y') ?>" data-date-format="dd-mm-yyyy">

                            <input value="<?= date('d-m-Y') ?>" id="from-report" type="text" class="form-control" name="from">

                            <span class="input-group-addon"> a </span>

                            <input value="<?= date('d-m-Y') ?>" id="to-report" type="text" class="form-control" name="to"> </div>
                        
                    </div>

                </div>

                <div class="portlet-body flip-scroll">
                       
                    <div class="row">

                        <div class="select-content col-md-12">
                            
                            <div class="col-md-3">

                                <div class="form-body">

                                    <div class="form-group">

                                        <label>Tipo de informe</label>

                                        <select id="tipoinforme" name="tipoinforme" class="form-control">

                                            <option value=""></option>

                                            <optgroup label=Clientes>
                                                <option data-ishidden="0" value="1">Citas positivas</option>
                                                <option data-ishidden="1" value="2">Nuevos</option>
                                                <option data-ishidden="1" value="3">Ofertas</option>
                                                <option data-ishidden="1" value="4">Cierres</option>
                                                <option data-ishidden="0" value="5">Ko</option>
                                                <option data-ishidden="1" value="10">Sin seguimiento</option>
                                                <option data-ishidden="0" value="9">Todo</option>
                                            </optgroup>
                                            
                                            <optgroup label=Registros>
                                                <option data-ishidden="1" value="14">Precontactos</option>
                                                <option data-ishidden="0" value="6">Pospuestos</option>
                                                <option data-ishidden="0" value="7">Interesados</option>
                                                <option data-ishidden="0" value="8">Volver a llamar</option>
                                            </optgroup>

                                            <optgroup label=Incidencias>
                                                <option data-ishidden="1" value="11">Nuevos</option>
                                                <option data-ishidden="1" value="12">Ofertas</option>
                                                <option data-ishidden="1" value="13">Documentación</option>
                                            </optgroup>
                                            

                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3 ishidden">

                                <div class="form-body">

                                    <div class="form-group">

                                        <label>Perfil</label>

                                        <select id="rolReport" name="rolReport" class="form-control">
                                            
                                            <option value=""></option>

                                            <?php foreach ($getRoles as $key => $rol): ?>
                                                
                                                <?php if($rol->getId() == 3 OR $rol->getId() == 4 OR $rol->getId() == 7): ?>

                                                    <option value="<?= $rol->getId() ?>"><?= $rol->getRol() ?></option>

                                                <?php endif ?>
                                            
                                            <?php endforeach ?>

                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3 ishidden">

                                <div class="form-body">

                                   <div class="form-group">

                                        <label>Usuario</label>

                                        <select id="userReport" name="userReport" class="form-control">


                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-2">

                                <div class="form-group">

                                    <button id="gen-info-per" style="margin-top: 23px;" name="submit" class="btn green" type="button">Generar</button>

                                </div>

                            </div>

                        </div>

                        <div id="report-table" class="col-md-12">
                            
                            

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
