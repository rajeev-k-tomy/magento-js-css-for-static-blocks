<?php
/**
 * installer
 *
 * @category   Extension
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */

$installer = $this;
//die(__FILE__);
$installer->startSetup();

$tableName = $installer->getTable('rkt_jscssforsb/jsCss');

// Check if the table already exists
if ($installer->getConnection()->isTableExists($tableName) != true) {

	$table = $installer->getConnection()->newTable($installer->getTable('rkt_jscssforsb/jsCss'))

	->addColumn('jscss_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity' => true,
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
		), 
		'JsCss Enity Id'
	)
	->addColumn('block_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable' => true,
		'unsigned' => true,
		), 
		'CMS Block Id'
	)
	->addColumn('jscss_css', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable' => true,
		), 
		'Css for CMS Block'
	)
	->addColumn('jscss_js', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable' => true,
		), 
		'JS for CMS Block'
	)

	->addForeignKey(
		$installer->getFkName(
		'rkt_jscssforsb/jsCss',
		'mcrypt_enc_is_block_algorithm_mode(td)',
		'cms/block',
		'block_id'
		),
		'block_id', $installer->getTable('cms/block'), 'block_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

	->setComment('Table for Rkt_JsCssforSb extension');

	$installer->getConnection()->createTable($table);
}


$installer->endSetup();
