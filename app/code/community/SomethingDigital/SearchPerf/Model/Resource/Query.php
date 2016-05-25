<?php

class SomethingDigital_SearchPerf_Model_Resource_Query extends Mage_CatalogSearch_Model_Resource_Query
{
    /**
     * Custom load model by search query string
     *
     * We are rewriting as the UNION performs much better than the OR here
     *
     * @param Mage_Core_Model_Abstract $object
     * @param string $value
     * @return Mage_CatalogSearch_Model_Resource_Query
     */
    public function loadByQuery(Mage_Core_Model_Abstract $object, $value)
    {
        $select = $this->_getReadAdapter()->select()
            ->union(array(
                $this->loadByQueryPart('synonym_for', $object, $value),
                $this->loadByQueryPart('query_text', $object, $value)))
            ->order('synonym_for ASC')
            ->limit(1);

        if ($data = $this->_getReadAdapter()->fetchRow($select)) {
            $object->setData($data);
            $this->_afterLoad($object);
        }

        return $this;
    }

    protected function loadByQueryPart($part, $object, $value)
    {
        return $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where($part . '=?', $value)
            ->where('store_id=?', $object->getStoreId());
    }
}
