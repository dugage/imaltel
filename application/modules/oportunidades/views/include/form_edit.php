<form enctype="multipart/form-data" role="form" method="post">

    <?= validation_errors(); ?>

    <div class="form-body">

        <div class="form-group">

            <label>Nombre</label>

            <div class="input-group">

                <span class="input-group-addon">

                    <i class="fa fa-pencil"></i>

                </span>

                <input name="nombre" value="<?= $getRow->getNombre() ?>" class="form-control" placeholder="Nombre del usuario" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Apellidos</label>

            <div class="input-group">

                <span class="input-group-addon">

                    <i class="fa fa-pencil"></i>

                </span>

                <input name="apellidos" value="<?= $getRow->getApellidos() ?>" class="form-control" placeholder="Apelldos del usuario" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Fecha de nacimiento</label>

            <div class="input-group">

                <span class="input-group-addon">

                    <i class="fa fa-calendar"></i>

                </span>

                <input id="mask_date" name="fnacimiento" value="<?php if($getRow->getFnacimiento() != null) echo $getRow->getFnacimiento()->format("d/m/Y") ?>" class="form-control" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Rol</label>

            <select name="rol" class="form-control">

                <option value="">Selecciona un Rol</option>

                <?php foreach($roles as $rol): ?>

                    <option <?php if($getRow->getIdrol()->getId() == $rol->getId()) echo 'selected' ?> value="<?= $rol->getId() ?>"><?= $rol->getRol() ?></option>

                <?php endforeach ?>

            </select>

        </div>

        <div class="form-group">

            <label>Imagen</label>

            <div class="input-group">

                <input name="image" id="exampleInputFile" type="file">

            </div>

            <div class="clearfix margin-top-10">

                <span class="label label-danger">NOTA!</span> El formato de la imagen jpg/gif/png. Tamaño 200px × 200px píxeles y un peso máximo de 200KB.

            </div>

        </div>

        <div class="form-group">

            <label>Email</label>

            <div class="input-group">

                <span class="input-group-addon">

                    <i class="fa fa-envelope"></i>

                </span>

                <input name="email" value="<?= $getRow->getEmail() ?>" class="form-control" placeholder="nombre@dominio.com" type="text">

            </div>

        </div>

        <div class="form-group">

            <label>Contraseña</label>

            <div class="input-group">

                <span class="input-group-addon">

                    <i class="fa fa-lock"></i>

                </span>

                <input name="pass" value="" class="form-control pass" type="text">

            </div>

        </div>

        <div class="form-group">

            <button class="btn btn-circle red btn-sm get-pass" type="button">Generar contraseña segura</button>

        </div>

        <div class="form-group">

            <button name="submit" class="btn green" type="submit">Guardar</button>

        </div>

    </div>

</form>