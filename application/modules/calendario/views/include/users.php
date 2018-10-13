<div class="mt-checkbox-list">

<?php if($rol == 6 OR $rol == 1 OR $rol == 9 ): ?>

	<?php foreach ($commercialDirector as $key => $cd): ?>

		<label class="mt-checkbox"> <?= $cd->getNombre() ?> <?= $cd->getApellidos() ?>
	        <input class="users users-cd" data-cd="1" value="<?= $cd->getId() ?>" name="user[]" type="checkbox">
	        <span style="background: <?= $cd->getColor() ?>"></span>
	    </label>

	<?php endforeach ?>

	<hr/>

<?php elseif($rol == 4): ?>

	<?php foreach ($commercialDirector as $key => $cd): ?>

		<label class="mt-checkbox"> <?= $cd->getNombre() ?> <?= $cd->getApellidos() ?>
	        <input class="users users-user" data-cd="0" value="<?= $cd->getId() ?>" name="user[]" type="checkbox">
	        <span style="background: <?= $cd->getColor() ?>"></span>
	    </label>

	<?php endforeach ?>

	<hr/>

<?php endif ?>

<?php foreach ($users as $key => $user): ?>

	<?php if($rol == 7): ?>
	
		<label class="mt-checkbox"> <?= $user->getIdusuario()->getNombre() ?> <?= $user->getIdusuario()->getApellidos() ?>
	        <input class="users users-user" data-cd="0" value="<?= $user->getIdusuario()->getId() ?>" name="user[]" type="checkbox">
	        <span style="background: <?= $user->getIdusuario()->getColor() ?>"></span>
	    </label>

    <?php else: ?>

    	<label class="mt-checkbox"> <?= $user->getNombre() ?> <?= $user->getApellidos() ?>
	        <input class="users users-user" data-cd="0" value="<?= $user->getId() ?>" name="user[]" type="checkbox">
	        <span style="background: <?= $user->getColor() ?>"></span>
	    </label>

	<?php endif ?>

<?php endforeach ?>

<?php if($rol == 7): ?>
	
	<hr/>

	<label class="mt-checkbox"> Mi calendario
        <input class="users users-user" data-cd="0" value="<?= $this_user->getId() ?>" name="user[]" type="checkbox">
        <span style="background: <?= $this_user->getColor() ?>"></span>
    </label>

<?php endif ?>
	

</div>
