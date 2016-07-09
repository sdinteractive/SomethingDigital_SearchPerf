<?php

/**
 * @property Mage_Core_Model_App $_app Application model.
 */
trait SomethingDigital_SearchPerf_Trait_ResetsSearchResults
{
    /**
     * Reset search results
     *
     * We are rewriting this as adding this WHERE is a lot faster
     *
     * @return void
     */
    protected function _resetSearchResults()
    {
        $adapter = $this->_getWriteAdapter();
        $adapter->update($this->_getTable('catalogsearch/search_query'), array('is_processed' => 0), array('is_processed != 0'));
        $adapter->delete($this->_getTable('catalogsearch/result'));

        $this->_app->dispatchEvent('enterprise_catalogsearch_reset_search_result', array());
    }

    /**
     * Retrieve a write adapter to the database.
     *
     * @return Varien_Db_Adapter_Interface
     */
    abstract protected function _getWriteAdapter();

    /**
     * Proxy for resource getTable()
     *
     * @param string $entityName Alias to retrieve.
     * @return string
     */
    abstract protected function _getTable($entityName);
}
