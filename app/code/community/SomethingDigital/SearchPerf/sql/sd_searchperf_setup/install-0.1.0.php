<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()
    ->addIndex(
        $installer->getTable('catalogsearch/search_query'),
        $installer->getIdxName('catalogsearch/search_query', array('synonym_for')),
        'synonym_for'
    );

$installer->endSetup();
