<?php
/*------------------------------------------------------------*/
class Menu extends Mcontroller {
	/*------------------------------------------------------------*/
	public function index() {
			$this->Mview->showTpl("menuDriver.tpl", array(
				'menu' => $this->dd(),
			));
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function dd() {
		$menu = array(
			'clones' => array(
				array(
					'name' => 'clones',
					'title' => 'Clones',
					'url' => "/",
				),
			),
			ClonesLogin::loginName() => array(
				array(
					'name' => 'landHere',
					'title' => 'Land Here',
					'url' => "/clones/landHere",
				),
				array(
					'name' => 'UnLand',
					'title' => 'unland (land latest)',
					'url' => "/clones/unland",
				),
				array(
					'divider' => '-----------------------',
				),
				array(
					'name' => 'logout',
					'title' => 'Log Off',
					'url' => "/?logOut=logOut",
				),
			),
		);
		return($menu);
	}
	/*------------------------------------------------------------*/
}

