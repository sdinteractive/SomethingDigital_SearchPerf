<?php

class SomethingDigital_SearchPerf_Model_Index_Action_Fulltext_Refresh_Row extends Enterprise_CatalogSearch_Model_Index_Action_Fulltext_Refresh_Row
{
    /**
     * Reset search results
     *
     * We are writing this as adding this WHERE is a lot faster
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
