<table class="egt">
  <tr>
    <td>ID</td>
    <td>Comercial</td>
    <td>CIF</td>
    <td>Razón social</td>
    <td>Teléfono</td>
    <td>Población</td>
    <td>CP</td>
    <td>Fechas</td>
  </tr>

  <?php foreach ($precontactos as $key => $precontacto): ?>
    
    <tr>
      <td> <?= $precontacto->getId() ?> </td>
      <td> <?= $precontacto->getIdusuario()->getNombre() ?> <?= $precontacto->getIdusuario()->getApellidos() ?></td>
      <td> <?= $precontacto->getCif() ?> </td>
      <td> <?= $precontacto->getNombre() ?> </td>
      <td> <?= $precontacto->getTelefono() ?> </td>
      <td> <?= $precontacto->getPoblacion() ?> </td>
      <td> <?= $precontacto->getCp() ?> </td>
      <td> <?= $precontacto->getFalta()->format('d/m/Y') ?> </td>
    </tr>

  <?php endforeach ?>

</table>