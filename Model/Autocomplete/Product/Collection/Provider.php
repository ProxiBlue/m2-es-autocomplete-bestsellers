<?php

namespace ProxiBlue\AutocompleteBestsellers\Model\Autocomplete\Product\Collection;

use ProxiBlue\AutocompleteBestsellers\Model\ResourceModel\Product\Fulltext\Collection as ProductCollection;

class Provider
{
    /**
     * @var ProductCollection
     */
    private $collection;

    /**
     * @var PreProcessorInterface[]
     */
    private $collectionProcessors;


    /**
     * Constructor.
     *
     * @param ProductCollection $collection           Product collection.
     * @param array             $collectionProcessors Product collection preprocessors.
     */
    public function __construct(ProductCollection $collection, $collectionProcessors = [])
    {
        $this->collectionProcessors = $collectionProcessors;
        $this->collection           = $this->prepareProductCollection($collection);
    }

    /**
     * Product collection used in autocomplete.
     *
     * @return ProductCollection
     */
    public function getProductCollection()
    {
        return $this->collection;
    }

    /**
     * Init suggested products collection.
     *
     * @param ProductCollection $collection Product collection
     *
     * @return ProductCollection
     */
    private function prepareProductCollection(ProductCollection $collection)
    {
        foreach ($this->collectionProcessors as $processor) {
            $collection = $processor->prepareCollection($collection);
        }

        return $collection;
    }
}
