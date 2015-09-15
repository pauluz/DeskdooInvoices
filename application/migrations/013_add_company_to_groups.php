<?php
/**
 * pZ:
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_company_to_groups extends CI_Migration {

    public function up()
    {
        $col = array(
            'company_id' => array(
                'type'       => 'INT',
                'constraint' => 11
            ),
            'invoice_group_type' => array(
                'type'       => 'INT',
                'constraint' => 11
            ),
        );

        $this->dbforge->add_column('ip_groups', $col, 'invoice_group_id');

        log_message('info', 'Deskdoo Migration: ' . get_class());
    }

    public function down()
    {
    }
}
