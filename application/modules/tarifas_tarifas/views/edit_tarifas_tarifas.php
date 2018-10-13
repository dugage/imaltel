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

                    <?= $this->load->view('include/form_edit') ?>

                </div>

            </div>

        </div>

        <div class="col-md-12">

            <div class="portlet light bordered">

                <div class="portlet-title">

                    Configurador
                    
                </div>

                <div class="portlet-body flip-scroll">

                   <table class="table table-hover table-light config-tarifa">

                        <thead>

                            <tr class="uppercase">
                                
                                <th> 

                                    Orignen <a data-idtarifa="<?= $getRow->getId() ?>" data-toggle="modal" data-target="#tarifasModal" data-action="origen" class="btn dark btn-sm btn-outline sbold uppercase tarifasModal"><i class="fa fa-plus"></i></a>

                                </th>

                                <th> Terminal </th>

                                 <th> Paquete </th>

                                 <th> Comisión </th>

                                 <th> Acciones </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if($getCofigurations): ?>
                                
                                <?php foreach($getCofigurations as $config): ?>

                                    <tr>

                                        <td> <?= $config->getIdorigen()->getNombre() ?> </td>

                                        <td>

                                             <select field="idTerminal" table="tarConfigurador" key="<?= $config->getId() ?>" name="terminales" class="form-control md-select">
                                                
                                                <option value="0">Sin terminal</option>

                                                 <?php foreach($getTerminales as $terminal): ?>

                                                    <option <?php if($terminal->getId() ==  $config->getIdterminal()) echo 'selected' ?> value="<?= $terminal->getId() ?>"><?= $terminal->getNombre() ?></option>

                                                <?php endforeach ?>

                                            </select>  
                                           
                                        </td>

                                        <td> 

                                            <select field="idPaquete" table="tarConfigurador" key="<?= $config->getId() ?>" name="paquetes" class="form-control md-select">
                                                
                                                <option value="0">Sin paquete</option>

                                                 <?php foreach($getPaquetes as $paquete): ?>

                                                    <option <?php if($paquete->getId() ==  $config->getIdpaquete()) echo 'selected' ?> value="<?= $paquete->getId() ?>"><?= $paquete->getNombre() ?></option>

                                                <?php endforeach ?>

                                            </select> 

                                        </td>

                                        <td> 

                                            <input field="comision" table="tarConfigurador" key="<?= $config->getId() ?>" type="text" value="<?= $config->getComision() ?>" name="comision" class="comision-tarifa md-decimal" />
                                           
                                        </td>

                                        <td> 

                                            <a title="Copiar" href="<?= site_url('tarifas_tarifas/copyItem/'.$config->getId().'/'.$id) ?>" class="btn yellow" type="button"><i class=" fa fa-files-o  "></i></a>

                                            <a title="Eliminar" href="<?= site_url('tarifas/tarifas/delete/'.$config->getId().'/'.$id) ?>" class="btn red" type="button"><i class="icon-trash "></i></a>
                                           
                                        </td>

                                    </tr>

                                <?php endforeach ?>

                            <?php endif ?>

                        </tbody>


                   </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->load->view('include/modal/tarifas_modal') ?>