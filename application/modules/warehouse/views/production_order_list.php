		        <div class="panel panel-default">
		        	<div class="panel-body">
		        		<div class="row">
		        			<div class="col-sm-7">

		        				<?php echo form_open('', 'class="form-inline"') ?>

		        				<div class="form-group">
		        					<label class="" for="from_date"><?php echo display('from') ?></label>
		        					<input type="text" name="from_date" class="form-control datepicker" id="from_date" value="" placeholder="<?php echo display('start_date') ?>">
		        				</div>

		        				<div class="form-group">
		        					<label class="" for="to_date"><?php echo display('to') ?></label>
		        					<input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="">
		        				</div>

		        				<button type="button" id="btn-filter" class="btn btn-success"><?php echo display('find') ?></button>

		        				<?php echo form_close() ?>
		        			</div>

		        		</div>
		        	</div>


		        </div>




		        <!-- Manage Purchase report -->
		        <div class="row">
		        	<div class="col-sm-12">
		        		<div class="panel panel-bd lobidrag">

		        			<div class="panel-body">
		        				<div class="table-responsive">
		        					<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="ProdOrderList">
		        						<thead>
		        							<tr>
		        								<th><?php echo display('sl') ?></th>
		        								<th><?php echo display('purchase_id') ?></th>
		        								<th><?php echo display('purchase_date') ?></th>
		        								<th><?php echo display('total_ammount') ?></th>
		        								<th><?php echo display('action') ?></th>
		        							</tr>
		        						</thead>
		        						<tbody>
		        							<?php foreach ($total_purhcase as $key => $purchase) { ?>
		        							<tr>
		        								<td><?php echo $key+1; ?></td>
		        								<td><?php echo $purchase['production_id'] ?></td>
		        								<td><?php echo $purchase['po_date'] ?></td>
		        								<td><?php echo $purchase['grand_total_amount'] ?></td>
		        								<td>
		        									<a href="<?php echo $base_url."production_details/".$purchase['production_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Production Details"><i class="fa fa-window-restore" aria-hidden="true"></i></a>

		        									<!-- <a href="<?php echo $base_url; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title=" display('update')"><i class="fa fa-pencil" aria-hidden="true"></i></a></td> -->
		        							</tr>	
		        							<?php } ?>
		        						</tbody>
		        						
		        					</table>
		        				</div>

		        			</div>
		        		</div>
		        	</div>
		        	<input type="hidden" id="total_purchase_no" value="<?php echo $total_purhcase; ?>" name="">
		        	<input type="hidden" id="currency" value="<?php echo $currency; ?>" name="">
		        </div>
		        <!-- <script src="<?php echo base_url() ?>my-assets/js/admin_js/purchase_order.js" type="text/javascript"></script> -->