<!DOCTYPE html>

<html lang="es">
	<head>

		<?php

			$meta = array(
		        array('name' => 'robots', 'content' => $robots),
		        array('name' => 'title', 'content' => $title),
		        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
		    );

		?>

		<?=  meta($meta); ?>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<?= link_tag('assets/global/plugins/font-awesome/css/font-awesome.min.css') ?>
		<?= link_tag('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') ?>
		<?= link_tag('assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>
		<?= link_tag('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') ?>
		<?= link_tag('assets/global/css/components.min.css') ?>
		<?= link_tag('assets/global/css/plugins.min.cs') ?>
		<?= link_tag('assets/pages/css/error.min.css') ?>

		<title><?= $title; ?></title>

	</head>

	<body class=" page-404-full-page" cz-shortcut-listen="true">

		<div class="row">

			<div class="col-md-12 page-404">

                <div class="number font-red"> <?= $error_type ?> </div>

                <div class="details">

                    <h3><?= $error_title ?></h3>

                    <p> <?= $error_text ?><br>

                        <a href="javascript:window.history.back();"> Volver al módulo anterior</a>.

                     </p>

                </div>

            </div>

		</div>

	</body>

</html>