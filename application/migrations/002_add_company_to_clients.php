<?php
/**
 * pZ:
 *
 * ALTER TABLE `ip_clients` ADD INDEX(`company_id`);
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_company_to_clients extends CI_Migration {

	public function up()
	{
		$col = array(
			'company_id' => array(
				'type' => 'INT',
				'constraint' => 11
			)
		);

		$this->dbforge->add_column('ip_clients', $col , 'client_id');

		log_message('info', 'Deskdoo Migration: ' . get_class());
	}

	public function down()
	{
	}
}
