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
 * This is the enhancement to the data container array for table tl_catalog_fields 
 * to allow the custom field type for CatalogUserIdField.
 *
 * PHP version 5
 * @copyright  Christian Schiffler 2009
 * @author     Christian Schiffler  <c.schiffler@cyberspectrum.de> 
 * @package    CatalogUserIdField
 * @license    LGPL 
 * @filesource
 */


/**
 * Table tl_catalog_fields 
 */

// Palettes
$GLOBALS['TL_DCA']['tl_catalog_fields']['palettes']['useridfield'] = 'name,description,colName,type,useridfield';

// register to catalog module that we provide the useridfield as field type.
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['type']['options'][] = 'useridfield';

// register our fieldtype editor to the catalog Fields
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['useridfield'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_catalog_fields']['useridfield'],
	'exclude'                 => true,
	'search'                  => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_member_group.name',
	'save_callback' => array(array('CatalogUserIdField', 'onSave')),
	'load_callback' => array(array('CatalogUserIdField', 'onLoad')),
	'checkPermissionFERecordEdit' => array(array('CatalogUserIdField', 'checkPermissionFERecordEdit')),
	'eval'      => array
	(
		'title' => &$GLOBALS['TL_LANG']['tl_catalog_fields']['useridfield'],
		'mandatory' => false,
		'multiple' => true,
		'doNotSaveEmpty' => true,
		'columns' => 1,
	)
);

?>