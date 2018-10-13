<form role="form" method="post">

    <?= validation_errors(); ?>

    <div class="form-body">

        <div class="form-group">

            <label>Grupo</label>

            <select name="Targrupo" class="form-control">

                <option value="">Selecciona un Grupo</option>

                <?php foreach($getGruposTarifas as $grupo): ?>

                    <option value="<?= $grupo->getId() ?>"><?= $grupo->getNombre() ?></option>

                <?php endforeach ?>

            </select>

        </div>

        <div class="form-group">

            <label>Nombre</label>

            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-pencil"></i>
                </span>

                <input name="nombre" value="" class="form-control" placeholder="Nombre de la tarifa" type="text">

            </div>

        </div>

        <div class="form-group">

            <button name="submit" class="btn green" type="submit">Guardar</button>

        </div>

    </div>

</form>