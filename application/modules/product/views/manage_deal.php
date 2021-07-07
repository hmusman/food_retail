<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <!-- <h4><?php echo $data['title']; ?> </h4> -->
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive" id="results">
                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo display('sl') ?></th>
                                <th class=""><?php echo display('name') ?></th>
                                <th class=""><?php echo 'Deal Price' ?></th>
                                <th class="text-center"><?php echo display('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sl = 0;
                            foreach ($total_deal as $deal) {
                                $sl++;
                            ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td>

                                        <?php echo $deal->deal_name; ?>

                                    </td>
                                    <td>
                                        <?php echo $deal->deal_price; ?>
                                    </td>

                                    <td class="text-center">
                                        <a href="<?php echo base_url() . 'edit_deal/' . $deal->deal_id; ?>" class="btn btn-primary btn-sm" title="<?php echo display('update') ?>" data-original-title="<?php echo display('update') ?> "><i class="fa fa-edit" aria-hidden="true"></i></a>                                        
                                        <a href="<?php echo base_url() . 'del_deal/' . $deal->deal_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Want to Delete ??')" title="<?php echo display('delete') ?>" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>                                                                                
                                    </td>
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