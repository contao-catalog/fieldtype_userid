<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This is the catalog cataloghitsfield extension file.
 *
 * PHP version 5
 * @copyright  Christian Schiffler 2009
 * @author     Christian Schiffler  <c.schiffler@cyberspectrum.de> 
 * @package    CatalogUserIdField
 * @license    LGPL 
 * @filesource
 */

// class to manipulate the field info to be as we want it to be, to render it and to make editing possible.
class CatalogUserIdField extends Backend {
	public function onSave($varValue, DataContainer $dc) {
		// force to our userid.
		if(FE_USER_LOGGED_IN && !BE_USER_LOGGED_IN)
		{
			$this->import('FrontendUser', 'Member');
			return $this->Member->id;
		}
		// BE or not logged in.
		return $varValue;
	}
	public function onLoad($varValue, DataContainer $dc) {
		return $varValue;
	}
	
	public function checkPermissionFERecordEdit($strTable, $fieldname, $arrValues) {
		if(empty($arrValues) || empty($arrValues[$fieldname]))
			return true;
		// check if it is our userid.
		if(FE_USER_LOGGED_IN && !BE_USER_LOGGED_IN)
		{
			$this->import('FrontendUser', 'Member');
			return $this->Member->id == $arrValues[$fieldname];
		}
		// BE or not logged in.
		return false;
	}
}
?>