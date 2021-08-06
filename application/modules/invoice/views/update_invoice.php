<form class="form-inline mb-3">
    <div class="form-group">
        <input type="text" id="add_item" class="form-control" placeholder="Barcode or QR-code scan here">
    </div>
    <div class="form-group">
        <label class="mr-3 ml-3">OR</label>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="add_item_m" placeholder="Manual Input barcode">
    </div>
</form>
<?php echo form_open_multipart('invoice/invoice/bdtask_manual_sales_update', array('class' => 'form-vertical', 'id' => 'gui_sale_update', 'name' => 'insert_pos_invoice')) ?>
<input type="hidden" name="invoice_id" value="<?php echo $result[0]['invoice_id'];?>">
<div class="d-flex align-items-center mb-5">
    <div class="input-group mr-3">
        <input type="text" class="form-control customerSelection" id="customer_name" value="<?php echo $customer_name; ?>" tabindex="3" onkeyup="customer_autocomplete()" name="customer_name">
        <input id="autocomplete_customer_id" class="customer_hidden_value" type="hidden" name="customer_id" value="<?php echo $result[0]['customer_id']; ?>">
        <span class="input-group-btn">
            <button class="client-add-btn btn btn-success" type="button" aria-hidden="true" data-toggle="modal" data-target="#cust_info" id="customermodal-link" tabindex="4"><i class="ti-plus"></i></button>
        </span>
    </div><!-- /input-group -->

    <div class="d-flex align-items-center">
        <label class="mr-2 mb-0"><?php echo display('invoice_no'); ?> - <i class="text-danger"></i></label>
        <div class="invoice-no" id="gui_invoice_no">
            <?php echo $result[0]['invoice']; ?>
        </div>
        <input class="form-control" type="hidden" name="invoice_no" value="<?php echo $result[0]['invoice'];?>" id="invoice_no" required readonly />
    </div>

</div>

<div class="d-flex align-items-center mb-3">
    <div class="form-group"><label>FoodPand Tracking</label></div>
    <div class="form-group" style="margin-left: 10px">
        <select class="form-control select" id="food_panda" style="border-radius: 7px">
            <option disabled selected="">Select Option</option>
            <option value="food_panda">Food Panda</option>
        </select>
    </div>
    <div class="form-group" style="margin-left: 10px">
        <!-- <label id="label_pand" style="display: none">TrackingID</label> -->
        <input type="text" name="tracking_number" id="tracking_nmbr" class="form-control" placeholder="food panda tracking" style="display: none;border-radius: 5px;">
    </div>
</div>


<input type="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="table-responsive guiproductdata">
    <table class="table table-bordered table-hover table-sm nowrap gui-products-table" id="addinvoice">
        <thead>
            <tr>
                <th class="text-center gui_productname"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                <th class="text-center invoice_fields"><?php echo display('serial') ?></th>
                <th class="text-center"><?php echo display('available_qnty') ?></th>
                <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th> 
                <th class="text-center"><?php echo display('discount') ?> </th>
                <th class="text-center"><?php echo display('total') ?></th>
                <th class="text-center"><?php echo display('action') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $key => $value) {
            ?>
                <tr id="row_<?php echo $value['product_id']; ?>">
                    <td class="" style="width:220px">

                        <input type="text" name="product_name" onkeypress="invoice_productList('<?php echo $value['product_id']; ?>');" class="form-control productSelection " value="<?php echo $value['product_name']; ?>" placeholder="Product Name" required="" tabindex="" readonly="">

                        <input type="hidden" class="form-control autocomplete_hidden_value product_id_<?php echo $value['product_id']; ?>" name="product_id[]" id="SchoolHiddenId_<?php echo $value['product_id']; ?>" value="<?php echo $value['product_id']; ?>">
                        <input type="hidden" class="form-control autocomplete_hidden_value deals_id0" name="deals_id[]" id="deals_id_0" value="0">
                    </td>
                    <td><select name="serial_no[]" class="serial_no_1 form-control" id="serial_no_<?php echo $value['product_id']; ?>">
                            <option value="">Select One</option>
                            <option value="finish_foods">finish_foods</option>
                        </select></td>
                    <td>
                        <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_<?php echo $value['product_id']; ?>" value="<?php echo $value['quantity']; ?>" readonly="" id="available_quantity_<?php echo $value['product_id']; ?>">
                    </td>
                    <td>
                        <input type="text" value="<?php echo $value['quantity']; ?>" name="product_quantity[]" onkeyup="quantity_calculate('<?php echo $value['product_id']; ?>');" onchange="quantity_calculate('<?php echo $value['product_id']; ?>');" class="total_qntt_<?php echo $value['product_id']; ?> form-control text-right" id="total_qntt_<?php echo $value['product_id']; ?>" placeholder="0.00" min="0" required="required">
                    </td>
                    <td style="width:85px">
                        <input value="<?php echo $value['rate']; ?>" type="text" name="product_rate[]" onkeyup="quantity_calculate('<?php echo $value['product_id']; ?>');" onchange="quantity_calculate('<?php echo $value['product_id']; ?>');" <?php echo $value['quantity']; ?> id="price_item_<?php echo $value['product_id']; ?>" class="price_item1 form-control text-right" required="" placeholder="0.00" min="0">
                    </td>

                    <td class="">
                        <input type="text" value="<?php echo $value['discount']; ?>" name="discount[]" onkeyup="quantity_calculate('<?php echo $value['product_id']; ?>');" onchange="quantity_calculate('<?php echo $value['product_id']; ?>');" id="discount_<?php echo $value['product_id']; ?>" class="form-control text-right" placeholder="0.00" min="0">
                    </td>

                    <td class="text-right" style="width:100px">
                        <input value="<?php echo $value['total_price']; ?>" class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_<?php echo $value['product_id']; ?>" tabindex="-1" readonly="readonly">
                    </td>

                    <td><input type="hidden" id="total_discount_<?php echo $value['product_id']; ?>">
                        <input type="hidden" id="all_discount_<?php echo $value['product_id']; ?>" class="total_discount dppr" value="0">
                        <a style="text-align: right;" class="btn btn-danger btn-xs" href="#" onclick="deleteRow(this)"><i class="fa fa-close"></i></a>
                        <a style="text-align: right;" class="btn btn-success btn-xs" href="#" onclick="detailsmodal('plates','472','123','','21','my-assets/image/product.png')"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div class="footer">
    <div class="form-group row guifooterpanel">
        <div class="col-sm-12">
            <label for="date" class="col-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo display('invoice_discount') ?>:</label>
            <div class="col-sm-6 col-lg-5 col-xl-4">
                <input type="text" value="<?php echo $result[0]['invoice_discount'];?>" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" id="invoice_discount" class="form-control total_discount gui-foot text-right" name="invoice_discount" placeholder="0.00" />
                <input type="hidden" id="txfieldnum" value="<?php echo $taxnumber ?>" />
                <input type="hidden" name="paytype" value="1" />
            </div>
        </div>
    </div>
    <div class="form-group row guifooterpanel">
        <div class="col-sm-12">
            <label for="date" class="col-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo display('total_discount') ?>:</label>
            <div class="col-sm-6 col-lg-5 col-xl-4"><input type="text" value="<?php echo $result[0]['invoice_discount'];?>" id="total_discount_ammount" class="form-control gui-foot text-right" name="total_discount" value="0.00" readonly="readonly" /></div>
        </div>
    </div>
    <div class="form-group row hiddenRow guifooterpanel" id="taxdetails">
        <?php $x = 0;
        foreach ($taxes as $taxfldt) { ?>
            <div class="col-sm-12">
                <label for="date" class="ol-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo html_escape($taxfldt['tax_name']) ?>:</label>
                <div class="col-sm-6 col-lg-5 col-xl-4">
                    <input id="total_tax_ammount<?php echo $x; ?>" tabindex="-1" class="form-control gui-foot text-right valid totalTax" name="total_tax<?php echo $x; ?>" value="0.00" readonly="readonly" aria-invalid="false" type="text">
                </div>
            </div>
        <?php $x++;
        } ?>
    </div>
    <div class="form-group row guifooterpanel">
        <div class="col-sm-12">
            <label for="date" class="col-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo display('total_tax') ?>:</label>
            <div class="col-sm-6 col-lg-5 col-xl-4"><input id="total_tax_amount" tabindex="-1" class="form-control gui-foot text-right valid" name="total_tax" value="0.00" readonly="readonly" aria-invalid="false" type="text" /></div>
            <a class="col-sm-1 btn btn-primary btn-sm taxbutton" data-toggle="collapse" data-target="#taxdetails" aria-expanded="false" aria-controls="taxdetails"><i class="fa fa-angle-double-up"></i></a>
        </div>
    </div>
    <div class="form-group row guifooterpanel">
        <div class="col-sm-12">
            <label for="date" class="col-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo display('shipping_cost') ?>:</label>
            <div class="col-sm-6 col-lg-5 col-xl-4">
                <input type="text" id="shipping_cost" value="<?php echo $result[0]['shipping_cost'];?>" class="form-control gui-foot text-right" name="shipping_cost" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" placeholder="0.00" />
            </div>
        </div>
    </div>
    <div class="form-group row guifooterpanel">
        <div class="col-sm-12">
            <label for="date" class="col-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo display('grand_total') ?>:</label>
            <div class="col-sm-6 col-lg-5 col-xl-4"><input type="text" id="grandTotal" value="<?php echo $result[0]['total_amount']; ?>" class="form-control gui-foot text-right" readonly="readonly" />
                <input type="hidden" value="<?php echo $result[0]['total_amount']; ?>" class="grandTotal" name="grand_total_price">
                <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url(); ?>" id="baseurl" />
            </div>
        </div>
    </div>

    <div class="form-group row guifooterpanel">
        <div class="col-sm-12">
            <label for="date" class="col-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo display('previous'); ?>:</label>
            <div class="col-sm-6 col-lg-5 col-xl-4"><input value="<?php echo $result[0]['prevous_due'];?>" type="text" id="previous" class="form-control gui-foot text-right" name="previous" value="0.00" readonly="readonly" /></div>
        </div>
    </div>
    <div class="form-group row guifooterpanel">
        <div class="col-sm-12">
            <label for="change" class="col-sm-6 col-lg-6 col-xl-7 col-form-label"><?php echo display('change'); ?>:</label>
            <div class="col-sm-6 col-lg-5 col-xl-4"><input type="text" id="change" class="form-control gui-foot text-right" name="change" value="0.00" readonly="readonly" /></div>
        </div>
    </div>
</div>

<div class="fixedclasspos">
    <div class="bottomarea">
        <div class="row">
            <div class="col-lg-8 col-xl-8">
                <div class="calculation d-lg-flex">
                    <div class="cal-box d-lg-flex align-items-lg-center mr-4">
                        <label class="cal-label mr-2 mb-0"><?php echo display('net_total'); ?>:</label><span class="amount" id="net_total_text"><?php echo $result[0]['total_amount'];?></span>
                        <input type="hidden" id="n_total" class="form-control text-right guifooterfixedinput" name="n_total" value="<?php echo $result[0]['total_amount'];?>" readonly="readonly" placeholder="" />
                    </div>
                    <div class="cal-box d-lg-flex align-items-lg-center mr-4">
                        <div class="form-inline d-inline-flex align-items-center">
                            <label class="cal-label mr-2 mb-0"><?php echo display('paid_ammount') ?>:</label>
                            <input type="text" class="form-control" id="paidAmount" onkeyup="invoice_paidamount()" name="paid_amount" onkeypress="invoice_paidamount()" placeholder="0.00">
                        </div>
                    </div>
                    <div class="cal-box d-lg-flex align-items-lg-center mr-4">
                        <label class="cal-label mr-2 mb-0"><?php echo display('due') ?>:</label><span class="amount" id="due_text">0.00</span>
                        <input type="hidden" id="dueAmmount" class="form-control text-right guifooterfixedinput" name="due_amount" value="0.00" readonly="readonly" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 text-xl-right">
                <div class="action-btns d-flex justify-content-end">
                    <input type="button" id="full_paid_tab" class="btn btn-warning btn-lg mr-2" value="Full Paid" tabindex="14" onClick="full_paid()" />

                    <input type="submit" id="update_invoice" class="btn btn-info btn-lg mr-2" name="update_invoice" value="Update Sale">
                
                    <a href="#" class="btn btn-info btn-lg" data-toggle="modal" id="calculator_modal" data-target="#calculator"><i class="fa fa-calculator" aria-hidden="true"></i> </a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>