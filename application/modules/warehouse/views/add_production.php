
<script src="<?php echo base_url()?>my-assets/js/admin_js/producttion_wh.js" type="text/javascript"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('add_purchase') ?></h4>
                </div>
            </div>

            <div class="panel-body">
            <?php echo form_open_multipart('warehouse/warehouse/bdtask_save_production_order',array('class' => 'form-vertical', 'id' => 'insert_purchase','name' => 'insert_purchase'))?>
                

                <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group row">
                            <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('transfer_to') ?>
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-6">
                                <select name="branch_id" id="supplier_id" class="form-control " required="" tabindex="1"> 
                                    <option value=" "><?php echo display('select_one') ?></option>
                                    <?php foreach($branches as $branche){?>
                                    <option value="<?php echo $branche['id']?>"><?php echo $branche['branch_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                          <?php if($this->permission1->method('add_supplier','create')->access()){ ?>
                            <div class="col-sm-2">
                                <a class="btn btn-success" title="Add New Supplier" href="<?php echo base_url('add_supplier'); ?>"><i class="fa fa-user"></i></a>
                            </div>
                        <?php }?>
                        </div> 
                    </div>

                     <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?>
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-8">
                                <?php $date = date('Y-m-d'); ?>
                                <input type="text" required tabindex="2" class="form-control datepicker" name="purchase_date" value="<?php echo $date; ?>" id="date"  />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                
                    <div class="col-sm-6">
                       <div class="form-group row">
                            <label for="adress" class="col-sm-4 col-form-label"><?php echo display('details') ?>
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" tabindex="4" id="adress" name="purchase_details" placeholder=" <?php echo display('details') ?>" rows="1"></textarea>
                            </div>
                        </div> 
                    </div>
                </div>
                    

<br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="purchaseTable">
                        <thead>
                             <tr>
                                    <th class="text-center" width="20%"><?php echo display('item_information') ?><i class="text-danger">*</i></th> 
                                    <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                    <th class="text-center"><?php echo display('rate') ?><i class="text-danger">*</i></th>


                                    <th class="text-center"><?php echo display('total') ?></th>
                                    <th class="text-center"><?php echo display('action') ?></th>
                                </tr>
                        </thead>
                        <tbody id="addPurchaseItem">
                            <tr>
                                <td class="span3 supplier">
                                   <input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list(1);" placeholder="<?php echo display('product_name') ?>" id="product_name_1" tabindex="5" >

                                    <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId">

                                    <input type="hidden" class="sl" value="1">
                                </td>

                               
                                
                                    <td class="text-right">
                                        <input type="text" name="product_quantity[]" id="cartoon_1" required="" min="0" class="form-control text-right store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value=""  tabindex="6"/>
                                    </td>
                                    <td class="test">
                                        <input type="text" name="product_rate[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="7"/>
                                    </td>
                                   

                                    <td class="text-right">
                                        <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                    </td>
                                    <td>

                                       

                                        <button  class="btn btn-danger text-right red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button>
                                    </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <td class="text-right" colspan="3"><b><?php echo display('total') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="Total" class="text-right form-control" name="total" value="0.00" readonly="readonly" />
                                </td>
                                <td> <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField1('addPurchaseItem')"  tabindex="9"><i class="fa fa-plus"></i></button>

                                    <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/></td>
                            </tr>
                                <tr>
                               
                                <td class="text-right" colspan="3"><b><?php echo display('discounts') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="discount" class="text-right form-control discount" onkeyup="calculate_store(1)" name="discount" placeholder="0.00" value="" />
                                </td>
                                <td> 

                                   </td>
                            </tr>

                                <tr>
                                
                                <td class="text-right" colspan="3"><b><?php echo display('grand_total') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly" />
                                </td>
                                <td> </td>
                            </tr>
                                 <tr>
                                
                                <td class="text-right" colspan="3"><b><?php echo display('paid_amount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="paidAmount" class="text-right form-control" onKeyup="invoice_paidamount()" name="paid_amount" value="" />
                                </td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right">
                                     <input type="button" id="full_paid_tab" class="btn btn-warning" value="<?php echo display('full_paid') ?>" tabindex="16" onClick="full_paid()"/>
                                </td>
                                <td class="text-right" colspan="1"><b><?php echo display('due_amount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" id="dueAmmount" class="text-right form-control" name="due_amount" value="0.00" readonly="readonly" />
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="submit" id="add_purchase" class="btn btn-primary btn-large" name="add-purchase" value="<?php echo display('submit') ?>" />
                       
                    </div>
                </div>
            <?php echo form_close()?>
            </div>
        </div>

    </div>
</div>


