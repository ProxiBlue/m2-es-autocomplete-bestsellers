# ProxiBlue AutocompleteBestsellers Magento 2 module

This modul will sort search autocomplete in bestsellers order.
Requires a purchased 3rd party module to work.

## Requirements

* https://redchamps.com/extra-sorting-options-magento-2-extension.html (adds in bestsellers data to product catalog)
* https://github.com/Smile-SA/elasticsuite

## Installation details

You can install via composer:

* ```composer config repositories.github.repo.repman.io composer https://github.repo.repman.io```
* ```composer require proxi-blue/module-autocomplete-bestsellers```
* ```bin/magento module:enable ProxiBlue_AutocompleteBestsellers```
* ```bin/magento setup:upgrade```
* ```bin/magento setup:di:compile```
* ```bin/magento setup:static-content:deploy```
* ```bin/magento cache:flush```

## Notes

The module is theme independent so should work with Luma and Hyva (tested on Hyva)
