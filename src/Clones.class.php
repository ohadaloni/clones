<?php
/*------------------------------------------------------------*/
class Clones extends Mcontroller {
	/*------------------------------------------------------------*/
	protected $loginName;
	protected $loginId;
	protected $loginType;
	/*------------------------------*/
	protected $cloneUtils;
	/*------------------------------*/
	private $startTime;
	/*------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();

		// permit is called before before()
		// and if fails, before is not called.
		$this->loginId = ClonesLogin::loginId();
		$this->loginName = ClonesLogin::loginName();
		$this->loginType = ClonesLogin::loginType();
		$this->cloneUtils = new CloneUtils;
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	protected function before() {
		ini_set('max_execution_time', 10);
		ini_set("memory_limit", "5M");

		$this->cloneUtils->prior($this->controller, $this->action, $this->loginName, $this->loginType, $this->loginId);
		$this->startTime = microtime(true);
		$this->Mview->assign(array(
			'controller' => $this->controller,
			'action' => $this->action,
		));
		if ( $this->showMargins()) {
			$this->Mview->showTpl("head.tpl", array(
				'title' => "Clones",
			));
			$this->Mview->showTpl("header.tpl");
			$menu = new Menu;
			$menu->index();
		}
		$method = @$_SERVER['REQUEST_METHOD'];
		if ( $method == "GET" ) {
			$url = @$_SERVER['REQUEST_URI'];
			if ( $this->redirectable($url) ) {
				$this->Mview->setCookie("lastVisit", $url);
			}
		}
	}
	/*------------------------------*/
	protected function after() {
		if ( ! $this->showMargins())
			return;
		$this->Mview->runningTime($this->startTime);
		$this->Mview->showTpl("footer.tpl");
		$this->Mview->showTpl("foot.tpl");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	public function index() {
		$loginType = ClonesLogin::loginType();
		$loginId = ClonesLogin::loginId();
		$sql = "select landHere from users where id = $loginId";
		$landHere = $this->Mmodel->getString($sql);
		if ( $this->redirectable($landHere) ) {
			$this->redirect($landHere);
			return;
		}
		$lastVisit = @$_COOKIE['lastVisit'];
		if ( $this->redirectable($lastVisit) ) {
			$this->redirect($lastVisit);
			return;
		}
		$this->redirect("/dashboard");
	}
	/*------------------------------------------------------------*/
	public function showLoginScreen() {
		$this->Mview->showTpl("head.tpl");
		$this->Mview->showTpl("header.tpl");
		$this->Mview->showTpl("login.tpl");
		$this->Mview->showTpl("footer.tpl");
		$this->Mview->showTpl("foot.tpl");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	public function landHere() {
		$referer = $_SERVER['HTTP_REFERER'];
		$parts = explode("/", $referer, 4);
		$landHere = "/".$parts[3];
		$affected = $this->Mmodel->dbUpdate("users", $this->loginId, array(
			'landHere' => $landHere,
		));
		$this->Mview->tell("landHere page set to $landHere", array(
			'rememberForNextPage' => true,
		));
		$this->redirect($landHere);
	}
	/*------------------------------------------------------------*/
	public function unland() {
		$affected = $this->Mmodel->dbUpdate("users", $this->loginId, array(
			'landHere' => null,
		));
		$this->Mview->tell("landHere page set to auto", array(
			'rememberForNextPage' => true,
		));
		$this->redirect("/");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function redirectable($url) {
		if ( ! $url )
			return(false);
		if ( $url == "/" )
			return(false);

		$parts = explode("?", $url);
		$parts = explode("/", $parts[0]);
		$pathParts = array();
		foreach ( $parts as $part )
			if ( $part != "" )
				$pathParts[] = $part;
		if ( ! $pathParts )
			$pathParts = array("clones", "index");

		$className = $pathParts[0];
		$action = @$pathParts[1];
		$action = $action ? $action : "index";
		$nots = array(
			'noMargins' => array(
				'any',
			),
			'clones' => array(
				'unland',
			),
		);
		foreach( $nots as $notClassName => $notClass )
			foreach( $notClass as $notAction )
				if ( strcasecmp($notClassName, $className) == 0
						&& 
						( strcasecmp($notAction, $action) == 0 || $notAction == 'any' )
					) {
						return(false);
					}

		$files = Mutils::listDir(".", "php");
		$baseName = null;
		foreach ( $files as $file ) {
			$fileParts = explode(".", $file);
			$baseName = reset($fileParts);
			if(strtolower($className) != strtolower($baseName) )
				continue;
			require_once($file);
			if ( ! class_exists($baseName) ) {
				return(false);
			}
			break;
		}
		if ( ! method_exists($baseName, $action) ) {
			return(false);
		}
		return(true);
	}
	/*------------------------------------------------------------*/
	private function showMargins() {
		if ( Mutils::isAjax() ) {
			return(false);
		}
		if( in_array($this->controller, array(
					'nomargins',
				))) {
			return(false);
		}
		if( in_array($this->action, array(
					// placeholder
				))) {
			return(false);
		}
		return(true);
	}
	/*------------------------------------------------------------*/
}
