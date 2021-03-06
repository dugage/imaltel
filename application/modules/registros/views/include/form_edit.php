<form role="form" method="post">

    <?= validation_errors(); ?>

    <div class="form-body">

        <div class="form-group">

            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                <input name="fRegistro" value="<?= $getRegistro->getFregistro()->format('d-m-Y') ?>" type="text" class="form-control" readonly>

                <span class="input-group-btn">

                    <button class="btn default" type="button">

                        <i class="fa fa-calendar"></i>

                    </button>

                </span>

            </div>

        </div>

        <?php if ($rol != 4): ?>

            <div class="form-group">

                <label>Operario</label>

                <select name="usuario" class="form-control">

                    <?php foreach($getUsuarios as $usuario): ?>

                        <option <?php if($getRegistro->getIdusuario()->getId() == $usuario->getId()) echo 'selected' ?> value="<?= $usuario->getId() ?>"><?= $usuario->getNombre() ?> <?= $usuario->getApellidos() ?></option>

                    <?php endforeach ?>

                </select>

            </div>

        <?php endif ?>

        <div class="form-group">

            <label>Empresa</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="empresa" value="<?= $getRegistro->getEmpresa() ?>" class="form-control" placeholder="Nombre de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Número de empleados</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="numEmpleados" value="<?= $getRegistro->getNumempleados() ?>" class="form-control" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Sector</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="sector" value="<?= $getRegistro->getSector() ?>" class="form-control" placeholder="Sector o actividad de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Teléfono</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>

                <input name="telefono" value="<?= $getRegistro->getTelefono() ?>" class="form-control" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Administrador</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="administrador" value="<?= $getRegistro->getAdministrador() ?>" class="form-control" placeholder="Persona que consta como administrador de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Persona de contacto</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="perContacto" value="<?= $getRegistro->getPercontacto() ?>" class="form-control" placeholder="Persona con la que contactar al comunicarnos con la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>CIF</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="cif" value="<?= $getRegistro->getCif() ?>" class="form-control" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Dirección</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="direccion" value="<?= $getRegistro->getDireccion() ?>" class="form-control" placeholder="Dirección fiscal de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Provincia</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="provincia" value="<?= $getRegistro->getProvincia() ?>" class="form-control" placeholder="Provincia de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Población</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="poblacion" value="<?= $getRegistro->getPoblacion() ?>" class="form-control" placeholder="Población de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>CP</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="cp" value="<?= $getRegistro->getCp() ?>" class="form-control" placeholder="Código postal de la empresa" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Correo Electrónico</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                </span>

                <input name="email" value="<?= $getRegistro->getEmail() ?>" class="form-control" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Web</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span>

                <input name="web" value="<?= $getRegistro->getWeb() ?>" class="form-control" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Comentario</label>

            <textarea class="form-control" rows="3" value="<?= $getRegistro->getWeb() ?>" name="comentario"></textarea>

        </div>

        <div class="form-group">

            <button name="submit" class="btn green" type="submit">Guardar</button>

        </div>

    </div>

</form>