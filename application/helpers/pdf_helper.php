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

function generate_invoice_pdf($invoice_id, $stream = TRUE, $invoice_template = NULL,$isGuest = NULL)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('invoices/mdl_items');
    $CI->load->model('invoices/mdl_invoice_tax_rates');
    $CI->load->model('payment_methods/mdl_payment_methods');
    $CI->load->model('tax_rates/mdl_tax_rates');
    $CI->load->library('encrypt');

    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);
    if (!$invoice_template) {
        $CI->load->helper('template');
        $invoice_template = select_pdf_invoice_template($invoice);
    }

    $payment_method = $CI->mdl_payment_methods->where('payment_method_id', $invoice->payment_method)->get()->row();
    if ($invoice->payment_method == 0) $payment_method = NULL;

    if ($CI->mdl_settings->setting('default_language') == 'polish') {
        $grosze = substr($invoice->invoice_balance, strrpos($invoice->invoice_balance, '.') + 1);
        $balance_in_words = 'Słownie: '.DeskdooUtils::slownie(floor($invoice->invoice_balance)).' '.(int)$grosze.'/100';
    } else {
        $balance_in_words = '';
    }

    $items = $CI->mdl_items->get_items_and_replace_vars($invoice_id, $invoice->invoice_date_created);

    foreach ($items as $item) {
        if (empty($taxes_subtotal['total'][$item->item_tax_rate_id])) {
            $taxes_subtotal['total'][$item->item_tax_rate_id]  = 0;
            $taxes_subtotal['netto'][$item->item_tax_rate_id]  = 0;
            $taxes_subtotal['brutto'][$item->item_tax_rate_id] = 0;
        }

        $taxes_subtotal['total'][$item->item_tax_rate_id]  += $item->item_tax_total;
        $taxes_subtotal['netto'][$item->item_tax_rate_id]  += ($item->item_subtotal - $item->item_discount);
        $taxes_subtotal['brutto'][$item->item_tax_rate_id] += $item->item_total;
    }

    $data = array(
        'balance_in_words'  => $balance_in_words,
        'invoice'           => $invoice,
        'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
        'tax_rates'         => $CI->mdl_tax_rates->get_tax_rates(),
        'tax_subtotal'      => $taxes_subtotal,
        'items'             => $items,
        'payment_method'    => $payment_method,
        'output_type'       => 'pdf'
    );

    $html = $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, TRUE);

    $CI->load->helper('mpdf');

    return pdf_create($html, lang('invoice') . '_' . str_replace(array('\\', '/'), '_', $invoice->invoice_number), $stream, $invoice->invoice_password, 1, $isGuest);
}

function generate_quote_pdf($quote_id, $stream = TRUE, $quote_template = NULL)
{
    $CI = &get_instance();

    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('quotes/mdl_quote_items');
    $CI->load->model('quotes/mdl_quote_tax_rates');
    $CI->load->model('tax_rates/mdl_tax_rates');

    $quote = $CI->mdl_quotes->get_by_id($quote_id);

    if (!$quote_template) {
        $quote_template = $CI->mdl_settings->setting('pdf_quote_template');
    }

    if ($CI->mdl_settings->setting('default_language') == 'polish') {
        $grosze = substr($quote->quote_total, strrpos($quote->quote_total, '.') + 1);
        $balance_in_words = 'Słownie: '.DeskdooUtils::slownie(floor($quote->quote_total)).' '.(int)$grosze.'/100';
    } else {
        $balance_in_words = '';
    }

    $items = $CI->mdl_quote_items->where('quote_id', $quote_id)->get()->result();

    foreach ($items as $item) {
        if (empty($taxes_subtotal['total'][$item->item_tax_rate_id])) {
            $taxes_subtotal['total'][$item->item_tax_rate_id]  = 0;
            $taxes_subtotal['netto'][$item->item_tax_rate_id]  = 0;
            $taxes_subtotal['brutto'][$item->item_tax_rate_id] = 0;
        }

        $taxes_subtotal['total'][$item->item_tax_rate_id]  += $item->item_tax_total;
        $taxes_subtotal['netto'][$item->item_tax_rate_id]  += ($item->item_subtotal - $item->item_discount);
        $taxes_subtotal['brutto'][$item->item_tax_rate_id] += $item->item_total;
    }

    $data = array(
        'balance_in_words' => $balance_in_words,
        'quote'            => $quote,
        'quote_tax_rates'  => $CI->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
        'tax_rates'        => $CI->mdl_tax_rates->get_tax_rates(),
        'tax_subtotal'     => $taxes_subtotal,
        'items'            => $items,
        'output_type'      => 'pdf'
    );

    $html = $CI->load->view('quote_templates/pdf/' . $quote_template, $data, TRUE);

    $CI->load->helper('mpdf');

    return pdf_create($html, lang('quote') . '_' . str_replace(array('\\', '/'), '_', $quote->quote_number), $stream,$quote->quote_password);
}
