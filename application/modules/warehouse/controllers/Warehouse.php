<?php
defined('BASEPATH') or exit('No direct script access allowed');
#------------------------------------    
# Author: Bdtask Ltd
# Author link: https://www.bdtask.com/
# Dynamic style php file
# Developed by :Isahaq
#------------------------------------    

class Warehouse extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'warehouse_model'
        ));
        if (!$this->session->userdata('isLogIn'))
            redirect('login');
    }


    function add_purchase_order()
    {

        $data['title']      = display('add_purchase');
        $data['all_supplier'] = $this->warehouse_model->supplier_list();
        $data['module']     = "warehouse";
        $data['page']       = "add_purchase_order";
        echo modules::run('template/layout', $data);
    }

    public function purchase_order_list()
    {
        $data['title']      = display('manage_purchase');
        $data['total_purhcase'] = $this->warehouse_model->count_purchase_order();
        $data['module']     = "warehouse";
        $data['page']       = "purchase_order_list";
        echo modules::run('template/layout', $data);
    }

    // Manage production orders
    public function production_orders_list()
    {
        $data['title']      = display('manage_purchase');
        $data['total_purhcase'] = $this->warehouse_model->count_production_purchase_order();
        // print_r($data['total_purhcase']);
        // return;
        $data['module']     = "warehouse";
        $data['page']       = "production_order_list";
        echo modules::run('template/layout', $data);
    }
    // 

    public function purchase_order_details($purchase_id = null)
    {

        $purchase_detail = $this->warehouse_model->purchase_order_details_data($purchase_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }

            foreach ($purchase_detail as $k => $v) {
                $purchase_detail[$k]['convert_date'] = $purchase_detail[$k]['purchase_date'];
            }
        }

        $data = array(
            'title'            => display('purchase_details'),
            'purchase_id'      => $purchase_detail[0]['purchase_id'],
            'purchase_details' => $purchase_detail[0]['purchase_details'],
            'supplier_name'    => $purchase_detail[0]['supplier_name'],
            'final_date'       => $purchase_detail[0]['convert_date'],
            'sub_total_amount' => number_format($purchase_detail[0]['grand_total_amount'], 2, '.', ','),
            'chalan_no'        => $purchase_detail[0]['chalan_no'],
            'total'            =>  number_format($purchase_detail[0]['grand_total_amount'] + (!empty($purchase_detail[0]['total_discount']) ? $purchase_detail[0]['total_discount'] : 0), 2),
            'discount'         => number_format((!empty($purchase_detail[0]['total_discount']) ? $purchase_detail[0]['total_discount'] : 0), 2),
            'paid_amount'      => number_format($purchase_detail[0]['paid_amount'], 2),
            'due_amount'      => number_format($purchase_detail[0]['due_amount'], 2),
            'purchase_all_data' => $purchase_detail,
        );

        $data['module']     = "warehouse";
        $data['page']       = "purchase_order_detail";
        echo modules::run('template/layout', $data);
    }

    public function bdtask_purchase_order_edit_form($purchase_id = null)
    {

        $purchase_detail = $this->warehouse_model->retrieve_purchase_order_editdata($purchase_id);
        
        $supplier_id = $purchase_detail[0]['supplier_id'];
        $supplier_list = $this->warehouse_model->supplier_list();

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }

        $data = array(
            'title'         => display('purchase_edit'),
            'purchase_id'   => $purchase_detail[0]['po_id'],
            'chalan_no'     => $purchase_detail[0]['chalan_no'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'supplier_id'   => $purchase_detail[0]['supplier_id'],
            'grand_total'   => $purchase_detail[0]['grand_total_amount'],
            'purchase_details' => $purchase_detail[0]['po_details'],
            'purchase_date' => $purchase_detail[0]['po_date'],
            'total_discount' => $purchase_detail[0]['total_discount'],
            'total'         => number_format($purchase_detail[0]['grand_total_amount'] + (!empty($purchase_detail[0]['total_discount']) ? $purchase_detail[0]['total_discount'] : 0), 2),
            'bank_id'       =>  $purchase_detail[0]['bank_id'],
            'purchase_info' => $purchase_detail,
            'supplier_list' => $supplier_list,
            'paid_amount'   => $purchase_detail[0]['paid_amount'],
            'due_amount'    => $purchase_detail[0]['due_amount'],
            'paytype'       => $purchase_detail[0]['payment_type'],
        );



        $data['module']     = "warehouse";
        $data['page']       = "edit_purchase_order_form";
        echo modules::run('template/layout', $data);
    }

    public function CheckPurchaseOrderList()
    {
        $postData = $this->input->post();
        $data = $this->warehouse_model->getPurchaseOrderList($postData);
        echo json_encode($data);
    }
    public function bdtask_save_purchase_order()
    {
   
     
            $purchase_id = date('YmdHis');
            $p_id        = $this->input->post('product_id', TRUE);
          
            $receive_by = $this->session->userdata('id');
            $receive_date = date('Y-m-d');
            $createdate  = date('Y-m-d H:i:s');
            $paid_amount = $this->input->post('paid_amount', TRUE);
            $due_amount  = $this->input->post('due_amount', TRUE);
            $discount    = $this->input->post('discount', TRUE);
            $bank_id     = $this->input->post('bank_id', TRUE);
            if (!empty($bank_id)) {
                $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id', $bank_id)->get()->row()->bank_name;

                $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName', $bankname)->get()->row()->HeadCode;
            } else {
                $bankcoaid = '';
            }


            $data = array(
                'po_id'        => $purchase_id,
                // 'chalan_no'          => $this->input->post('chalan_no', TRUE),
                // 'supplier_id'        => $this->input->post('supplier_id', TRUE),
                'grand_total_amount' => $this->input->post('grand_total_price', TRUE),
                'total_discount'     => $this->input->post('discount', TRUE),
                'po_date'      => $this->input->post('purchase_date', TRUE),
                'po_details'   => $this->input->post('purchase_details', TRUE),
                'paid_amount'        => $paid_amount,
                'due_amount'         => $due_amount,
                'status'             => 1,
                // 'bank_id'            =>  $this->input->post('bank_id', TRUE),
                // 'payment_type'       =>  $this->input->post('paytype', TRUE),
            );

            $this->db->insert('purchase_order', $data);



            $rate     = $this->input->post('product_rate', TRUE);
            $quantity = $this->input->post('product_quantity', TRUE);
            $t_price  = $this->input->post('total_price', TRUE);
            $discount = $this->input->post('discount', TRUE);

            for ($i = 0, $n = count($p_id); $i < $n; $i++) {
                $product_quantity = $quantity[$i];
                $product_rate     = $rate[$i];
                $product_id       = $p_id[$i];
                $total_price      = $t_price[$i];
                $disc             = $discount[$i];

                $data1 = array(
                    'po_detail_id' => $this->generator(15),
                    'po_id'        => $purchase_id,
                    'product_id'         => $product_id,
                    'quantity'           => $product_quantity,
                    'rate'               => $product_rate,
                    'total_amount'       => $total_price,
                    'discount'           => $disc,
                    'status'             => 1
                );

                if (!empty($quantity)) {
                    $this->db->insert('purchase_order_details', $data1);
                }
            }
            $this->session->set_flashdata('message', display('save_successfully'));
            redirect("purchase_order_list");
        
    }



    public function update_order_purchase()
    {
        $purchase_id  = $this->input->post('purchase_id', TRUE);
        // $this->form_validation->set_rules('supplier_id', display('supplier'), 'required|max_length[15]');
        // $this->form_validation->set_rules('paytype', display('payment_type'), 'required|max_length[20]');
        // $this->form_validation->set_rules('chalan_no', display('invoice_no'), 'required|max_length[20]');
        $this->form_validation->set_rules('product_id[]', display('product'), 'required|max_length[20]');
        $this->form_validation->set_rules('product_quantity[]', display('quantity'), 'required|max_length[20]');
        $this->form_validation->set_rules('product_rate[]', display('rate'), 'required|max_length[20]');

        if ($this->form_validation->run() === true) {

            $paid_amount  = $this->input->post('paid_amount', TRUE);
            $due_amount   = $this->input->post('due_amount', TRUE);
            $bank_id      = $this->input->post('bank_id', TRUE);
            if (!empty($bank_id)) {
                $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id', $bank_id)->get()->row()->bank_name;
                $bankcoaid   = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName', $bankname)->get()->row()->HeadCode;
            }
            $p_id        = $this->input->post('product_id', TRUE);
            $supplier_id = $this->input->post('supplier_id', TRUE);
            $supinfo     = $this->db->select('*')->from('supplier_information')->where('supplier_id', $supplier_id)->get()->row();
            $sup_head    = $supinfo->supplier_id . '-' . $supinfo->supplier_name;



            $data = array(
                'po_id'        => $purchase_id,
                'chalan_no'          => $this->input->post('chalan_no', TRUE),
                'supplier_id'        => $this->input->post('supplier_id', TRUE),
                'grand_total_amount' => $this->input->post('grand_total_price', TRUE),
                'total_discount'     => $this->input->post('discount', TRUE),
                'po_date'      => $this->input->post('purchase_date', TRUE),
                'po_details'   => $this->input->post('purchase_details', TRUE),
                'paid_amount'        => $paid_amount,
                'due_amount'         => $due_amount,
                'bank_id'           =>  $this->input->post('bank_id', TRUE),
                'payment_type'       =>  $this->input->post('paytype', TRUE),
            );

            if ($purchase_id != '') {
                $this->db->where('po_id', $purchase_id);
                $this->db->update('purchase_order', $data);
                //account transaction update

                $this->db->where('po_id', $purchase_id);
                $this->db->delete('purchase_order_details');
            }



            $rate     = $this->input->post('product_rate', TRUE);
            $p_id     = $this->input->post('product_id', TRUE);
            $quantity = $this->input->post('product_quantity', TRUE);
            $t_price  = $this->input->post('total_price', TRUE);

            $discount = $this->input->post('discount', TRUE);

            for ($i = 0, $n = count($p_id); $i < $n; $i++) {
                $product_quantity = $quantity[$i];
                $product_rate     = $rate[$i];
                $product_id       = $p_id[$i];
                $total_price      = $t_price[$i];
                $disc             = $discount[$i];

                $data1 = array(
                    'po_id' => $this->generator(15),
                    'po_id'        => $purchase_id,
                    'product_id'         => $product_id,
                    'quantity'           => $product_quantity,
                    'rate'               => $product_rate,
                    'total_amount'       => $total_price,
                    'discount'           => $disc,
                );


                if (($quantity)) {

                    $this->db->insert('purchase_order_details', $data1);
                }
            }
            $this->session->set_flashdata('message', display('update_successfully'));
            redirect("purchase_order_list");
        } else {
            $this->session->set_flashdata('exception', validation_errors());
            redirect("po_edit/" . $purchase_id);
        }
    }
    // public function bdtask_product_search_by_supplier() {
    //     $supplier_id = $this->input->post('supplier_id',TRUE);
    //     $product_name = $this->input->post('product_name',TRUE);
    //     $product_info = $this->purchase_model->product_search_item($supplier_id, $product_name);
    //     if(!empty($product_info)){
    //     $list[''] = '';
    //     foreach ($product_info as $value) {
    //         $json_product[] = array('label'=>$value['product_name'].'('.$value['product_model'].')','value'=>$value['product_id']);
    //     } 
    // }else{
    //     $json_product[] = 'No Product Found';
    //     }
    //     echo json_encode($json_product);
    // }

    //     public function bdtask_retrieve_product_data() {
    //     $product_id  = $this->input->post('product_id',TRUE);
    //     $supplier_id = $this->input->post('supplier_id',TRUE);
    //     $product_info = $this->purchase_model->get_total_product($product_id, $supplier_id);

    //     echo json_encode($product_info);
    // }

    //     public function product_supplier_check($product_id, $supplier_id) {
    //     $this->db->select('*');
    //     $this->db->from('supplier_product');
    //     $this->db->where('product_id', $product_id);
    //     $this->db->where('supplier_id', $supplier_id);
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 0) {
    //         return true;
    //     }
    //     return 0;
    // }

    public function generator($lenth)
    {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 34);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    // Azeem working start
    public function peoduction_form()
    {
        $data['title']      = ('Production Form');
        $data['branches'] = $this->warehouse_model->search_branches();
        $data['module']     = "warehouse";
        $data['page']       = "add_production";
        echo modules::run('template/layout', $data);
    }

    public function bdtask_save_production_order()
    {
        // die("Production form");
        // $this->form_validation->set_rules('supplier_id', display('supplier'), 'required|max_length[15]');
        // $this->form_validation->set_rules('paytype', display('payment_type'), 'required|max_length[20]');
        // $this->form_validation->set_rules('chalan_no', display('invoice_no'), 'required|max_length[20]|is_unique[product_purchase.chalan_no]');
        // $this->form_validation->set_rules('product_id[]', display('product'), 'required|max_length[20]');
        // $this->form_validation->set_rules('product_quantity[]', display('quantity'), 'required|max_length[20]');
        // $this->form_validation->set_rules('product_rate[]', display('rate'), 'required|max_length[20]');

        // if ($this->form_validation->run() === true) {
            $purchase_id = date('YmdHis');
            $recipe_id        = $this->input->post('product_id', TRUE);
            $branch_id = $this->input->post('branch_id', TRUE);
            
            $receive_by = $this->session->userdata('id');
            $receive_date = date('Y-m-d');
            $createdate  = date('Y-m-d H:i:s');
            $paid_amount = $this->input->post('paid_amount', TRUE);
            $due_amount  = $this->input->post('due_amount', TRUE);
            $discount    = $this->input->post('discount', TRUE);
            $bank_id     = $this->input->post('bank_id', TRUE);

            $rate     = $this->input->post('product_rate', TRUE);
            $quantity = $this->input->post('product_quantity', TRUE);
            $t_price  = $this->input->post('total_price', TRUE);
            $discount = $this->input->post('discount', TRUE);

            $stock = [];

            if (!empty($bank_id)) {
                $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id', $bank_id)->get()->row()->bank_name;

                $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName', $bankname)->get()->row()->HeadCode;
            } else {
                $bankcoaid = '';
            }

           

            $data = array(
                'po_id'              => $purchase_id,
                // 'chalan_no'          => $this->input->post('chalan_no', TRUE),
                'supplier_id'        => $this->input->post('supplier_id', TRUE),
                'grand_total_amount' => $this->input->post('grand_total_price', TRUE),
                'total_discount'     => $this->input->post('discount', TRUE),
                'po_date'            => $this->input->post('purchase_date', TRUE),
                'po_details'         => $this->input->post('purchase_details', TRUE),
                'paid_amount'        => $paid_amount,
                'due_amount'         => $due_amount,
                'status'             => 1,
                'bank_id'            =>  $this->input->post('bank_id', TRUE),
                'payment_type'       =>  $this->input->post('paytype', TRUE),
            );

            $stock_data = array(
                'stk_id '        => $purchase_id,
                'branch_id'     => $branch_id,
                'stk_date'      => $this->input->post('purchase_date', TRUE),
                'stock'         => 'warehouse'
            );
            $this->db->insert('stock', $stock_data);
            // $this->db->insert('production_order', $data);



            

            for ($i = 0, $n = count($recipe_id); $i < $n; $i++) {

                //stock entry
                $stock = $this->warehouse_model->stock_entry($recipe_id[$i]);

                
                for ($j = 0, $n = count($stock); $j < $n; $j++) {
                    
                    $stock_data2 = array(
                        'stk_id'           => $purchase_id,
                        'branch_id'           => $branch_id,
                        'stk_id_detail_id'    => $this->generator(15),
                        'recipe_id '          => $stock[$j]['receipe_id'],
                        'product_id '         => $stock[$j]['product_id'],
                        'quantity'            => $stock[$j]['quantity'] * $quantity[$i],
                        'type'                => $stock[$j]['prod_type']
                    );
                   
                    if($stock[$j]['receipe_id'] > 0){
                        $this->db->insert('stock_details', $stock_data2);
                    }
                }
                // $stock_data2 = array(
                //     'stk_id'           => $purchase_id,
                //     'stk_id_detail_id'  => $this->generator(15),
                //     'recipe_id '         => $stock[$j]['receipe_id'],
                //     'product_id '         => $stock[$j]['product_id'],
                //     'quantity'           => $stock[$j]['quantity']
                // );
                // return print_r($stock_data2);
               
                //end stock entry

                $product_quantity = $quantity[$i];
                $product_rate     = $rate[$i];
                $product_id       = $recipe_id[$i];
                $total_price      = $t_price[$i];
                $disc             = $discount[$i];

                $data1 = array(
                    'po_detail_id'       => $this->generator(15),
                    'po_id'              => $purchase_id,
                    'product_id'         => $product_id,
                    'quantity'           => $product_quantity,
                    'rate'               => $product_rate,
                    'total_amount'       => $total_price,
                    'discount'           => $disc,
                    'status'             => 1
                );

                if (!empty($quantity)) {
                    // $this->db->insert('production_order_details', $data1);
                    
                }
            }
            $this->session->set_flashdata('message', display('save_successfully'));
            redirect("purchase_list");
        // } else {
        //     $this->session->set_flashdata('exception', validation_errors());
        //     redirect("add_production");
        // }
    }


    public function bdtask_purchase_order_process_form($purchase_id = null)
    {

        $purchase_detail = $this->warehouse_model->retrieve_purchase_process_editdata($purchase_id);
        
        $branches = $this->warehouse_model->search_branches();
        // $supplier_id = $purchase_detail[0]['supplier_id'];
        // $supplier_list = $this->warehouse_model->supplier_list();

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }

        $data = array(
            'title'         => display('purchase_edit'),
            'purchase_id'   => $purchase_detail[0]['po_id'],
            'chalan_no'     => $purchase_detail[0]['chalan_no'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'supplier_id'   => $purchase_detail[0]['supplier_id'],
            'grand_total'   => $purchase_detail[0]['grand_total_amount'],
            'purchase_details' => $purchase_detail[0]['po_details'],
            'purchase_date' => $purchase_detail[0]['po_date'],
            'total_discount' => $purchase_detail[0]['total_discount'],
            'total'         => number_format($purchase_detail[0]['grand_total_amount'] + (!empty($purchase_detail[0]['total_discount']) ? $purchase_detail[0]['total_discount'] : 0), 2),
            'bank_id'       =>  $purchase_detail[0]['bank_id'],
            'purchase_info' => $purchase_detail,
            'branches'      =>$branches,
            // 'supplier_list' => $supplier_list,
            'paid_amount'   => $purchase_detail[0]['paid_amount'],
            'due_amount'    => $purchase_detail[0]['due_amount'],
            'paytype'       => $purchase_detail[0]['payment_type'],
        );

        
        // return print_r($data);
        $data['module']     = "warehouse";
        $data['page']       = "production_process";
        echo modules::run('template/layout', $data);
    }

    public function process_order()
    {
        
        // $this->form_validation->set_rules('supplier_id', display('supplier'), 'required|max_length[15]');
        // $this->form_validation->set_rules('paytype', display('payment_type'), 'required|max_length[20]');
        // $this->form_validation->set_rules('chalan_no', display('invoice_no'), 'required|max_length[20]|is_unique[product_purchase.chalan_no]');
        $this->form_validation->set_rules('product_id[]', display('product'), 'required|max_length[20]');
        $this->form_validation->set_rules('product_quantity[]', display('quantity'), 'required|max_length[20]');
        $this->form_validation->set_rules('product_rate[]', display('rate'), 'required|max_length[20]');

        if ($this->form_validation->run() === true) {
            $purchase_id = $this->input->post('chalan_no', TRUE);
            $recipe_id        = $this->input->post('product_id', TRUE);
            $branch_id = $this->input->post('branch_id', TRUE);
            
            $receive_by = $this->session->userdata('id');
            $receive_date = date('Y-m-d');
            $createdate  = date('Y-m-d H:i:s');
            $paid_amount = $this->input->post('paid_amount', TRUE);
            $due_amount  = $this->input->post('due_amount', TRUE);
            $discount    = $this->input->post('discount', TRUE);
            $bank_id     = $this->input->post('bank_id', TRUE);

            $rate     = $this->input->post('product_rate', TRUE);
            $quantity = $this->input->post('product_quantity', TRUE);
            $t_price  = $this->input->post('total_price', TRUE);
            $discount = $this->input->post('discount', TRUE);

            $stock = [];

            if (!empty($bank_id)) {
                $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id', $bank_id)->get()->row()->bank_name;

                $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName', $bankname)->get()->row()->HeadCode;
            } else {
                $bankcoaid = '';
            }

           

            $data = array(
                'production_id'              => $purchase_id,
                // 'chalan_no'          => $this->input->post('chalan_no', TRUE),
                // 'supplier_id'        => $this->input->post('supplier_id', TRUE),
                'grand_total_amount' => $this->input->post('grand_total_price', TRUE),
                'total_discount'     => $this->input->post('discount', TRUE),
                'po_date'            => $this->input->post('purchase_date', TRUE),
                'po_details'         => $this->input->post('purchase_details', TRUE),
                'paid_amount'        => $paid_amount,
                'due_amount'         => $due_amount,
                'status'             => 1,
                'branch_id'          => $branch_id,
                // 'bank_id'            => $this->input->post('bank_id', TRUE),
                // 'payment_type'       => $this->input->post('paytype', TRUE),
            );

            $stock_data = array(
                'stk_id '        => $purchase_id,
                'branch_id'     => $branch_id,
                'stk_date'      => $this->input->post('purchase_date', TRUE),
                'stock'         => 'warehouse'
            );
            $this->db->insert('stock', $stock_data);
            $this->db->insert('production_order', $data);



            // print_r($recipe_id);
            // return;

            // for ($i = 0, $n = count($recipe_id); $i < $n; $i++) {
            foreach($recipe_id as $key => $recipe){
                //stock entry
                // echo $key;
                $stock = $this->warehouse_model->stock_entry($recipe);
                
                // print_r($stock[0]['quantity']);

                
                for ($j = 0, $n = count($stock); $j < $n; $j++) {
                    
                    $stock_data2 = array(
                        'stk_id'           => $purchase_id,
                        'branch_id'           => $branch_id,
                        'stk_id_detail_id'    => $this->generator(15),
                        'recipe_id'          => $stock[$j]['receipe_id'],
                        'product_id'         => $stock[$j]['product_id'],
                        'quantity'            => $stock[$j]['quantity'] * $quantity[$key],
                        'type'                => $stock[$j]['prod_type']
                    );

                   
                    if($stock[$j]['receipe_id'] > 0){
                        $this->db->insert('stock_details', $stock_data2);
                    }
                }

                // print_r($stock_data2);

                $product_quantity = $quantity[$i];
                $product_rate     = $rate[$i];
                $product_id       = $recipe_id[$i];
                $total_price      = $t_price[$i];
                $disc             = $discount[$i];

                $data1 = array(
                    'production_detail_id'       => $this->generator(15),
                    'production_id'              => $purchase_id,
                    'product_id'         => $recipe_id[$key],
                    'quantity'           => $quantity[$key],
                    'rate'               => $rate[$key],
                    'total_amount'       => $t_price[$key],
                    'discount'           => $discount[$key],
                    'status'             => 1
                );
                
                // print_r($data1);
                if (!empty($quantity)) {
                    $this->db->insert('production_order_details', $data1);
                    
                }
            }
            
            $this->session->set_flashdata('message', display('save_successfully'));
            redirect("purchase_list");
    
        } 
    }
}
