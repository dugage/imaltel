<div class="page-content">
	
	<div class="page-head">

        <?= $this->load->view('include/page_head') ?>

    </div>

    <?= $this->load->view('include/page_breadcrumb') ?>

    <div class="row">

    <!-- EVENTOS PENDIENTES -->

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

            <div class="dashboard-stat2 bordered">

                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">
                            <span data-counter="counterup" data-value="<?= count($eventos) ?>"><?= count($eventos) ?></span>
                            <small class="font-green-sharp"></small>
                        </h3>
                        <small>EVENTOS PENDIENTES</small>
                    </div>
                    <div class="icon">
                        <i class="icon-calendar"></i>
                    </div>
                </div>

                <div class="progress-info">

                    <?php if(count($eventos) > 0): ?>
                        
                        <h3 style="color:#f36a5a" class="font-red-sharp">

                            <i class="icon-bell"></i> Tienes eventos pendientes

                        </h3>
                        
                    <?php else: ?>

                        <h3 style="color:#2ab4c0" class="font-red-sharp">

                            <i class="icon-like"></i> No tienes tareas pendientes

                        </h3>

                    <?php endif ?>

                </div>

            </div>

        </div>

        <!-- TAREAS PENDIENTES -->

    	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

            <div class="dashboard-stat2 bordered">

                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">
                            <span data-counter="counterup" data-value="<?= count($tareas) ?>"><?= count($tareas) ?></span>
                            <small class="font-green-sharp"></small>
                        </h3>
                        <small>TAREAS PENDIENTES</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thumb-tack"></i>
                    </div>
                </div>

                <div class="progress-info">

                    <?php if(count($tareas) > 0): ?>
						
						<h3 style="color:#f36a5a" class="font-red-sharp">

                    		<i class="icon-bell"></i> Tienes tareas pendientes

                    	</h3>
						
					<?php else: ?>

						<h3 style="color:#2ab4c0" class="font-red-sharp">

                    		<i class="icon-like"></i> No tienes tareas pendientes

                    	</h3>

                    <?php endif ?>

                </div>

            </div>

        </div>

        <?php if ($_SESSION['email'] == 'gerencia@multivoz.es'): ?>
            
        <div class="col-md-12">

            <!-- EMPIEZA -->
                <div class="portlet box red">
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                                    <tr>
                                                        <th colspan="46" class="cabecera" style="text-align: center;">ENERO 2018 1º SEMANA</th></tr>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="5">LUNES 25</th>
                                                        <th colspan="5">MARTES 26</th>
                                                        <th colspan="5">MIÉRCOLES 27</th>
                                                        <th colspan="5">JUEVES 28</th>
                                                        <th colspan="5">VIERNES 29</th>
                                                        <th colspan="5">OBJETIVOS</th>
                                                        <th colspan="5">CONSECUCIÓN</th>
                                                        <th colspan="5">QUEDAN</th>
                                                        <th colspan="5">%</th>
                                                    </tr>
                                                    
                                                    <tr class="comercial">
                                                        <td>COMERCIAL</td>
                                                        <!-- LUNES -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- MARTES -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- MIERCOLES -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- JUEVES -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- VIERNES -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- OBJETIVOS -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- CONSECUCION -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- QUEDAN -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                        <!-- TOTAL -->
                                                        <td>N</td><td>OF</td><td>C</td><td>KO</td><td>FRM</td>
                                                    </tr>
                                                
                                                    <?php
                                                    //conexion BBDD
                                                    $conexion = new mysqli('localhost', 'mymultivoz', 'z35B7JDo','multivoz');

                                                    if ( $conexion->connect_errno ) 
                                                    { 
                                                        echo "Fallo al conectar a MySQL: ". $this->_db->connect_error; 
                                                        return;     
                                                    } 

                                                    $sql = "select usuarios.nombre, usuarios.id, cuentasSeguimiento.idEstado from usuarios, cuentasSeguimiento, roles where usuarios.id = cuentasSeguimiento.idUsuario and usuarios.estado = 0 and roles.rol='comercial'";

                                                    $comercialescon = $conexion->query($sql);

                                                    if(!$comercialescon){
                                                        echo "algo fue mal";
                                                    }

                                                    // ids de los comerciales
                                                    $ids = array();
                                                    $filaDeTabla="";

                                                    while($fila = $comercialescon->fetch_object())
                                                    {
                                                        array_push($ids, $fila->id);
                                                    }
                                                    

                                                    // elimino las ids repetidas
                                                    $idsUnicas = array_values(array_unique($ids));

                                                    $oferta = 0;
                                                    $cierre = 0;
                                                    $firmado = 0;
                                                    $ko = 0;
                                                    $nuevo = 0;
                                                    $totales = "";

                                                    //variable que recoge el valor de usuario de la tabla
                                                    $usuario = "";

                                                    $nuevos = "";
                                                    $ofertas = "";
                                                    $cierres = "";
                                                    $firmados = "";
                                                    $kos = "";
                                                    for($x = 0; $x < count($idsUnicas); $x++){
                                                        $sqlUsuario = "select usuarios.nombre from usuarios where usuarios.id = '".$idsUnicas[$x]."';";
                                                        $nombreUsuario = $conexion->query($sqlUsuario);
                                                        
                                                        foreach($nombreUsuario as $fila){
                                                            foreach($fila as $clave=>$valor){
                                                                //almaceno el valor (nombre) en usuario
                                                                $usuario = $valor;
                                                            }                                           
                                                        }
                                                        
                                                        // nombre del comercial
                                                        $filaDeTabla .="<tr><td>$usuario</td>";
                                                        //recorremos la tabla del comercial
                                                        for($dia=25; $dia < 30; $dia++){
                                                            
                                                            //obtengo los datos de los comerciales en la fecha codeAlta
                                                            $sqlSeguimiento = "select cuentasSeguimiento.idEstado from cuentasSeguimiento
                                                                                where cuentasSeguimiento.idUsuario='".$idsUnicas[$x]."'
                                                                                and codeAlta='201801".$dia."';";
                                                            $sqlidSeguimiento = $conexion->query($sqlSeguimiento);

                                                            
                                                            foreach($sqlidSeguimiento as $fila){
                                                                
                                                                foreach($fila as $clave=>$valor){
                                                                    
                                                                    switch($valor){
                                                                        case 2: $oferta++; break;
                                                                        case 4: $cierre++;  break;
                                                                        case 6: $firmado++;  break;
                                                                        case 7: $ko++;  break;
                                                                        case 13: $nuevo++;
                                                                    }

                                                                    
                                                                }
                                                                
                                                            }
                                                            
                                                            $filaDeTabla .="<td>$nuevo</td><td>$oferta</td><td>$cierre</td><td>$ko</td><td>$firmado</td>";
                                                            $nuevos .= strval($nuevo);
                                                            $ofertas .= strval($oferta);
                                                            $cierres .= strval($cierre);
                                                            $kos .= strval($ko);
                                                            $firmados .= strval($firmado);
                                                        }
                                                        
                                                        $filaDeTabla .= "
                                                                <td><input type='text' placeholder='15' size='1' class='dato'/></td>
                                                                <td><input type='text' placeholder='10' size='1' class='dato'/></td>
                                                                <td><input type='text' placeholder='10' size='1' class='dato'/></td>
                                                                <td><input type='text' placeholder='0' size='1' class='dato'/></td>
                                                                <td><input type='text' placeholder='2' size='1' class='dato'/></td>
                                                                <td>0</td><td>0</td><td>0</td><td>0</td><td>0</td>
                                                                <td>0</td><td>0</td><td>0</td><td>0</td><td>0</td>
                                                                <td>0</td><td>0</td><td>0</td><td>0</td><td>0</td></tr>";
                                                        
                                                        $oferta = 0;
                                                        $cierre = 0;
                                                        $firmado = 0;
                                                        $ko = 0;
                                                        $nuevo = 0; 
                                                    
                                                    }
                                                    $arrayTotalOfertas=[];
                                                    $arrayTotalCierres=[];
                                                    $arrayTotalFirmados=[];
                                                    $arrayTotalKos=[];
                                                    $arrayTotalNuevos=[];
                                                    

                                                    // columnas de ofertas
                                                    $f=$ofertas[0];
                                                    $contador=0;
                                                    
                                                    for($c=1; $c<strlen($ofertas); $c++){
                                                        if($c % 5 == 0){
                                                            
                                                            $arrayTotalOfertas[] = $f;
                                                            $f="";
                                                            
                                                        }
                                                        $f .= $ofertas[$c]; 
                                                        if($c == 89){
                                                            $arrayTotalOfertas[] = $f;
                                                        }
                                                    }

                                                    // columnas de cierres
                                                    unset($f);
                                                    $f=$cierres[0];
                                                    $contador=0;
                                                    
                                                    for($c=1; $c<strlen($cierres); $c++){
                                                        if($c % 5 == 0){
                                                            
                                                            $arrayTotalCierres[] = $f;
                                                            $f="";
                                                            
                                                        }
                                                        $f .= $cierres[$c]; 
                                                        if($c == 89){
                                                            $arrayTotalCierres[] = $f;
                                                        }
                                                    }

                                                    // columnas de firmados
                                                    unset($f);
                                                    $f=$firmados[0];
                                                    $contador=0;
                                                    
                                                    for($c=1; $c<strlen($firmados); $c++){
                                                        if($c % 5 == 0){
                                                            
                                                            $arrayTotalFirmados[] = $f;
                                                            $f="";
                                                            
                                                        }
                                                        $f .= $firmados[$c];    
                                                        if($c == 89){
                                                            $arrayTotalFirmados[] = $f;
                                                        }
                                                    }

                                                    // columnas de kos
                                                    unset($f);
                                                    $f=$kos[0];
                                                    $contador=0;
                                                    
                                                    for($c=1; $c<strlen($kos); $c++){
                                                        if($c % 5 == 0){
                                                            
                                                            $arrayTotalKos[] = $f;
                                                            $f="";
                                                            
                                                        }
                                                        $f .= $kos[$c]; 
                                                        if($c == 89){
                                                            $arrayTotalKos[] = $f;
                                                        }
                                                    }

                                                    // columnas de nuevos
                                                    unset($f);
                                                    $f=$nuevos[0];
                                                    $contador=0;
                                                    
                                                    for($c=1; $c<strlen($nuevos); $c++){
                                                        if($c % 5 == 0){
                                                            
                                                            $arrayTotalNuevos[] = $f;
                                                            $f="";
                                                            
                                                        }
                                                        $f .= $nuevos[$c];  
                                                        if($c == 89){
                                                            $arrayTotalNuevos[] = $f;
                                                        }
                                                    }
                                                    
                                                    $sumaOfertas = 0;
                                                    $sumaCierres = 0;
                                                    $sumaFirmados= 0;
                                                    $sumaKos = 0;
                                                    $sumaNuevos = 0;
                                                    
                                                    for($c = 0; $c < 5; $c++){
                                                        for($f = 0; $f < count($idsUnicas) - 1; $f++){
                                                            $sumaNuevos += $arrayTotalNuevos[$f][$c];
                                                            $sumaOfertas += $arrayTotalOfertas[$f][$c];
                                                            $sumaCierres += $arrayTotalCierres[$f][$c];
                                                            $sumaKos += $arrayTotalKos[$f][$c];
                                                            $sumaFirmados += $arrayTotalFirmados[$f][$c];
                                                        }
                                                        $totales .= "<td>".$sumaNuevos."</td><td>".$sumaOfertas."</td><td>".$sumaCierres."</td><td>".$sumaKos."</td><td>".$sumaFirmados."</td>";

                                                        $sumaNuevos = 0;
                                                        $sumaOfertas = 0;
                                                        $sumaCierres = 0;
                                                        $sumaFirmados= 0;
                                                        $sumaKos = 0;
                                                    }
                                                    
                                                    $filaDeTabla.= "
                                                    <tr><td>TOTALES</td>".$totales."
                                                    
                                                    <td>15</td><td>10</td><td>10</td><td>0</td><td>2</td>
                                                    <td>0</td><td>0</td><td>0</td><td>0</td><td>0</td>
                                                    <td>0</td><td>0</td><td>0</td><td>0</td><td>0</td>
                                                    <td>0</td><td>0</td><td>0</td><td>0</td><td>0</td>
                                                    </tr>
                                                    </table>";
                                                    echo $filaDeTabla;
                                                    
                                                    ?>
                        </div>
                    </div>
                </div>

            <!-- TERMINA -->

        </div>

        <?php endif ?>

    </div>

</div>

