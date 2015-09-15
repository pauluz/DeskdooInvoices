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

class Document_Controller extends Admin_Controller
{
    public $document;

    public function view_document($document_id)
    {
        $this->load->model('quotes/mdl_quote_items');
        $this->load->model('quotes/mdl_quote_tax_rates');
        $this->load->library('encrypt');

        $this->load->model('tax_rates/mdl_tax_rates');

        $this->load->helper('country');

        $document = $this->document->get_by_id($document_id);
        if (!$document) {
            show_404();
        }

        $this->layout->set(
            array(
                'document' => $document,
                'quote' => $document,
                'items' => $this->mdl_quote_items->where('quote_id', $document_id)->get()->result(),
                'quote_id' => $document_id,
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
                'quote_tax_rates' => $this->mdl_quote_tax_rates->where('quote_id', $document_id)->get()->result(),
                'custom_js_vars' => array(
                    'currency_symbol' => $this->mdl_settings->setting('currency_symbol'),
                    'currency_symbol_placement' => $this->mdl_settings->setting('currency_symbol_placement'),
                    'decimal_point' => $this->mdl_settings->setting('decimal_point')
                ),
                'quote_statuses' => $this->document->statuses()
            )
        );

        $this->layout->buffer(
            array(
                array('modal_delete_doc', 'quotes/modal_delete_quote'),
                array('content', 'quotes/view')
            )
        );

        $this->layout->render();
    }

}
