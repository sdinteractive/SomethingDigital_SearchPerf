<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()
    ->addIndex(
        $installer->getTable('catalogsearch/search_query'),
        $installer->getIdxName('catalogsearch/search_query', array('is_processed')),
        'is_processed'
    );

$installer->endSetup();
