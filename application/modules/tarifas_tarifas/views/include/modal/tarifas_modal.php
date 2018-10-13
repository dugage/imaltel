<div class="modal fade" id="tarifasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>

            </div>

            <div class="modal-body">

                <form action="<?= site_url('tarifas_tarifas/setOrigen/'.$id) ?>" enctype="multipart/form-data" method="post">


                    <div style="display: none;" id="select-origenes" class="form-group">

                        <label>Origenes</label>

                        <select name="origenes" class="form-control">

                            <?php foreach($getOrigenes as $origen): ?>

                                <option value="<?= $origen->getId() ?>"><?= $origen->getNombre() ?></option>

                            <?php endforeach ?>

                        </select>

                    </div>

                    <div class="form-group">

                        <button name="submit" class="btn green" type="submit">Guardar</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>