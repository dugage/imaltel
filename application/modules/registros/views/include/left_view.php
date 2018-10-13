<form role="form" method="post">

    <div class="form-body">

        <div class="form-group">

            <label>Razón social</label>

            <div class="input-group col-md-12">

                <input table="registros" field="empresa" key="<?= $id ?>" name="empresa" value="<?= $getRegistro->getEmpresa() ?>" class="form-control md-text" placeholder="Nombre de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label><span style="color:red;">*</span>CIF</label>

            <div class="input-group col-md-12">

                <input style="width: 94%;" table="registros" field="cif" key="<?= $id ?>" name="cif" value="<?= $getRegistro->getCif() ?>" class="form-control cif" type="text">

                <a style="position: absolute;margin-left: 10px;cursor: pointer;" class="btn btn-circle btn-icon-only btn-default check-cif" data-ischeck="0">
                                                                <i class="fa fa-check"></i>
                                                            </a>

            </div>

        </div>

        <div class="form-group">

            <label>Número de empleados</label>

            <div class="input-group col-md-12">

                <input table="registros" field="numEmpleados" key="<?= $id ?>" name="numEmpleados" value="<?= $getRegistro->getNumempleados() ?>" class="form-control md-text" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Sector</label>

            <div class="input-group col-md-12">

                <input table="registros" field="    sector" key="<?= $id ?>" name="sector" value="<?= $getRegistro->getSector() ?>" class="form-control md-text" placeholder="Sector o actividad de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label><span style="color:red;">*</span>Teléfono</label>

            <div class="input-group col-md-12">

                <input table="registros" field="telefono" key="<?= $id ?>" name="telefono" value="<?= $getRegistro->getTelefono() ?>" class="form-control md-text" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Móvil</label>

            <div class="input-group col-md-12">

                <input table="registros" field="movil" key="<?= $id ?>" name="movil" value="<?= $getRegistro->getMovil() ?>" class="form-control md-text" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Administrador</label>

            <div class="input-group col-md-12">

                <input table="registros" field="administrador" key="<?= $id ?>" name="administrador" value="<?= $getRegistro->getAdministrador() ?>" class="form-control md-text" placeholder="Persona que consta como administrador de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label><span style="color:red;">*</span>Persona de contacto</label>

            <div class="input-group col-md-12">

                <input table="registros" field="perContacto" key="<?= $id ?>" name="perContacto" value="<?= $getRegistro->getPercontacto() ?>" class="form-control md-text" placeholder="Persona con la que contactar al comunicarnos con la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label><span style="color:red;">*</span>Dirección</label>

            <div class="input-group col-md-12">

                <input table="registros" field="direccion" key="<?= $id ?>" name="direccion" value="<?= $getRegistro->getDireccion() ?>" class="form-control md-text" placeholder="Dirección fiscal de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Provincia</label>

            <div class="input-group col-md-12">

                <input table="registros" field="provincia" key="<?= $id ?>" name="provincia" value="<?= $getRegistro->getProvincia() ?>" class="form-control md-text" placeholder="Provincia de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Población</label>

            <div class="input-group col-md-12">

                <input table="registros" field="poblacion" key="<?= $id ?>" name="poblacion" value="<?= $getRegistro->getPoblacion() ?>" class="form-control md-text" placeholder="Población de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label><span style="color:red;">*</span>CP</label>

            <div class="input-group col-md-12">

                <input table="registros" field="cp" key="<?= $id ?>" name="cp" value="<?= $getRegistro->getCp() ?>" class="form-control md-text" placeholder="Código postal de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Correo Electrónico</label>

            <div class="input-group col-md-12">

                <input table="registros" field="email" key="<?= $id ?>" name="email" value="<?= $getRegistro->getEmail() ?>" class="form-control md-text" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Web</label>

            <div class="input-group col-md-12">

                <input table="registros" field="web" key="<?= $id ?>" name="web" value="<?= $getRegistro->getWeb() ?>" class="form-control md-text" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Comentario</label>

            <textarea table="registros" field="comentario" key="<?= $id ?>" class="form-control md-text" rows="3" value="<?= $getRegistro->getWeb() ?>" name="comentario"></textarea>

        </div>

    </div>

</form>