# Zerotoprod\SpapiOrders

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/spapi-orders)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-orders/test.yml?label=test)](https://github.com/zero-to-prod/spapi-orders/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-orders/backwards_compatibility.yml?label=backwards_compatibility)](https://github.com/zero-to-prod/spapi-orders/actions)
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
- [Documentation Publishing](#documentation-publishing)
    - [Automatic Documentation Publishing](#automatic-documentation-publishing)
- [Usage](#usage)
    - [getOrders](#getorders)
    - [getOrder](#getorder)
    - [getOrderBuyerInfo](#getorderbuyerinfo)
    - [getOrderAddress](#getorderaddress)
    - [getOrderItems](#getorderitems)
    - [getOrderItemsBuyerInfo](#getorderitemsbuyerinfo)
- [Testing](#testing)
    - [Factories](#factories)
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

This will add the package to your project's dependencies and create an autoloader entry for it.

## Documentation Publishing

You can publish this README to your local documentation directory.

This can be useful for providing documentation for AI agents.

This can be done using the included script:

```bash
# Publish to default location (./docs/zero-to-prod/spapi-orders)
vendor/bin/zero-to-prod-spapi-orders

# Publish to custom directory
vendor/bin/zero-to-prod-spapi-orders /path/to/your/docs
```

### Automatic Documentation Publishing

You can automatically publish documentation by adding the following to your `composer.json`:

```json
{
    "scripts": {
        "post-install-cmd": [
            "zero-to-prod-spapi-orders"
        ],
        "post-update-cmd": [
            "zero-to-prod-spapi-orders"
        ]
    }
}
```

## Usage

### getOrders

Returns orders that are created or updated during the specified time period. If you want to return specific types of orders, you can apply filters to
your request. NextToken doesn't affect any filters that you include in your request; it only impacts the pagination for the filtered orders response.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$orders_response = SpapiOrders::from('access_token')
->getOrders(
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
    ['curl-options']
);

$amazon_order_id = $orders_response['response']['payload']['Orders'][0]['AmazonOrderId']
```

### getOrder

Returns the order that you specify.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$order_response = SpapiOrders::from('access_token')
    ->getOrder('123-1234567-1234567', ['curl-options']);

$amazon_order_id = $order_response['response']['payload']['AmazonOrderId']
```

### getOrderBuyerInfo

Returns buyer information for the order that you specify.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$order_response = SpapiOrders::from('access_token')
    ->getOrderBuyerInfo('123-1234567-1234567', ['curl-options']);

$buyer_name = $order_response['response']['payload']['BuyerName']
```

### getOrderAddress

Returns the shipping address for a specific order.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$address_response = SpapiOrders::from('access_token')
    ->getOrderAddress(
        orderId: '123-1234567-1234567',
        options: [
            CURLOPT_TIMEOUT => 30,
        ]
    );

$shipping_address = $address_response['response']['payload'];
$address_line1 = $shipping_address['ShippingAddress']['AddressLine1'];
```

### getOrderItems

Returns detailed order item information for the order that you specify. If NextToken is provided, it's used to retrieve the next page of order items.

Note: When an order is in the Pending state (the order has been placed but payment has not been authorized), the getOrderItems operation does not
return information about pricing, taxes, shipping charges, gift status or promotions for the order items in the order. After an order leaves the
Pending state (this occurs when payment has been authorized) and enters the Unshipped, Partially Shipped, or Shipped state, the getOrderItems
operation returns information about pricing, taxes, shipping charges, gift status and promotions for the order items in the order.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$order_items_response = SpapiOrders::from('access_token')
    ->getOrderItems('123-1234567-1234567', ['curl-options']);

$seller_sku = $order_items_response['response']['payload']['OrderItems'][0]['SellerSKU']
```

### getOrderItemsBuyerInfo

Returns detailed buyer information for each order item within a specific order.

```php
use Zerotoprod\SpapiOrders\SpapiOrders;

$items_buyer_info_response = SpapiOrders::from('access_token')
    ->getOrderItemsBuyerInfo(
        orderId: '123-1234567-1234567',
        options: [
            CURLOPT_TIMEOUT => 30,
        ]
    );

$items_buyer_info_response['response']['payload']['OrderItems'][0]['OrderItemId'];
```

## Testing

The package provides `SpapiOrdersFake` for testing your application without making real API calls:

```php
use Zerotoprod\SpapiOrders\Support\Testing\SpapiOrdersFake;

$response = SpapiOrdersFake::fake(['response' => ['payload' => ['order' => 1]]]);

SpapiOrders::from('access_token')->getOrder('123-1234567-1234567');

$this->assertEquals(1, $response->getOrder('123-1234567-1234567')['response']['payload']['order']);
```

### Factories

Use the factory to populate the fake response with dummy data:

```php
$response = SpapiOrdersFake::fake(
    SpapiOrdersResponseFactory::factory([
        'response' => ['payload' => ['order' => 1]]
    ])->make()
);

SpapiOrders::from('access_token')->getOrder('123-1234567-1234567');

$this->assertEquals(1, $response->getOrder('123-1234567-1234567')['response']['payload']['order']);
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/spapi-orders/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.
