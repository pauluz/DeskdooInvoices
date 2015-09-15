<?php
/**
 * pZ:
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_company_to_quotes extends CI_Migration {

	public function up()
	{
		$col = array(
			'company_id' => array(
				'type' => 'INT',
				'constraint' => 11
			)
		);

		$this->dbforge->add_column('ip_quotes', $col , 'quote_id');

		log_message('info', 'Deskdoo Migration: ' . get_class());
	}

	public function down()
	{
	}
}
