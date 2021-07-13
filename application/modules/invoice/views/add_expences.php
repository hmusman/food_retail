<script src="<?php echo base_url() ?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>
<div class="row">
    
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <?php echo ('Advance Form') ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?php echo  form_open_multipart('invoice/invoice/add_expence_form') ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label"><?php echo ('Salary Month') ?>
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="date" id="dtpDate" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" id="payment_from_1">
                        <div class="form-group row">
                            <label for="expense_type" class="col-sm-4 col-form-label"><?php
                                                                                        echo ('Advance');
                                                                                        ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="advance_data" onkeyup="advance_infot(this)" onchange="advance_infot(this)">
                            </div>

                        </div>
                    </div>
                    <input name="url" type="hidden" id="posurl_productname" value="<?php echo base_url() ?>" />
                    <input type ="hidden" name="csrf_test_name" id="" value="<?php echo $this->security->get_csrf_hash();?>">
                    <div class="col-sm-6" id="payment_from_1">
                        <div class="form-group row">
                            <input type="hidden" name="sale_type" value="2">
                            <label for="payment_type" class="col-sm-4 col-form-label"><?php echo ('Employee Name'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="employ_id" class="form-control" required="" id="paytype" onchange="select_employ(this.value)" required="">
                                    <option value="">Select Payment Option</option>
                                    <?php
                                        foreach($employ_data as $key=>$value){
                                            ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['first_name']; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="payment_type" class="col-sm-4 col-form-label"><?php
                                                                                        echo ('Salary');
                                                                                        ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" id="salary_input" class="form-control" readonly>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6" id="payment_from_1">
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label"><?php echo ('Remaning Salary') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" name="amount" id="remaning_amount" class="form-control remaning_amount" readonly>
                                <input type="hidden" name="remaining" class="remaning_amount">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <input type="submit" class="btn btn-success btn-large" name="save" value="<?php echo display('save') ?>" tabindex="9" />
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>