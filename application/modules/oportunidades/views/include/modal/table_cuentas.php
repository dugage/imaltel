<thead>

	<tr>

		<th scope="col"> Nombre de cuenta </th>
		<th scope="col"> Teléfono </th>
		<th scope="col"> Email </th>
		<th scope="col"> Asignado a </th>
		<th scope="col"> Persona de contacto </th>
		<th scope="col"> Notificar propietario </th>
		<th scope="col"> Población (Factura) </th>

	</tr>

</thead>

<tbody>

<?php foreach ($getCuentas as $key => $cuenta): ?>
    
    <tr>
        <td> <?= $cuenta->getNombre() ?> </td>
        <td> <?= $cuenta->getTelefono() ?> </td>
        <td> <?= $cuenta->getEmail() ?> </td>
        <td> <?= $cuenta->getIdusuario()->getNombre() ?> <?= $cuenta->getIdusuario()->getApellidos() ?> </td>
        <td> <?= $cuenta->getPersonacnt() ?> </td>
        <td>
          
          <?php if($cuenta->getNotipro() == 0): ?>
            
            NO 

          <?php elseif($cuenta->getNotipro() == 1): ?>

            SI

          <?php endif ?>

        </td>
        <td> <?= $cuenta->getPoblacion() ?> </td>  

        <td> 
            <a id="<?= $cuenta->getId() ?>" title="Seleccionar cuenta" href="#" class="btn green select-account" type="button"><i class="icon-plus"></i></a>
        </td>  

    </tr>

<?php endforeach ?>

</tbody>
