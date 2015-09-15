<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * pZ:
 */

class Migrate extends Admin_Controller 
{
	public function index()
	{
		$this->load->library('migration');
		
		if (!$this->migration->current()) {
			show_error($this->migration->error_string());
		}
		echo 'end migration';
	}
}
/* End of file migrate.php */
/* Location: ./application/controllers/migrate.php */