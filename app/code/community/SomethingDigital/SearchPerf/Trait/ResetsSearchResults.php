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
        $this->_doResetQueries();
        $this->_app->dispatchEvent('enterprise_catalogsearch_reset_search_result', array());
    }

    /**
     * Perform actual reset queries.
     *
     * @return void
     */
    protected function _doResetQueries()
    {
        if (!$this->shouldSkipResetQueries()) {
            $adapter = $this->_getWriteAdapter();
            $adapter->update($this->_getTable('catalogsearch/search_query'), array('is_processed' => 0), array('is_processed != 0'));
            $adapter->delete($this->_getTable('catalogsearch/result'));
        }
    }

    /**
     * Check if we're using EE 1.14.3+ or CE 1.9.3+, where deleting is skipped.
     *
     * @return boolean
     */
    protected function shouldSkipResetQueries()
    {
        $version = Mage::getVersionInfo();
        $skip = false;
        if (Mage::getEdition() == Mage::EDITION_ENTERPRISE) {
            $skip = $version['major'] >= 1 && $version['minor'] >= 14 && $version['revision'] >= 3;
        } else {
            $skip = $version['major'] >= 1 && $version['minor'] >= 9 && $version['revision'] >= 3;
        }
        return $skip;
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
