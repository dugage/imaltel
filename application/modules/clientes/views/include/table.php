<table class="table table-bordered table-striped table-condensed flip-content">

    <thead class="flip-content">
    <tr>
        <?php foreach ($thead as $th): ?>
            <th width="20%"> <?= $th ?> </th>
        <?php endforeach ?>
        <th width="20%">Acciones</th>
    </tr>
    </thead>

    <tbody>
        
        <?php $noSeguimiento = false ?>

        <?php foreach ($getResult['result'] as $result): ?>
            
            <?php if( $result->getId() > 0 ): ?>

                <?php 

                    $isTrue = true;

                    if( $this->session->userdata('rol') == 3 ) {

                        $thisSeguimiento = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $result->getId(),"actual" => 1]);
                    

                        if($thisSeguimiento) {

                            if($thisSeguimiento->getTipo() == "Ko" OR $thisSeguimiento->getTipo() == "Firmado") {

                                $isTrue = false;
                            }
                        }

                    }
                ?>
                
                
                <?php if($isTrue): ?>

                <tr>
                    <td> <?= $result->getId() ?> </td>
                    <td> <?= $result->getNombre() ?> </td>
                    <td> <?= $result->getPoblacion() ?> </td>
                    <td> <?= $result->getTelefono() ?> </td>

                    <td> 
                        
                        <?php if($result->getCuentasseguimiento()): ?>

                            <?php foreach ($result->getCuentasseguimiento() as $key => $seguimiento): ?>
                                
                                <?php if($seguimiento->getActual() == 1): ?>
                                    
                                    <button class="btn btn-danger mt-sweetalert" data-title="Sweet Alerts" data-message="Beautiful popup alerts" data-allow-outside-click="true" data-confirm-button-class="btn-danger"><?= $seguimiento->getTipo() ?></button>

                                <?php endif ?>

                            <?php endforeach ?>
                        
                        <?php $noSeguimiento = false ?>

                        <?php else: ?>
                        
                        <?php $noSeguimiento = true ?>

                        <button class="btn btn-default mt-sweetalert" data-title="Sweet Alerts" data-message="Beautiful popup alerts" data-allow-outside-click="true" data-confirm-button-class="btn-default">Sin seguiminento</button>


                        <?php endif ?>

                    </td>

                    <td>

                    <?php if($rol == 3): ?>

                        <a title="Ver" href="<?= site_url($path.'/edit/'.$result->getId()) ?>" class="btn green" type="button"><i class=" icon-eye "></i></a>

                    <?php elseif( $rol == 4 ): ?>
                        
                        <a title="Editar" href="<?= site_url($path.'/edit/'.$result->getId()) ?>" class="btn yellow" type="button"><i class=" icon-pencil "></i></a>

                        <?php if( $noSeguimiento ): ?>

                            <a title="Registro" href="<?= site_url($path.'/getRegistro/'.$result->getId()) ?>" class="btn blue" type="button"><i class=" icon-notebook "></i></a>

                        <?php endif ?>

                    <?php else: ?>

                        <a title="Editar" href="<?= site_url($path.'/edit/'.$result->getId()) ?>" class="btn yellow" type="button"><i class=" icon-pencil "></i></a>

                    <?php endif ?>

                        <!--<a title="Eliminar" href="<?= site_url($path.'/delete/'.$result->getId()) ?>" class="btn red" type="button"><i class="icon-trash "></i></a>-->
                    </td>

                </tr>

                <?php endif ?>

            <?php endif ?>

        <?php endforeach ?>

    </tbody>

</table>