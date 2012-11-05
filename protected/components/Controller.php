<?php
/*
 * Copyright (C) 2012 FOSS-Group
 *                    Germany
 *                    http://www.foss-group.de
 *                    support@foss-group.de
 *
 * Authors:
 *  Christian Wittkowski <wittkowski@devroom.de>
 *
 * Licensed under the EUPL, Version 1.1 or – as soon they
 * will be approved by the European Commission - subsequent
 * versions of the EUPL (the "Licence");
 * You may not use this work except in compliance with the
 * Licence.
 * You may obtain a copy of the Licence at:
 *
 * http://www.osor.eu/eupl
 *
 * Unless required by applicable law or agreed to in
 * writing, software distributed under the Licence is
 * distributed on an "AS IS" basis,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied.
 * See the Licence for the specific language governing
 * permissions and limitations under the Licence.
 *
 *
 */

/**
 * Controller class file.
 *
 * @author: Christian Wittkowski <wittkowski@devroom.de>
 * @version: 0.4
 */

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'application.views.layouts.column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='application.views.layouts.osbd';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $submenu=array();
	/**
	 * @var string name of the active submenu.
	 */
	public $activesubmenu = '';

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @var string url to get some help about this page.
	 */
	public $helpurl = null;
	/**
	 * @var string title of this page.
	 */
	public $title = 'Error';

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function init() {
		Yii::app()->getClientScript()->registerCoreScript('jquery');
		Yii::app()->getclientScript()->registerCssFile($this->cssBase . '/jquery/osbd/jquery-ui.custom.css');
	}

	/**
	 * Create the standard submenu.
	 *
	 * @return void
	 */
	protected function createMenu() {
		$action = '';
		if (!is_null($this->action)) {
			$action = $this->action->id;
		}
		//echo "action: $action; " . $this->id , '<br/>';

		if (Yii::app()->user->isAdmin) {
			$this->submenu = array(
				'vm' => array(
					'label' => Yii::t('menu', 'Virtual Machine'),
					'items' => array(
						'vm' => array(
							'label' => Yii::t('menu', 'Static Virtual Machines'),
							'url' => array('/vm/index', 'vmtype' => 'static'),
							'itemOptions' => array('title' => Yii::t('menu', 'static Virtual Machines Tooltip')),
							'active' => ($this->id == 'vm' && $action == 'index' && isset($_GET['vmtype']) && 'static' == $_GET['vmtype'])
						),
						'vmdyn' => array(
							'label' => Yii::t('menu', 'Dynamic Virtual Machines'),
							'url' => array('/vm/index', 'vmtype' => 'dynamic'),
							'itemOptions' => array('title' => Yii::t('menu', 'dynamic Virtual Machines Tooltip')),
							'active' => ($this->id == 'vm' && $action == 'index' && isset($_GET['vmtype']) && 'dynamic' == $_GET['vmtype'])
						),
						'vmtemplate' => array(
							'label' => Yii::t('menu', 'Virtual Machine Templates'),
							'url' => array('/vmTemplate/index'),
							'itemOptions' => array('title' => Yii::t('menu', 'Virtual Machine Templates Tooltip')),
							'active' => ($this->id == 'vmTemplate' && $action == 'index'),
							'items' => array(
								array(
									'label' => Yii::t('menu', 'Create'),
									'url' => array('/vmTemplate/create'),
									'itemOptions' => array('title' => Yii::t('menu', 'Virtual Machine Template Create Tooltip')),
									'active' => ($this->id == 'vmTemplate' && $action == 'create'),
								),
							),
						),
						'vmprofile' => array(
							'label' => Yii::t('menu', 'Virtual Machine Profiles'),
							'url' => array('/vmProfile/index'),
							'itemOptions' => array('title' => Yii::t('menu', 'Virtual Machine Profiles Tooltip')),
							'active' => ($this->id == 'vmProfile' && $action == 'index'),
							'items' => array(
								array(
									'label' => Yii::t('menu', 'Create'),
									'url' => array('/vmProfile/create'),
									'itemOptions' => array('title' => Yii::t('menu', 'Virtual Machine Profile Create Tooltip')),
									'active' => ($this->id == 'vmProfile' && $action == 'create'),
								),
								array(
									'label' => Yii::t('menu', 'Upload Iso File'),
									'url' => 'http://www.foss-cloud.org/en/index.php/Upload_ISO-Files', //array('/vmProfile/uploadIso'),
									'itemOptions' => array('title' => Yii::t('menu', 'Virtual Machine Profile UploadIso Tooltip')),
									'linkOptions' => array('target'=>'_blank'),
									'active' => ($this->id == 'vmProfile' && $action == 'uploadIso'),
								),
							),
						)
					),
				),
				'vmpool' => array(
					'label' => Yii::t('menu', 'VM Pool'),
					'items' => array(
						'vmpool' => array(
							'label' => Yii::t('menu', 'VM Pools'),
							'url' => array('/vmPool/index'),
							'itemOptions' => array('title' => Yii::t('menu', 'VM Pools Tooltip')),
							'active' => ($this->id == 'vmpool' && $action == 'index'),
							'items' => array(
								array(
									'label' => Yii::t('menu', 'Create'),
									'url' => array('/vmPool/create'),
									'itemOptions' => array('title' => Yii::t('menu', 'VM Pool Create Tooltip')),
									'active' => ($this->id == 'node' && $action == 'create'),
								),
							),
						),
					),
				),
				'storagepool' => array(
					'label' => Yii::t('menu', 'Storage Pool'),
					'items' => array(
						'node' => array(
							'label' => Yii::t('menu', 'Storage Pools'),
							'url' => array('/storagePool/index'),
							'itemOptions' => array('title' => Yii::t('menu', 'Storage Pools Tooltip')),
							'active' => ($this->id == 'storagePool' && $action == 'index'),
							'items' => array(
								array(
									'label' => Yii::t('menu', 'Create'),
									'url' => array('/storagePool/create'),
									'itemOptions' => array('title' => Yii::t('menu', 'Storage Pool Create Tooltip')),
									'active' => ($this->id == 'storagePool' && $action == 'create'),
								),
							),
						),
					),
				),
				'node' => array(
					'label' => Yii::t('menu', 'Node'),
					'items' => array(
						'node' => array(
							'label' => Yii::t('menu', 'Nodes'),
							'url' => array('/node/index'),
							'itemOptions' => array('title' => Yii::t('menu', 'Nodes Tooltip')),
							'active' => ($this->id == 'node' && $action == 'index'),
							'items' => array(
								array(
									'label' => Yii::t('menu', 'Create'),
									'url' => array('/node/wizard'),
									'itemOptions' => array('title' => Yii::t('menu', 'Node Create Tooltip')),
									'active' => ($this->id == 'node' && $action == 'wizard'),
								),
							),
						),
					),
				),
				'network' => array(
					'label' => Yii::t('menu', 'Network'),
					'items' => array(
						'subnet' => array(
							'label' => Yii::t('menu', 'Subnets'),
							'url' => array('/subnet/index'),
							'itemOptions' => array('title' => Yii::t('menu', 'Subnet Tooltip')),
							'active' => ($this->id == 'subnet' && $action == 'index'),
							'items' => array(
								array(
									'label' => Yii::t('menu', 'Create'),
									'url' => array('/subnet/create'),
									'itemOptions' => array('title' => Yii::t('menu', 'Subnet Create Tooltip')),
									'active' => ($this->id == 'subnet' && $action == 'create'),
								),
							),
						),
					),
				),
				'user' => array(
					'label' => Yii::t('menu', 'User'),
					'items' => array(
						'user' => array(
							'label' => Yii::t('menu', 'User'),
							'url' => array('/user/index'),
							'itemOptions' => array('title' => Yii::t('menu', 'User Tooltip')),
							'active' => ($this->id == 'user' && $action == 'index'),
							'items' => array(
								array(
									'label' => Yii::t('menu', 'Create'),
									'url' => array('/user/create'),
									'itemOptions' => array('title' => Yii::t('menu', 'User Create Tooltip')),
									'active' => ($this->id == 'user' && $action == 'create'),
								),
							),
						),
					),
				),
				'diag' => array(
					'label' => 'Diagnostics',
					'items' => array(
						'vminfos' => array(
							'label' => 'VM Infos',
							'url' => array('/diagnostics/vminfos'),
							'active' => ($this->id == 'diagnostics' && $action == 'vminfos'),
						),
						'vmtemplateinfos' => array(
							'label' => 'VM Template Infos',
							'url' => array('/diagnostics/vmtemplateinfos'),
							'active' => ($this->id == 'diagnostics' && $action == 'vmtemplateinfos'),
						),
						'ldapattrtypes' => array(
							'label' => 'LDAP Attribute Types',
							'url' => array('/diagnostics/ldapattrtypes'),
							'active' => ($this->id == 'diagnostics' && $action == 'ldapattrtypes'),
						),
						'ldapobjclasses' => array(
							'label' => 'LDAP Object Classes',
							'url' => array('/diagnostics/ldapobjclasses'),
							'active' => ($this->id == 'diagnostics' && $action == 'ldapobjclasses'),
						),
					),
				),
			);
		}
		else {
			$this->submenu = array();
		}
		$this->submenu['vmlist'] = array(
			'label' => Yii::t('menu', 'Assigned VMs'),
			'items' => array(
				array(
					'label' => Yii::t('menu', 'VmList'),
					'url' => array('/vmList/index'),
					'itemOptions' => array('title' => Yii::t('menu', 'VmList Tooltip')),
					'active' => ($this->id == 'vmList' && $action == 'index')
				),
			),
		);
	}

	/**
	 * This method is invoked right before an action is to be executed (after all possible filters.)
	 * You may override this method to do last-minute preparation for the action.
	 * @param CAction $action the action to be executed.
	 * @return boolean whether the action should be executed.
	 */
	protected function beforeAction($action) {
		$retval = parent::beforeAction($action);
		if ($retval) {
			Yii::app()->setLanguage(Yii::app()->getSession()->get('lang', 'en'));
			$this->createMenu();
		}
		return $retval;
	}
	/**
	 * This method is invoked right after an action is executed.
	 * You may override this method to do some postprocessing for the action.
	 * @param CAction the action just executed.
	 */
	protected function afterAction($action)
	{
		if (CLdapServer::hasInstance()) {
			CLdapServer::getInstance()->close();
		}
	}

	/**
	 * Get the base url of the css to use.
	 *
	 * @return string url
	 */
	public function getCssBase() {
		$base = Yii::app()->request->baseUrl . '/css';
		$themes = Yii::app()->params['easyThemes'];
		if (isset($themes[$_SERVER["HTTP_HOST"]])) {
			$base .= '/' . $themes[$_SERVER["HTTP_HOST"]];
		}
		else {
			$base .= '/default';
		}
		return $base;
	}

	/**
	 * Get the select box for all supported languages.
	 *
	 * @return string HTML Code
	 */
	public function getLanguageSelector($lang) {
		$retval = '<select name="lang" id="lang" onchange="this.form.submit();" style="background: transparent url(' . $this->imageBase . '/lang/' . $lang . '.png) no-repeat 1px 4px; padding-left: 20px;">';
		$messagesDir = Yii::app()->getBasePath() . '/messages';
		$files = scandir ($messagesDir);
		foreach ($files as $file) {
        	if (false === strpos($file, '.') && is_dir($messagesDir . '/' . $file)) {
        		$retval .= '<option value="' . $file . '"' . ($file == $lang ? 'selected="selected"' : '') . ' style="background: transparent url(' . $this->imageBase . '/lang/' . $file . '.png) no-repeat 1px 2px; padding-left: 20px;">' . strtoupper($file) . '</option>';
			}
		}

		$retval .= '</select>';

		return $retval;
	}

	/**
	 * Get the base url of the images directory.
	 *
	 * @return string url
	 */
	public function getImageBase() {
		$baseurl = Yii::app()->baseUrl;
		return Yii::app()->baseUrl . '/images';
	}

	private static $_sizes = array('GB' => 1073741824, 'MB' => 1048576, 'KB' => 1024, 'B' => 1);
	protected function getHumanSize($bytes) {
		foreach(self::$_sizes as $key => $value) {
			if ($bytes >= $value) {
				return round($bytes / $value, 2) . ' ' . $key;
			}
		}
	}

	protected function getBytes($sizestring) {
		if ( is_numeric($sizestring) ) {
			return $sizestring;
		}
		else {
			$len = strlen($sizestring);
			$value = substr($sizestring, 0, $len - 1);
			$unit = strtolower(substr($sizestring, $len - 1));
			switch ($unit) {
				case 'k':
					$value *= 1024;
					break;
				case 'm':
					$value *= 1048576;
					break;
				case 'g':
					$value *= 1073741824;
					break;
			}
			return $value;
		}

	}

	protected function createAjaxAnswer($items) {
		$retval = '<?xml version=\'1.0\' encoding=\'utf-8\'?>';
		$retval .= '<response>';
		foreach($items as $tag => $value) {
			$retval .= "<$tag>$value</$tag>";
		}
		$retval .= '</response>';
		return $retval;
	}
	protected function sendAjaxAnswer($items) {
		$s = $this->createAjaxAnswer($items);
		header('Content-Type: application/xml');
		header('Content-Length: ' . strlen($s));
		echo $s;
	}

	protected function sendJsonAnswer($data) {
		$s = CJavaScript::jsonEncode($data);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 01 Jan 2000 05:00:00 GMT');
		header('Content-Type: application/json');
		header('Content-Length: ' . strlen($s));
		echo $s;
	}

	protected function disableWebLogRoutes()
	{
		foreach (Yii::app()->log->routes as $route)
			if ($route instanceof CWebLogRoute)
				$route->enabled = false;
	}

	protected function createDropdown($data, $both=false) {
		$retval = array();
		foreach($data as $key => $value) {
			if ($both) {
				$retval[$key] = $value;
			}
			else {
				$retval[$value] = $value;
			}
		}
		return $retval;
	}

	protected function createDropdownFromLdapRecords($items, $key, $value) {
		$retval = array();
		foreach($items as $item) {
			$retval[$item->$key] = $item->$value;
		}
		return $retval;
	}

	public function getNextUid() {
		$retval = null;  // means that someone else want's to get a Uid at the moment
		$server = CLdapServer::getInstance();
		$dn = 'cn=nextfreeuid,ou=administration';
		$result = $server->findByDn($dn);
		if (1 != $result['count']) {
			throw new CLdapException(Yii::t('osbd', 'Error reading "nextfreeuid"'));
		}
		if (!isset($result[0]['title']))
		{
			$data = array('title' => 'locked');
			$server->modify($dn, $data);

			$retval = (int) $result[0]['uid'][0];

			$data = array('uid' => $retval + 1);
			$server->modify($dn, $data);

			$data = array('title' => array());
			$server->modify_del($dn, $data);
		}
		return $retval;
	}
}