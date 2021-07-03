<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/service_quotation.js.php"></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/receipe.js"></script>
<?php
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('id'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo ('Add Receipe') ?> </h4>
                </div>
            </div>
            <?php echo form_open('purchase/purchase/receipe_edit', array('class' => 'form-vertical', 'id' => 'insert_quotation')) ?>
            <input type="hidden" name="id" value="<?php echo $edit_receipe[0]['receipe_id']; ?>">
            <div class="panel-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="customer" class="col-sm-4 col-form-label"><?php echo ('Receipe Name') ?> <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input type="text" name="receipe_name" value="<?php echo $edit_receipe[0]['receipe_name']; ?>" class="form-control" required placeholder="Receipe Name">                            
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="expected_weight" class="col-sm-4 col-form-label"><?php echo ('Expected Weight') ?> </label>
                        <div class="col-sm-8">
                            <input type="text" value="<?php echo $edit_receipe[0]['expected_weight']; ?>" name="expected_weight" placeholder="Expected Weight" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="no_plates" class="col-sm-4 col-form-label"><?php echo ('No Plates') ?> <i class="text-danger"></i></label>
                        <div class="col-sm-8">
                            <input type="text" value="<?php echo $edit_receipe[0]['no_plates']; ?>" name="no_plates" required class="form-control" placeholder="No Plates">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="r_date" class="col-sm-4 col-form-label"><?php echo display('date') ?><i class="text-danger">*</i> </label>
                        <div class="col-sm-8">
                            <input type="text" value="<?php echo $edit_receipe[0]['r_date']; ?>" name="r_date" class="form-control datepicker" id="r_date" value="<?php echo date('Y-m-d') ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="receipe" class="col-sm-2 col-form-label"><?php echo ('Receipe') ?> <i class="text-danger"></i></label>
                        <div class="col-sm-10">
                            <textarea name="receipe" class="form-control" id="receipe"><?php echo $edit_receipe[0]['receipe']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive margin-top10">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center product_field"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo ('Quantity') ?></th>
                                        <th class="text-center"><?php echo ('Action') ?></th>
                                         
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                    <?php
                                        foreach($edit_receipe as $edit_receipe_val){
                                            ?>
                                            <tr>
                                                <td class="product_field">
                                                    <input type="text" value="<?php echo $edit_receipe_val['product_name']; ?>" name="item_name[]" onkeypress="invoice_productList(1);" class="form-control productSelection" placeholder='<?php echo display('product_name') ?>' id="product_name_1" tabindex="5">
                                                    <input type="hidden" class="autocomplete_hidden_value product_id_1" value="<?php echo $edit_receipe_val['product_id']; ?>" name="product_id[]" id="SchoolHiddenId" />

                                                    <input type="hidden" class="baseUrl" value="<?php echo base_url(); ?>" />
                                                </td>
                                                <td>
                                                    <input type="text" name="desc[]" value="<?php echo $edit_receipe_val['quantity']; ?>" class="form-control text-right " tabindex="6" />
                                                </td>        
                                                <td>
                                                <button tabindex="35" style="text-align: right;" class="btn btn-danger" type="button" value="Delete" onclick="deleteRow(this)"><i class="fa fa-close"></i></button>
                                                </td>                                
                                            </tr>
                                            <?php
                                        }                                   
                                    ?>
                                </tbody>
                                <tfoot>

                                    <tr>

                                        <!-- <td class="text-right" colspan="8"><b><?php echo display('invoice_discount') ?>:</b></td> -->
                                        
                                        <td colspan="12" class="text-right"><a id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onClick="addInputField('addinvoiceItem');" tabindex="11"><i class="fa fa-plus"></i></a></td>
                                        
                                    </tr>
                                    
                                </tfoot>
                            </table>
                        </div>


                    </div>
                </div>

                <div class="form-group row">
                    <!-- <label for="example-text-input" class="col-sm-4 col-form-label"></label> -->
                    <div class="col-sm-12">

                        <input type="submit" id="add-quotation" class="btn btn-success btn-large" name="add-quotation" value="<?php echo display('save') ?>" />

                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/quotation.js"></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/receipe.js"></script>