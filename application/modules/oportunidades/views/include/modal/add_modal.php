<div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="add-modal">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Creación Rápida Cuenta</h4>

      </div>

      <div class="modal-body">

        <form enctype="multipart/form-data" role="form" method="post">

            <div class="row">

              <div class="col-md-6">

                  <div class="form-body">

                      <div class="form-group">

                          <label><span style="color:red">*</span> Nombre de Cuenta</label>

                          <div class="input-group">

                              <span class="input-group-addon">

                                  <i class="fa fa-pencil"></i>

                              </span>

                              <input name="nombre" value="<?= set_value('nombre'); ?>" class="form-control" type="text">

                          </div>

                      </div>

                  </div>

              </div>

              <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Teléfono</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="telefono" value="<?= set_value('telefono'); ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

              </div>


            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Teléfono alternativo</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="telefonoAlt" value="<?= set_value('telefonoAlt'); ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Email</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="email" value="<?= set_value('email'); ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label><span style="color:red">*</span> CIF</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="cif" value="<?= set_value('cif'); ?>" class="form-control" type="text">

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

                                <option value="<?= $usuario->getId() ?>"><?= $usuario->getNombre() ?> <?= $usuario->getApellidos() ?></option>

                            <?php endforeach ?>

                        </select>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-body">

                    <div class="form-group">

                        <label>Persona de Contacto</label>

                        <div class="input-group">

                            <span class="input-group-addon">

                                <i class="fa fa-pencil"></i>

                            </span>

                            <input name="personaCnt" value="<?= set_value('personaCnt'); ?>" class="form-control" type="text">

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-6" style="padding-top: 20px; padding-bottom: 0px;">

                <div class="form-body">

                    <div class="form-group">

                        <div class="mt-checkbox-list">

                            <label class="mt-checkbox mt-checkbox-outline">

                                <input name="notiPro" type="checkbox">
                                Notificar Propietario
                                <span></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Direcciónv (factura)</label>

                    <textarea name="direccion" value="" class="form-control"><?= set_value('direccion'); ?></textarea>

                </div>

            </div>

        </div>

        <br><br>
        <div class="col-md-6" style="margin-bottom: 40px; margin-top:0px;">

            <div class="form-body">

                <div class="form-group">

                    <label>Población (factura)</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="poblacion" value="<?= set_value('poblacion'); ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Provicia (factura)</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="provincia" value="<?= set_value('provincia'); ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>
        <div class="col-md-6">

            <div class="form-body">

                <div class="form-group">

                    <label>Código Postal (factura)</label>

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="fa fa-pencil"></i>

                        </span>

                        <input name="cp" value="<?= set_value('cp'); ?>" class="form-control" type="text">

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-body">
                <div class="form-group">

                    <button name="cuenta" class="btn green" type="submit">Crear Cuenta</button>

                </div>
            </div>
        </div>

            </div>

        </form>

      </div>

    </div>

  </div>

</div>