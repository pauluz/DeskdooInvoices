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

class Response_Model extends Form_Validation_Model
{
    // pZ: to lista modułów gdzie wymagane jest dostawienie kolumny 'company_id' w db_array()
    var $tables_with_company_id = array(
        'ip_clients',
        'ip_invoices',
        'ip_quotes',
        'ip_families',
        'ip_payment_methods',
        'ip_payments',
        'ip_products',
        'ip_projects',
        'ip_tasks',
        'ip_uploads',
        'ip_tax_rates',
    );

    /**
     * pZ: default_select
     *
     */
    public function default_select()
    {
        if (in_array($this->table, $this->tables_with_company_id)) {
            $this->filter_where($this->table . '.company_id', $this->session->userdata('deskdoo_company_id'));
        }
    }

    /**
     * pZ: db_array
     *
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        if (in_array($this->table, $this->tables_with_company_id)) {
            $db_array['company_id'] = $this->session->userdata('deskdoo_company_id');
        }

        return $db_array;
    }

    public function save($id = NULL, $db_array = NULL)
    {

        if ($id) {
            $this->session->set_flashdata('alert_success', lang('record_successfully_updated'));
            parent::save($id, $db_array);
        } else {
            $this->session->set_flashdata('alert_success', lang('record_successfully_created'));
            $id = parent::save(NULL, $db_array);
        }

        return $id;
    }

    public function delete($id)
    {
        // pZ: @TODO można zrobić sprawdzanie czy udało się w ogóle coś skasować...
        if (in_array($this->table, $this->tables_with_company_id)) {
            $this->db->where('company_id', $this->session->userdata('deskdoo_company_id'));
        }

        parent::delete($id);

        $this->session->set_flashdata('alert_success', lang('record_successfully_deleted'));
    }
}
?>
