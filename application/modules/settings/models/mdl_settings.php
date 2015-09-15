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

class Mdl_Settings extends Response_Model
{
    public $settings = array();

    /**
     * pZ: get
     *
     * @param bool     $key
     * @param bool|int $get_default_value - integer or boolean==false
     *
     * @return mixed|null
     */
    public function get($key, $get_default_value = false)
    {
        $this->db->select('setting_value');
        $this->db->where('setting_key', $key);

        // pZ:
        if ($get_default_value) {
            $this->db->where('company_id', 0);
        } else {
            $this->db->where('company_id', $this->session->userdata('deskdoo_company_id'));
        }

        $query = $this->db->get('ip_settings');

        if ($query->row()) {
            return $query->row()->setting_value;
        } else {
            return NULL;
        }
    }

    /**
     * pZ: validation_bcc_email
     *
     * @return array
     */
    public function validation_bcc_email()
    {
        return array(
            'bcc_mails_to_admin_email' => array(
                'field' => 'settings[bcc_mails_to_admin_email]',
                'label' => lang('user_type'),
                'rules' => 'valid_email'
            ),
        );
    }

    public function save($key, $value)
    {
        $db_array = array(
            'setting_key' => $key,
            'setting_value' => $value,
            // pZ:
            'company_id' => $this->session->userdata('deskdoo_company_id'),
        );

        if ($this->get($key) !== NULL) {
            $this->db->where('setting_key', $key);
            $this->db->where('company_id', $this->session->userdata('deskdoo_company_id')); // pZ:
            $this->db->update('ip_settings', $db_array);
        } else {
            $this->db->insert('ip_settings', $db_array);
        }
    }

    public function delete($key)
    {
        $this->db->where('setting_key', $key);
        $this->db->where('company_id', $this->session->userdata('deskdoo_company_id'));
        $this->db->delete('ip_settings');
    }

    public function load_settings($get_default_values = false)
    {
        if ($get_default_values) {
            $company_id = 0;
        } else {
            $company_id = $this->session->userdata('deskdoo_company_id');
        }

        $ip_settings = $this->db
            ->where('company_id', $company_id)
            ->get('ip_settings')
            ->result();

        if (empty($ip_settings)) {
            $ip_settings = $this->db->get('ip_settings')->result();

            foreach ($ip_settings as $data) {
                $this->save($data->setting_key, $data->setting_value);
//                $db_array = array(
//                    'setting_key' => $data->setting_key,
//                    'setting_value' => $data->setting_value,
//                    'company_id' => $company_id,
//                );
//                $this->db->insert('ip_settings', $db_array);
            }
        }

        foreach ($ip_settings as $data) {
            $this->settings[$data->setting_key] = $data->setting_value;
        }
    }

    public function setting($key)
    {
        return (isset($this->settings[$key])) ? $this->settings[$key] : '';
    }

    public function set_setting($key, $value)
    {
        $this->settings[$key] = $value;
    }

}
