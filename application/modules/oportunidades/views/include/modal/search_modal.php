<div class="modal fade search-modal" tabindex="-1" role="dialog" aria-labelledby="search-modal">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Cuentas</h4>

      </div>

      <div class="modal-body">

      <div style="padding-left: 0; margin-bottom: 10px;" class="col-md-7">

      		<form class="form-inline"> 

				<div class="form-group">

					<input type="text" class="form-control" id="q" placeholder="Escribe para buscar"> 

				</div> 

				<div class="form-group"> 

					<select id="param" class="form-control">
              <option value="nombre">Nombre de cuenta</option>
              <option value="telefono">Teléfono</option>
              <option value="email">Email</option>
              <option value="personacnt">Persona de contacto</option>
              <option value="poblacion">Población</option>
              <option value="poblacion"></option>
          </select>

				</div>

				<button entity="Cuentas" type="button" class="btn btn-default btn-search"><i class="fa fa-search" aria-hidden="true"></i>
				</button> 

			</form>

      </div>

      <div style="padding-right: : 0; margin-bottom: 10px; float: right; text-align: right;" class="col-md-5">

		1 a <?= $max ?> de <?= $totalCuentas ?>

		<button entity="Cuentas" start="0" max="<?= $max ?>" type="button" class="btn btn-default btn-pagination bnt-previous"><i class="fa fa-chevron-left" aria-hidden="true"></i>
</i>
				</button> 


		<button entity="Cuentas" start="<?= $max ?>" max="<?= $max ?>" type="button" class="btn btn-pagination btn-default bnt-next"><i class="fa fa-chevron-right" aria-hidden="true"></i>
				</button> 

      </div>

        <div class="table-scrollable">        	

        	<table id="listado-cuentas" class="table table-striped table-bordered table-hover">

        	   <?= $this->load->view('include/modal/table_cuentas') ?>
        		
        	</table>

        </div>

      </div>

    </div>

  </div>

</div>