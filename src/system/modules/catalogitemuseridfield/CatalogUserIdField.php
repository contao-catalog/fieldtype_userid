<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * This is the cataloguseridfield extension file.
 *
 * PHP version 5
 * @copyright  Christian Schiffler 2009
 * @author     Christian Schiffler  <c.schiffler@cyberspectrum.de> 
 * @package    CatalogUserIdField
 * @license    LGPL 
 * @filesource
 */

// class to manipulate the field info to be as we want it to be, to render it and to make editing possible.
class CatalogUserIdField extends Frontend
{
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

	public function parseValue($id, $k, $raw, $blnImageLink, $objCatalog, $objModule)
	{
		$objUser = $this->Database->prepare('SELECT * FROM tl_member WHERE id=?')->execute($raw);
		return array
			(
			 	'items'	=> array($objUser->row()),
				'values' => array($objUser->row()),
			 	'html'  => '',
			);
	}

	public function generateFieldEditor(&$field, $objRow)
	{
		// TODO: shall we restrict this to Contao admins?
		if(TL_MODE == 'BE' && BE_USER_LOGGED_IN)
		{
			$objUser = $this->Database->prepare('SELECT * FROM tl_member')->execute();
			$arrOptions = array();
			while($objUser->next())
			{
				$arrOptions[$objUser->id] = sprintf('%s, %s', $objUser->firstname, $objUser->lastname);
			}
			$field['label'] = &$objRow->name;
			$field['title'] = &$objRow->description;
			$field['inputType'] = 'select';
			$field['options'] = $arrOptions;
		}
	}
}
?>