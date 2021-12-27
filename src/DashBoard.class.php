<?php
/*------------------------------------------------------------*/
class DashBoard extends Clones {
	/*------------------------------------------------------------*/
	public function index() {
		Mview::print_r($_REQUEST, "_REQUEST", basename(__FILE__), __LINE__, null, false);
	}
	/*------------------------------------------------------------*/
}
