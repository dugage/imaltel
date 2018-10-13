<div class="tab-pane fade" id="Reportes">
    
    <div class="row">

	    
		<div class="portlet light">

		    <?= validation_errors(); ?>
			
			<?php if ($getTarea): ?>

				<div class="alert alert-warning" role="alert">

					Este cliente tiene abierta una tarea pendiente de ejecutar por parte de <strong><?= $getTarea->getIdusuarioto()->getNombre() ?> <?= $getTarea->getIdusuarioto()->getApellidos() ?></strong>.<br/> Fecha de alta de la tarea: <strong><?= $getTarea->getFalta()->format('d/m/Y') ?></strong><br/>
					Esta tarea lleva abierta: <?= between_dates(date('d-m-Y'),$getTarea->getFalta()->format('d-m-Y')) ?> días<br/>
					El estado del cliente es: <strong><?= $thisCuentasSeguimiento->getIdestado()->getNombre() ?></strong><br/>
					
					<?php if ($getTarea->getTipo() == "Rdocu"): ?>

						¿Que hay que hacer con esta tarea? 

						<strong>
						
							<?= $accionesTareas[$getTarea->getTipo()] ?>
							
						</strong>

					<?php else: ?>

						<?php if (isset($accionesTareas[$thisCuentasSeguimiento->getIdestado()->getNombre()])): ?>

							¿Que hay que hacer con esta tarea? 

							<strong>
							
								<?= $accionesTareas[$thisCuentasSeguimiento->getIdestado()->getNombre()] ?>
								
							</strong>

						<?php endif ?>

					<?php endif ?>

				</div>

			<?php endif ?>
		    

		    <div class="portlet-title">

		        <h3>Reportes</h3>

		    </div>

		    <form action="<?= site_url('clientes/edit/'.$id.'#Reportes') ?>" role="form" method="post">

		    	<input type="hidden" name="agendarTipo" value="Cierre" />
		    	<input type="hidden" name="toperador" value="<?= $getRow->getIdusuario()->getId() ?>" />
		    	<input type="hidden" name="comercial" value="<?= $getRow->getIdcomercial() ?>" />

			    <div class="portlet-body flip-scroll">

			        <div class="row">

			            <div class="col-md-12">

			            	<div <?php if( $rol == 3 OR $rol == 4 ) echo 'style="display: none;"' ?>  class="form-body">

			                    <div class="form-group">

			                        <label><span style="color:red">*</span>Tipo de reporte</label>

			                        <select name="tipo-reporte" class="form-control estadoSeguimiento">

			                        	<option value="Reportar">Reportar</option>
										
										<option <?php if($getTareAusente OR $disableAusente) echo 'disabled' ?> value="1">Ausente(reconcertar TMK)</option>

										<option value="Volver a llamar">Volver a llamar (DIRECTOR COMERCIAL)</option>

										<option value="2">Fac.Recogida (verificar tmk)</option>

										<option value="Oferta 1">Entrega de oferta (evento para comercial)</option>

										<option value="Oferta 2">Oferta 2 (evento para comercial)</option>

										<option value="Oferta 3">Oferta 3 (evento para comercial)</option>

										<option <?php if( documents_control($id) ) echo 'disabled' ?> value="Cierre">Cita cierre (evento para comercial)</option>
										
										<?php //if( $thisCuentasSeguimiento->getIdestado()->getNombre() == 'Firmado' ) echo 'disabled' ?>

										<option value="Firmado">Firmado (admon)</option>
										
										<option <?php if( $tipoSeguimiento == 'Ko' OR $getTareaProponerKo ) echo 'disabled' ?> value="ProponerKo">Proponer Ko (Tare pasar ko Coordinador)</option>

			                        </select>

			                    </div>

			                </div>

			                <!--<div class="form-body">

			                    <div class="form-group">

			                        <label><span style="color:red">*</span>Tipo de reporte</label>
			  
			                        <select name="tipo-reporte" class="form-control">

										<?php foreach ($getEstadosSeguimiento as $key => $estado): ?>
                
							                <option <?php if(set_value('tipo-reporte') == $estado->getId()) echo 'selected' ?> value="<?= $estado->getId() ?>"><?= $estado->getNombre()?></option>

							            <?php endforeach ?>

			                        </select>

			                    </div>

			                </div>-->

			            </div>

			            <div style="display: none;" class="content-agendar col-md-12">

			            	<div class="form-group date-content">

                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-week-start="1" data-date-language="es">

                                    <input name="fEvent" value="<?= date('d-m-Y') ?>" type="text" class="form-control" readonly>

                                    <span class="input-group-btn">

                                        <button class="btn default" type="button">

                                            <i class="fa fa-calendar"></i>

                                        </button>

                                    </span>

                                </div>

                            </div>

                            <div class="form-group hour-content">

                                <label>Hora</label>

                                <div class="input-group">

                                    <input name="hEvent" value="<?= date("H:i:s") ?>" type="text" class="form-control timepicker timepicker-24">

                                    <span class="input-group-btn">

                                        <button class="btn default" type="button">

                                            <i class="fa fa-clock-o"></i>

                                        </button>

                                    </span>

                                </div>

                            </div>

			            </div>
			            
			            <div class="col-md-12">

				            <div class="form-body">

			                    <div class="form-group">

			                        <label><span style="color:red">*</span>Reporte</label>

			                        <textarea name="text-reporte" class="form-control"><?= set_value('text-reporte'); ?></textarea>

			                    </div>

			                </div>

			             </div>
						
			             <div class="col-md-12">

				            <div class="form-group">

			                    <button name="submit-reporte" class="btn green" type="submit">Reportar</button>

			                </div>

			            </div>

			        </div>

			    </div>

		    </form>
			
			<?php if($getReports): ?>

			    <div class="portlet-title">
					<h4>Listado de reportes</h4>
				</div>

				<div class="mt-comments">

				<?php foreach ($getReports as $key => $report): ?>

					<div class="mt-comment">

						<div class="mt-comment-img">
		                	
		                	<?php if($report->getIdusuario()->getImg() != null): ?>

						        <img width="45" class="page-lock-img" src="<?= base_url('assets/pages/media/users/'.$report->getIdusuario()->getImg()) ?>" alt="avatar">

						    <?php else: ?>

						        <img width="45" class="page-lock-img" src="<?= base_url('assets/pages/media/profile/avatar.png') ?>" alt="avatar">

						    <?php endif ?>

		                </div>

		                <div class="mt-comment-body">

		                	<div class="mt-comment-info">
		                        <span class="mt-comment-author"><?= $report->getIdusuario()->getNombre() ?> <?= $report->getIdusuario()->getApellidos() ?></span>
		                        <span class="mt-comment-date"><?= $report->getFreporte()->format('d/m/Y H:i') ?></span>
		                    </div>

		                    <div class="mt-comment-text"> 
		                    	<?= $report->getComentario() ?> 
		                    </div>

		                </div>

					</div>

					<?php endforeach ?>

				</div>

			<?php endif ?>

		</div>


    </div>

</div>