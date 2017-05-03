<?php

class SomethingDigital_SearchPerf_Model_Resource_Fulltext extends Mage_CatalogSearch_Model_Resource_Fulltext
{
    use SomethingDigital_SearchPerf_Trait_ResetsSearchResults;

    /**
     * Reset search results
     *
     * We are rewriting this method as adding the where makes this a lot faster
     *
     * See: http://magento.stackexchange.com/questions/53529/magento-enterprise-slow-product-save-w-and-wo-solr-integration
     *
     * @return Mage_CatalogSearch_Model_Resource_Fulltext
     */
    public function resetSearchResults()
    {
        $this->_doResetQueries();
        Mage::dispatchEvent('catalogsearch_reset_search_result');

        return $this;
    }
}
