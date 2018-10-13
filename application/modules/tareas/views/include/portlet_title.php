<div class="portlet-title"> 

	<?php if($rol == 8): ?>

		<ul class="nav nav-pills">

			<li class="active">

	            <a href="#cierres" data-toggle="tab" aria-expanded="true"> Cierres </a>

	        </li>

	        <li class="">

	            <a href="#coberturas" data-toggle="tab" aria-expanded="true"> Coberturas </a>

	        </li>

		</ul>

	<?php endif ?>

	<?php if($rol == 7): ?>

		<ul class="nav nav-pills">

			<li class="active">

	            <a href="#Updocu" data-toggle="tab" aria-expanded="true"> Subir Documentación <span class="badge badge-danger"> <?= count( $getResult ) ?> </span></a>

	        </li>

	        <li class="">

	            <a href="#Rdocu" data-toggle="tab" aria-expanded="true"> Revisar Documentación <span class="badge badge-danger"> <?= count( $getResultRdocu ) ?> </span></a>

	        </li>

	        <li class="">

	            <a href="#cierres" data-toggle="tab" aria-expanded="true"> Cierres <span class="badge badge-danger"> <?= count( $getResultCierre ) ?> </span></a>

	        </li>

	        <li class="">

	            <a href="#proponerKo" data-toggle="tab" aria-expanded="true"> Proponer Ko <span class="badge badge-danger"> <?= count( $getVerificarKo ) ?> </span></a>

	        </li>

	        <!--<li class="">

	            <a href="#volverLlamar" data-toggle="tab" aria-expanded="true"> Volver a llamar <span class="badge badge-danger"> <?= count( $getVolverLlamar ) ?> </span></a>

	        </li>-->


		</ul>

	<?php endif ?>

</div>
