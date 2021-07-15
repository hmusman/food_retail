
<!-- Todays sales report -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <span><?php echo ('Waste Item Report') ?> </span>
                    <span class="padding-lefttitle">
                        

                        <a class="btn btn-warning m-b-5 m-r-2" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
                    </span>
                </div>
            </div>
            <div class="panel-body">


                <div id="printableArea">
                    <div class="paddin5ps">
                        <table class="print-table" width="100%">

                            <tr>
                                <td align="left" class="print-table-tr">
                                    <img src="<?php echo base_url() . $setting->logo; ?>" alt="logo">
                                </td>
                                <td align="center" class="print-cominfo">
                                    <span class="company-txt">
                                        <?php echo $company_info[0]['company_name']; ?>

                                    </span><br>
                                    <?php echo $company_info[0]['address']; ?>
                                    <br>
                                    <?php echo $company_info[0]['email']; ?>
                                    <br>
                                    <?php echo $company_info[0]['mobile']; ?>

                                </td>

                                <td align="right" class="print-table-tr">
                                    <date>
                                        <?php echo display('date') ?>: <?php
                                                                        echo date('d-M-Y');
                                                                        ?>
                                    </date>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <br>
                    <div class="table-responsive paddin5ps">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo display('sl') ?></th>
                                    <th><?php echo display('date') ?></th>
                                    <th class=""><?php echo display('product_name') ?></th> 
                                    <th class=""><?php echo display('quantity') ?></th>
                                    <th class=""><?php echo ('Waste') ?></th>
                                    <th class=""><?php echo ('Lost') ?></th>
                                    <!-- <th class=""><?php echo ('Total Quantity') ?></th>                                     -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                    $sl = 0;
                                    foreach ($raw_data as $single) {
                                        $sl++;
                                ?>
                                        <tr>
                                            <td> <?php echo $sl; ?></td>
                                            <td><?php echo ($single['date']); ?></td>
                                            <td> <?php echo ($single['product_name']); ?></td>
                                            <td> <?php echo ($single['quantity']); ?></td>
                                            <td> <?php echo ($single['waste']); ?></td>
                                            <td> <?php echo ($single['lose']); ?></td>
                                            <!-- <td> <?php echo ($single['total_quantity']); ?></td> -->
                                        </tr>
                                    <?php
                                    }
                                
                                ?>
                            </tbody>
                            

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>