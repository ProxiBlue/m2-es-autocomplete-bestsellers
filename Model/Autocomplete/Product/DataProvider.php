<?php

/*
 * (c) Lucas van Staden <sales@proxiblue.com.au>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Smile ElasticSuite to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteCatalog
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2020 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace ProxiBlue\AutocompleteBestsellers\Model\Autocomplete\Product;

use Magento\Search\Model\Autocomplete\DataProviderInterface;
use ProxiBlue\AutocompleteBestsellers\Model\ResourceModel\Product\Fulltext\Collection as ProductCollection;
use Smile\ElasticsuiteCatalog\Helper\Autocomplete as ConfigurationHelper;
use Smile\ElasticsuiteCatalog\Model\Autocomplete\Product\ItemFactory;
use Smile\ElasticsuiteCore\Api\Search\ContextInterface;

class DataProvider implements DataProviderInterface
{

    /**
     * Autocomplete type
     */
    const AUTOCOMPLETE_TYPE = "product";

    /**
     * Autocomplete result item factory
     *
     * @var ItemFactory
     */
    private $itemFactory;

    /**
     * @var ConfigurationHelper
     */
    private $configurationHelper;

    /**
     * @var string Autocomplete result type
     */
    private $type;

    /**
     * @var \ProxiBlue\AutocompleteBestsellers\Model\ResourceModel\Product\Fulltext\Collection
     */
    private $productCollection;

    /**
     * @var ContextInterface
     */
    private $searchContext;

    /**
     * Constructor.
     *
     * @param ItemFactory         $itemFactory               Suggest item factory.
     * @param Collection\Provide $productCollectionProvider Product collection provider.
     * @param ConfigurationHelper $configurationHelper       Autocomplete configuration helper.
     * @param ContextInterface    $searchContext             Query search context.
     * @param string              $type                      Autocomplete provider type.
     */
    public function __construct(
        ItemFactory $itemFactory,
        Collection\Provider $productCollectionProvider,
        ConfigurationHelper $configurationHelper,
        ContextInterface    $searchContext,
        $type = self::AUTOCOMPLETE_TYPE
    ) {
        $this->itemFactory         = $itemFactory;
        $this->configurationHelper = $configurationHelper;
        $this->searchContext       = $searchContext;
        $this->type                = $type;
        $this->productCollection   = $this->prepareProductCollection($productCollectionProvider->getProductCollection());
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function getItems()
    {
        $result = [];

        if ($this->configurationHelper->isEnabled($this->getType())) {
            foreach ($this->productCollection as $product) {
                $result[] = $this->itemFactory->create(['product' => $product, 'type' => $this->getType()]);
            }
        }

        return $result;
    }

    /**
     * Init suggested products collection.
     *
     * @param ProductCollection $productCollection Product collection
     *
     * @return ProductCollection
     */
    private function prepareProductCollection(ProductCollection $productCollection)
    {
        $productCollection->setPageSize($this->getResultsPageSize());
        $productCollection->addAttributeToSort('bestseller', \Magento\Framework\Data\Collection::SORT_ORDER_DESC);

        return $productCollection;
    }

    /**
     * Retrieve number of products to display in autocomplete results
     *
     * @return int
     */
    private function getResultsPageSize()
    {
        return $this->configurationHelper->getMaxSize($this->getType());
    }
}
