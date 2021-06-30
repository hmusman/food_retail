<?php
defined('BASEPATH') or exit('No direct script access allowed');
#------------------------------------    
# Author: Bdtask Ltd
# Author link: https://www.bdtask.com/
# Dynamic style php file
# Developed by :Isahaq
#------------------------------------    

class Warehouse_model extends CI_Model
{

    public function supplier_list()
    {
        $query = $this->db->select('*')
            ->from('supplier_information')
            ->where('status', '1')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function product_search_item($supplier_id, $product_name)
    {
        $query = $this->db->select('*')
            ->from('supplier_product a')
            ->join('product_information b', 'a.product_id = b.product_id')
            ->where('a.supplier_id', $supplier_id)
            ->like('b.product_model', $product_name, 'both')
            ->or_where('a.supplier_id', $supplier_id)
            ->like('b.product_name', $product_name, 'both')
            ->group_by('a.product_id')
            ->order_by('b.product_name', 'asc')
            ->limit(15)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function retrieve_purchase_order_editdata($purchase_id)
    {
        $this->db->select(
            'a.*,
                        b.*,
                        c.product_id,
                        c.product_name,
                        c.product_model,
                        d.supplier_id,
                        d.supplier_name'
        );
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.po_id =a.po_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id = a.supplier_id');
        $this->db->where('a.po_id', $purchase_id);
        $this->db->order_by('a.po_details', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_total_product($product_id, $supplier_id)
    {
        $this->db->select('SUM(a.quantity) as total_purchase,b.*');
        $this->db->from('product_purchase_details a');
        $this->db->join('supplier_product b', 'a.product_id=b.product_id');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('b.supplier_id', $supplier_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $total_sale = $this->db->get()->row();

        $this->db->select('a.*,b.*');
        $this->db->from('product_information a');
        $this->db->join('supplier_product b', 'a.product_id=b.product_id');
        $this->db->where(array('a.product_id' => $product_id, 'a.status' => 1));
        $this->db->where('b.supplier_id', $supplier_id);
        $product_information = $this->db->get()->row();

        $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

        $data2 = array(
            'total_product'  => $available_quantity,
            'supplier_price' => $product_information->supplier_price,
            'price'          => $product_information->price,
            'supplier_id'    => $product_information->supplier_id,
            'unit'           => $product_information->unit,
        );

        return $data2;
    }

    public function count_purchase_order()
    {
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->order_by('a.po_date', 'desc');
        $this->db->order_by('po_id', 'desc');
        $query = $this->db->get();

        $last_query = $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    public function getPurchaseOrderList($postData = null)
    {
        $response = array();
        $fromdate = $this->input->post('fromdate');
        $todate   = $this->input->post('todate');
        if (!empty($fromdate)) {
            $datbetween = "(a.po_date BETWEEN '$fromdate' AND '$todate')";
        } else {
            $datbetween = "";
        }
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = " (b.supplier_name like '%" . $searchValue . "%' or a.chalan_no like '%" . $searchValue . "%' or a.po_date like'%" . $searchValue . "%')";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id', 'left');
        if (!empty($fromdate) && !empty($todate)) {
            $this->db->where($datbetween);
        }
        if ($searchValue != '')
            $this->db->where($searchQuery);

        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id', 'left');
        if (!empty($fromdate) && !empty($todate)) {
            $this->db->where($datbetween);
        }
        if ($searchValue != '')
            $this->db->where($searchQuery);

        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('a.*,b.supplier_name');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id', 'left');
        if (!empty($fromdate) && !empty($todate)) {
            $this->db->where($datbetween);
        }
        if ($searchValue != '')
            $this->db->where($searchQuery);

        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();
        $sl = 1;
        foreach ($records as $record) {
            $button = '';
            $base_url = base_url();
            $jsaction = "return confirm('Are You Sure ?')";

            $button .= '  <a href="' . $base_url . 'po_details/' . $record->po_id . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('purchase_details') . '"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
            if ($this->permission1->method('manage_purchase', 'update')->access()) {
                $button .= ' <a href="' . $base_url . 'po_edit/' . $record->po_id . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('update') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
                $button .= ' <a href="' . $base_url . 'process_product/' . $record->po_id . '" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="' . ('Process') . '"><i class="fa fa-spinner" aria-hidden="true"></i></a> ';
            }



            $purchase_ids = '<a href="' . $base_url . 'po_details/' . $record->po_id . '">' . $record->po_id . '</a>';

            $data[] = array(
                'sl'               => $sl,
                'chalan_no'        => $record->chalan_no,
                'purchase_id'      => $purchase_ids,
                'supplier_name'    => $record->supplier_name,
                'po_date'    => $record->po_date,
                'total_amount'     => $record->grand_total_amount,
                'button'           => $button,

            );
            $sl++;
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );

        return $response;
    }

    public function purchase_order_details_data($purchase_id)
    {
        $this->db->select('a.*,b.*,c.*,e.po_details,d.product_id,d.product_name,d.product_model');
        $this->db->from('purchase_order a');
        $this->db->join('supplier_information b', 'b.supplier_id = a.supplier_id');
        $this->db->join('purchase_order_details c', 'c.po_id = a.po_id');
        $this->db->join('product_information d', 'd.product_id = c.product_id');
        $this->db->join('purchase_order e', 'e.po_id = c.po_id');
        $this->db->where('a.po_id', $purchase_id);
        $this->db->group_by('d.product_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function retrieve_purchase_process_editdata($purchase_id)
    {
        $this->db->select(
            'a.*,
                        b.*,
                        c.product_id,
                        c.product_name,
                        c.product_model,
                        d.supplier_id,
                        d.supplier_name'
        );
        $this->db->from('purchase_order a');
        $this->db->join('purchase_order_details b', 'b.po_id =a.po_id');
        $this->db->join('product_information c', 'c.product_id =b.product_id');
        $this->db->join('supplier_information d', 'd.supplier_id = a.supplier_id');
        $this->db->where('a.po_id', $purchase_id);
        $this->db->order_by('a.po_details', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
}
