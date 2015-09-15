<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Profiler Sections
| -------------------------------------------------------------------------
| This file lets you determine whether or not various sections of Profiler
| data are displayed when the Profiler is enabled.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/profiling.html
|
*/

// pZ:
// uruchomienie:
// piszemy w kontrolerze (np. w /application/modules/dashboard/controllers/dashboard.php):
// $this->output->enable_profiler(TRUE);

$config['benchmarks']         = FALSE;
//$config['config']             = FALSE;
$config['controller_info']    = FALSE;
//$config['get']                = FALSE;
$config['http_headers']       = FALSE;
$config['memory_usage']       = FALSE;
$config['post']               = FALSE;
$config['queries']            = FALSE;
$config['uri_string']         = FALSE;
$config['query_toggle_count'] = 10;


/* End of file profiler.php */
/* Location: ./application/config/profiler.php */