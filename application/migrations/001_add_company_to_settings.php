<?php
/**
 * pZ:
 * Must be changed manually because its read during Migration !!!
 *
 * ALTER TABLE `ip_settings` ADD `company_id` INT(11) NOT NULL AFTER `setting_id`;
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_company_to_settings extends CI_Migration {

	public function up()
	{
        log_message('info', 'Deskdoo Migration: Table Settings must be changed manually !!!');
        return;

		$col = array(
			'company_id' => array(
				'type' => 'INT',
				'constraint' => 11
			)
		);

		$this->dbforge->add_column('ip_settings', $col , 'setting_id');

		log_message('info', 'Deskdoo Migration: ' . get_class());
	}

	public function down()
	{
	}
}
