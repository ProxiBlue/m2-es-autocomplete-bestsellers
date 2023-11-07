<?php

/*
 * (c) Lucas van Staden <sales@proxiblue.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ProxiBlue\AutocompleteBestsellers\Model\ResourceModel\Product\Fulltext;

use Smile\ElasticsuiteCatalog\Model\ResourceModel\Product\Fulltext\Collection as SmileProductCollection;

/**
 * Product collection.
 *
 * @category ProxiBlue
 * @package  ProxiBlue\AutocompleteBestsellers
 */
class Collection extends SmileProductCollection
{

    /**
     * {@inheritDoc}
     */
    public function addAttributeToSort($attribute, $dir = self::SORT_ORDER_ASC)
    {
        // force sort of autocomplete to be bestseller
        return \Magento\Catalog\Model\ResourceModel\Product\Collection::addAttributeToSort('bestseller', self::SORT_ORDER_DESC);
    }

    protected function _afterLoad()
    {
        return \Magento\Catalog\Model\ResourceModel\Product\Collection::_afterLoad();
    }

    protected function _renderFiltersBefore()
    {
        parent::_renderFiltersBefore();
        $this->getSelect()->reset(\Magento\Framework\DB\Select::ORDER);
        $this->getSelect()->order('bestseller DESC');
        return $this;
    }

}
