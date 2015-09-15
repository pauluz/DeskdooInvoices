<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * A free and open source web based invoicing system
 *
 * @package		InvoicePlane
 * @author		Kovah (www.kovah.de)
 * @copyright	Copyright (c) 2012 - 2015 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 *
 */

class Invoices extends Document_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_invoices');
    }

    public function index()
    {
        // Display all invoices by default
        redirect('invoices/status/all');
    }

    public function status($status = 'all', $page = 0)
    {
        // Determine which group of invoices to load
        switch ($status) {
            case 'draft':
                $this->mdl_invoices->is_draft();
                break;
            case 'sent':
                $this->mdl_invoices->is_sent();
                break;
            case 'viewed':
                $this->mdl_invoices->is_viewed();
                break;
            case 'paid':
                $this->mdl_invoices->is_paid();
                break;
            case 'overdue':
                $this->mdl_invoices->is_overdue();
                break;
        }

        $this->mdl_invoices->paginate(site_url('invoices/status/' . $status), $page);
        $invoices = $this->mdl_invoices->result();

        $this->layout->set(
            array(
                'documents' => $invoices,
                'mdl_document' => 'invoices',
                'document_status' => $status,
                'document_statuses' => $this->mdl_invoices->statuses(),

                'filter_display' => TRUE,
                'filter_placeholder' => lang('filter_invoices'),
                'filter_method' => 'filter_invoices',
            )
        );

        $this->layout->buffer('content', 'documents/index');
        $this->layout->render();
    }

    public function view($invoice_id)
    {
        $this->document = & $this->mdl_invoices;

//        parent::view_document(1);

        $this->load->model(
            array(
                'mdl_items',
                'payment_methods/mdl_payment_methods',
                'mdl_invoice_tax_rates',
                'item_lookups/mdl_item_lookups'
            )
        );

        $this->load->model('tax_rates/mdl_tax_rates');

        $this->load->helper('country');

        $this->load->module('payments');

        $invoice = $this->mdl_invoices->get_by_id($invoice_id);

        if (!$invoice) {
            show_404();
        }

        $this->layout->set(
            array(
                'document'          => $invoice,

                'invoice'           => $invoice,
                'items'             => $this->mdl_items->where( 'invoice_id', $invoice_id )->get()->result(),
                'invoice_id'        => $invoice_id,
                'tax_rates'         => $this->mdl_tax_rates->get()->result(),
                'invoice_tax_rates' => $this->mdl_invoice_tax_rates->where( 'invoice_id', $invoice_id )->get()->result(),
                'payment_methods'   => $this->mdl_payment_methods->get()->result(),
                'item_lookups'      => $this->mdl_item_lookups->get()->result(),
                'invoice_statuses'  => $this->mdl_invoices->statuses()
            )
        );

        $this->layout->buffer(
            array(
                array('modal_delete_doc', 'invoices/modal_delete_invoice'),
                array('modal_add_payment', 'payments/modal_add_payment'),
                array('content', 'invoices/view')
            )
        );

        $this->layout->render();
    }

    public function archive()
    {
        $invoice_array = array();
        if (isset($_POST['invoice_number'])) {
            $invoiceNumber = $_POST['invoice_number'];
            $invoice_array = glob('./uploads/archive/*' . '_' . $invoiceNumber . '.pdf');
            $this->layout->set(
                array(
                    'invoices_archive' => $invoice_array));
            $this->layout->buffer('content', 'invoices/archive');
            $this->layout->render();

        } else {
            foreach (glob('./uploads/archive/*.pdf') as $file) {
                array_push($invoice_array, $file);
            }
            rsort($invoice_array);
            $this->layout->set(
                array(
                    'invoices_archive' => $invoice_array));
            $this->layout->buffer('content', 'invoices/archive');
            $this->layout->render();
        }

    }

    public function download($invoice)
    {
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename='.basename($invoice));
        readfile('./uploads/archive/' . urldecode(basename($invoice)));
    }

    public function delete($invoice_id)
    {
        // Get the status of the invoice
        $invoice = $this->mdl_invoices->get_by_id($invoice_id);
        $invoice_status = $invoice->invoice_status_id;

        if ($invoice_status == 1 || $this->config->item('enable_invoice_deletion') === TRUE) {
            // Delete the invoice
            $this->mdl_invoices->delete($invoice_id);
        } else {
            // Add alert that invoices can't be deleted
            $this->session->set_flashdata('alert_error', lang('invoice_deletion_forbidden'));
        }

        // Redirect to invoice index
        redirect('invoices/index');
    }

    public function delete_item($invoice_id, $item_id)
    {
        // Delete invoice item
        $this->load->model('mdl_items');
        $this->mdl_items->delete($item_id);

        // Redirect to invoice view
        redirect('invoices/view/' . $invoice_id);
    }

    public function generate_pdf($invoice_id, $stream = TRUE, $invoice_template = NULL)
    {
        $this->load->helper('pdf');

        if ($this->mdl_settings->setting('mark_invoices_sent_pdf') == 1) {
            $this->mdl_invoices->mark_sent($invoice_id);
        }

        generate_invoice_pdf($invoice_id, $stream, $invoice_template);
    }

    public function delete_invoice_tax($invoice_id, $invoice_tax_rate_id)
    {
        $this->load->model('mdl_invoice_tax_rates');
        $this->mdl_invoice_tax_rates->delete($invoice_tax_rate_id);

        $this->load->model('mdl_invoice_amounts');
        $this->mdl_invoice_amounts->calculate($invoice_id);

        redirect('invoices/view/' . $invoice_id);
    }

    public function recalculate_all_invoices()
    {
        $this->db->select('invoice_id');
        $invoice_ids = $this->db->get('ip_invoices')->result();

        $this->load->model('mdl_invoice_amounts');

        foreach ($invoice_ids as $invoice_id) {
            $this->mdl_invoice_amounts->calculate($invoice_id->invoice_id);
        }
    }
}
