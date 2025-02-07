# Zerotoprod\SpapiOrders

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/spapi-orders)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-orders/test.yml?label=test)](https://github.com/zero-to-prod/spapi-orders/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/spapi-orders?color=blue)](https://packagist.org/packages/zero-to-prod/spapi-orders/stats)
[![php](https://img.shields.io/packagist/php-v/zero-to-prod/spapi-orders.svg?color=purple)](https://packagist.org/packages/zero-to-prod/spapi-orders/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/spapi-orders?color=f28d1a)](https://packagist.org/packages/zero-to-prod/spapi-orders)
[![License](https://img.shields.io/packagist/l/zero-to-prod/spapi-orders?color=pink)](https://github.com/zero-to-prod/spapi-orders/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/spapi-orders.svg)](https://wakatime.com/badge/github/zero-to-prod/spapi-orders)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/spapi-orders?branch=main)](https://hitsofcode.com/github/zero-to-prod/spapi-orders/view?branch=main)

## Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [getOrders](#getorders)
  - [getOrder](#getorder)
  - [getOrderBuyerInfo](#getorderbuyerinfo)
  - [getOrderItems](#getorderitems)
- [Local Development](./LOCAL_DEVELOPMENT.md)
- [Contributing](#contributing)

## Introduction

Amazon Selling Partner API (SPAPI) Orders API.

## Requirements

- PHP 7.1 or higher.

## Installation

Install `Zerotoprod\SpapiOrders` via [Composer](https://getcomposer.org/):

```bash
composer require zero-to-prod/spapi-orders
```

This will add the package to your project’s dependencies and create an autoloader entry for it.

## Usage

### getOrders

Returns orders that are created or updated during the specified time period. If you want to return specific types of orders, you can apply filters to your request. NextToken doesn't affect any filters that you include in your request; it only impacts the pagination for the filtered orders response.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$orders_response = SpapiOrders::getOrders(
    'https://sellingpartnerapi-na.amazon.com', 
    'access_token',
    ['MarketplaceIds']
    'CreatedAfter'
    'CreatedBefore'
    'LastUpdatedAfter'
    'LastUpdatedBefore'
    '[OrderStatuses']
    ['FulfillmentChannels']
    ['PaymentMethods']
    'BuyerEmail'
    'SellerOrderId'
    MaxResultsPerPage
    ['EasyShipShipmentStatuses']
    ['ElectronicInvoiceStatuses']
    'NextToken'
    ['AmazonOrderIds']
    'ActualFulfillmentSupplySourceId'
    'IsISPU'
    'StoreChainStoreId'
    'EarliestDeliveryDateBefore'
    'EarliestDeliveryDateAfter'
    'LatestDeliveryDateBefore'
    'LatestDeliveryDateAfter'
    'user-agent',
    ['curl-options']
);

$amazon_order_id = $orders_response['response']['payload']['Orders'][0]['AmazonOrderId']
```

### getOrder

Returns the order that you specify.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$orders_response = SpapiOrders::getOrder(
    'https://sellingpartnerapi-na.amazon.com', 
    'access_token',
    '123-1234567-1234567',
    'user-agent',
    ['curl-options']
);

$amazon_order_id = $orders_response['response']['payload']['AmazonOrderId']
```

### getOrderBuyerInfo

Returns buyer information for the order that you specify.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$orders_response = SpapiOrders::getOrderBuyerInfo(
    'https://sellingpartnerapi-na.amazon.com', 
    'access_token',
    '123-1234567-1234567',
    'user-agent',
    ['curl-options']
);

$buyer_name = $orders_response['response']['payload']['BuyerName']
```

### getOrderItems

Returns detailed order item information for the order that you specify. If NextToken is provided, it's used to retrieve the next page of order items.

Note: When an order is in the Pending state (the order has been placed but payment has not been authorized), the getOrderItems operation does not return information about pricing, taxes, shipping charges, gift status or promotions for the order items in the order. After an order leaves the Pending state (this occurs when payment has been authorized) and enters the Unshipped, Partially Shipped, or Shipped state, the getOrderItems operation returns information about pricing, taxes, shipping charges, gift status and promotions for the order items in the order.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$order_items_response = SpapiOrders::getOrderItems(
    'https://sellingpartnerapi-na.amazon.com', 
    'access_token',
    '123-1234567-1234567',
    'user-agent',
    ['curl-options']
);

$seller_sku = $order_items_response['response']['payload']['OrderItems'][0]['SellerSKU']
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/spapi-orders/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.