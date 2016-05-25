<?php

class SomethingDigital_SearchPerf_Model_Index_Action_Fulltext_Refresh extends Enterprise_CatalogSearch_Model_Index_Action_Fulltext_Refresh
{
    /**
     * Reset search results
     *
     * We are writing this as adding this WHERE is a lot faster
     *
     * NOTE: This won't get called if you're using SOLR, but updating just in case we
     * ever roll back to MySQL Fulltext for some reason
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
}
