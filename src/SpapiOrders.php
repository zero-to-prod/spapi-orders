<?php

namespace Zerotoprod\SpapiOrders;

use Zerotoprod\CurlHelper\CurlHelper;

/**
 * Use the Orders Selling Partner API to programmatically retrieve order information.
 * With this API, you can develop fast, flexible, and custom applications to manage
 * order synchronization, perform order research, and create demand-based decision
 * support tools.
 *
 * @link https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference
 */
class SpapiOrders
{
    /**
     * @param  string   $base_uri                         Base endpoint for order.
     * @param  string   $access_token                     Access token to validate the request.
     * @param  array    $MarketplaceIds                   A list of `MarketplaceId` values. Used to select orders that were placed in the specified marketplaces.
     *
     *  Refer to [Marketplace IDs](https://developer-docs.amazon.com/sp-api/docs/marketplace-ids) for a complete list of `marketplaceId` values.
     * @param  ?string  $CreatedAfter                     Use this date to select orders created after (or at) a specified time. Only orders placed after the specified time are returned. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     *
     *  **Note**: Either the `CreatedAfter` parameter or the `LastUpdatedAfter` parameter is required. Both cannot be empty. `LastUpdatedAfter` and `LastUpdatedBefore` cannot be set when `CreatedAfter` is set.
     * @param  ?string  $CreatedBefore                    Use this date to select orders created before (or at) a specified time. Only orders placed before the specified time are returned. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     *
     *  **Note**: `CreatedBefore` is optional when `CreatedAfter` is set. If specified, `CreatedBefore` must be equal to or after the `CreatedAfter` date and at least two minutes before current time.
     * @param  ?string  $LastUpdatedAfter                 Use this date to select orders that were last updated after (or at) a specified time. An update is defined as any change in order status, including the creation of a new order. Includes updates made by Amazon and by the seller. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     *
     *  **Note**: Either the `CreatedAfter` parameter or the `LastUpdatedAfter` parameter is required. Both cannot be empty. `CreatedAfter` or `CreatedBefore` cannot be set when `LastUpdatedAfter` is set.
     * @param  ?string  $LastUpdatedBefore                Use this date to select orders that were last updated before (or at) a specified time. An update is defined as any change in order status, including the creation of a new order. Includes updates made by Amazon and by the seller. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     *
     *  **Note**: `LastUpdatedBefore` is optional when `LastUpdatedAfter` is set. But if specified, `LastUpdatedBefore` must be equal to or after the `LastUpdatedAfter` date and at least two minutes before current time.
     * @param  ?array   $OrderStatuses                    A list of `OrderStatus` values used to filter the results.
     *
     *  **Possible values:**
     *  - `PendingAvailability` (This status is available for pre-orders only. The order has been placed, payment has not been authorized, and the release date of the item is in the future.)
     *  - `Pending` (The order has been placed but payment has not been authorized.)
     *  - `Unshipped` (Payment has been authorized and the order is ready for shipment, but no items in the order have been shipped.)
     *  - `PartiallyShipped` (One or more, but not all, items in the order have been shipped.)
     *  - `Shipped` (All items in the order have been shipped.)
     *  - `InvoiceUnconfirmed` (All items in the order have been shipped. The seller has not yet given confirmation to Amazon that the invoice has been shipped to the buyer.)
     *  - `Canceled` (The order has been canceled.)
     *  - `Unfulfillable` (The order cannot be fulfilled. This state applies only to Multi-Channel Fulfillment orders.)
     * @param  ?array   $FulfillmentChannels              A list that indicates how an order was fulfilled. Filters the results by fulfillment channel.
     *
     *  **Possible values**: `AFN` (fulfilled by Amazon), `MFN` (fulfilled by seller).
     * @param  ?array   $PaymentMethods                   A list of payment method values. Use this field to select orders that were paid with the specified payment methods.
     *
     *  **Possible values**: `COD` (cash on delivery), `CVS` (convenience store), `Other` (Any payment method other than COD or CVS).
     * @param  ?string  $BuyerEmail                       The email address of a buyer. Used to select orders that contain the specified email address.
     * @param  ?string  $SellerOrderId                    An order identifier that is specified by the seller. Used to select only the orders that match the order identifier. If `SellerOrderId` is specified, then `FulfillmentChannels`, `OrderStatuses`, `PaymentMethod`, `LastUpdatedAfter`, LastUpdatedBefore, and `BuyerEmail` cannot be specified.
     * @param  ?int     $MaxResultsPerPage                A number that indicates the maximum number of orders that can be returned per page. Value must be 1 - 100. Default 100.
     * @param  ?array   $EasyShipShipmentStatuses         A list of `EasyShipShipmentStatus` values. Used to select Easy Ship orders with statuses that match the specified values. If `EasyShipShipmentStatus` is specified, only Amazon Easy Ship orders are returned.
     *
     *  **Possible values:**
     *  - `PendingSchedule` (The package is awaiting the schedule for pick-up.)
     *  - `PendingPickUp` (Amazon has not yet picked up the package from the seller.)
     *  - `PendingDropOff` (The seller will deliver the package to the carrier.)
     *  - `LabelCanceled` (The seller canceled the pickup.)
     *  - `PickedUp` (Amazon has picked up the package from the seller.)
     *  - `DroppedOff` (The package is delivered to the carrier by the seller.)
     *  - `AtOriginFC` (The packaged is at the origin fulfillment center.)
     *  - `AtDestinationFC` (The package is at the destination fulfillment center.)
     *  - `Delivered` (The package has been delivered.)
     *  - `RejectedByBuyer` (The package has been rejected by the buyer.)
     *  - `Undeliverable` (The package cannot be delivered.)
     *  - `ReturningToSeller` (The package was not delivered and is being returned to the seller.)
     *  - `ReturnedToSeller` (The package was not delivered and was returned to the seller.)
     *  - `Lost` (The package is lost.)
     *  - `OutForDelivery` (The package is out for delivery.)
     *  - `Damaged` (The package was damaged by the carrier.)
     * @param  ?array   $ElectronicInvoiceStatuses        A list of `ElectronicInvoiceStatus` values. Used to select orders with electronic invoice statuses that match the specified values.
     *
     *  **Possible values:**
     *  - `NotRequired` (Electronic invoice submission is not required for this order.)
     *  - `NotFound` (The electronic invoice was not submitted for this order.)
     *  - `Processing` (The electronic invoice is being processed for this order.)
     *  - `Errored` (The last submitted electronic invoice was rejected for this order.)
     *  - `Accepted` (The last submitted electronic invoice was submitted and accepted.)
     * @param  ?string  $NextToken                        A string token returned in the response of your previous request.
     * @param  ?array   $AmazonOrderIds                   A list of `AmazonOrderId` values. An `AmazonOrderId` is an Amazon-defined order identifier, in 3-7-7 format.
     * @param  ?string  $ActualFulfillmentSupplySourceId  The `sourceId` of the location from where you want the order fulfilled.
     * @param  ?bool    $IsIspu                           When true, this order is marked to be picked up from a store rather than delivered.
     * @param  ?string  $StoreChainStoreId                The store chain store identifier. Linked to a specific store in a store chain.
     * @param  ?string  $EarliestDeliveryDateBefore       Use this date to select orders with a earliest delivery date before (or at) a specified time. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     * @param  ?string  $EarliestDeliveryDateAfter        Use this date to select orders with a earliest delivery date after (or at) a specified time. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     * @param  ?string  $LatestDeliveryDateBefore         Use this date to select orders with a latest delivery date before (or at) a specified time. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     * @param  ?string  $LatestDeliveryDateAfter          Use this date to select orders with a latest delivery date after (or at) a specified time. The date must be in [ISO 8601](https://developer-docs.amazon.com/sp-api/docs/iso-8601) format.
     * @param  array    $options                          Merge curl options.
     * @param ?string   $user_agent                       The user-agent for the request. If none is supplied, a default one will be provided.
     *
     * @return array{
     *    "info": array{
     *      "url": string,
     *      "content_type": string,
     *      "http_code": int,
     *      "header_size": int,
     *      "request_size": int,
     *      "filetime": int,
     *      "ssl_verify_result": int,
     *      "redirect_count": int,
     *      "total_time": float,
     *      "namelookup_time": float,
     *      "connect_time": float,
     *      "pretransfer_time": float,
     *      "size_upload": int,
     *      "size_download": int,
     *      "speed_download": int,
     *      "speed_upload": int,
     *      "download_content_length": int,
     *      "upload_content_length": int,
     *      "starttransfer_time": float,
     *      "redirect_time": float,
     *      "redirect_url": string,
     *      "primary_ip": string,
     *      "certinfo": array,
     *      "primary_port": int,
     *      "local_ip": string,
     *      "local_port": int,
     *      "http_version": int,
     *      "protocol": int,
     *      "ssl_verifyresult": int,
     *      "scheme": string,
     *      "appconnect_time_us": int,
     *      "connect_time_us": int,
     *      "namelookup_time_us": int,
     *      "pretransfer_time_us": int,
     *      "redirect_time_us": int,
     *      "starttransfer_time_us": int,
     *      "total_time_us": int
     *    },
     *    "error": string,
     *    "headers": array<string, string>,
     *    "response": array{
     *      "payload": array{
     *        "Orders": array{
     *          array{
     *            "BuyerInfo": array{
     *              "BuyerEmail": string,
     *              "BuyerName": string
     *            },
     *            "AmazonOrderId": string,
     *            "EarliestDeliveryDate": string,
     *            "EarliestShipDate": string,
     *            "SalesChannel": string,
     *            "AutomatedShippingSettings": array{
     *              "HasAutomatedShippingSettings": bool
     *            },
     *            "OrderStatus": string,
     *            "NumberOfItemsShipped": int,
     *            "OrderType": string,
     *            "IsPremiumOrder": bool,
     *            "IsPrime": bool,
     *            "FulfillmentChannel": string,
     *            "NumberOfItemsUnshipped": int,
     *            "HasRegulatedItems": bool,
     *            "IsReplacementOrder": string,
     *            "IsSoldByAB": bool,
     *            "LatestShipDate": string,
     *            "ShipServiceLevel": string,
     *            "DefaultShipFromLocationAddress": array{
     *              "StateOrRegion": string,
     *              "AddressLine1": string,
     *              "PostalCode": string,
     *              "City": string,
     *              "CountryCode": string,
     *              "Name": string
     *            },
     *            "IsISPU": bool,
     *            "MarketplaceId": string,
     *            "LatestDeliveryDate": string,
     *            "PurchaseDate": string,
     *            "ShippingAddress": array{
     *              "StateOrRegion": string,
     *              "AddressLine2": string,
     *              "AddressLine1": string,
     *              "PostalCode": string,
     *              "City": string,
     *              "CountryCode": string,
     *              "Name": string
     *            },
     *            "IsAccessPointOrder": bool,
     *            "SellerOrderId": string,
     *            "PaymentMethod": string,
     *            "IsBusinessOrder": bool,
     *            "OrderTotal": array{
     *              "CurrencyCode": string,
     *              "Amount": string
     *            },
     *            "PaymentMethodDetails": array<string>,
     *            "IsGlobalExpressEnabled": bool,
     *            "LastUpdateDate": string,
     *            "ShipmentServiceLevelCategory": string
     *          }
     *        },
     *        "NextToken": string,
     *        "CreatedBefore": string
     *      }
     *    }
     *  }
     * @link https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference#get-ordersv0ordersorderid
     */
    public static function getOrders(
        string $base_uri,
        string $access_token,
        array $MarketplaceIds,
        ?string $CreatedAfter = null,
        ?string $CreatedBefore = null,
        ?string $LastUpdatedAfter = null,
        ?string $LastUpdatedBefore = null,
        ?array $OrderStatuses = null,
        ?array $FulfillmentChannels = null,
        ?array $PaymentMethods = null,
        ?string $BuyerEmail = null,
        ?string $SellerOrderId = null,
        ?int $MaxResultsPerPage = null,
        ?array $EasyShipShipmentStatuses = null,
        ?array $ElectronicInvoiceStatuses = null,
        ?string $NextToken = null,
        ?array $AmazonOrderIds = null,
        ?string $ActualFulfillmentSupplySourceId = null,
        ?bool $IsIspu = null,
        ?string $StoreChainStoreId = null,
        ?string $EarliestDeliveryDateBefore = null,
        ?string $EarliestDeliveryDateAfter = null,
        ?string $LatestDeliveryDateBefore = null,
        ?string $LatestDeliveryDateAfter = null,
        string $user_agent = null,
        array $options = []
    ): array {
        $query = http_build_query(
            array_filter([
                'MarketplaceIds' => implode('&', $MarketplaceIds),
                'CreatedAfter' => $CreatedAfter,
                'CreatedBefore' => $CreatedBefore,
                'LastUpdatedAfter' => $LastUpdatedAfter,
                'LastUpdatedBefore' => $LastUpdatedBefore,
                'OrderStatuses' => implode('&', $OrderStatuses ?? []),
                'FulfillmentChannels' => implode('&', $FulfillmentChannels ?? []),
                'PaymentMethods' => implode('&', $PaymentMethods ?? []),
                'BuyerEmail' => $BuyerEmail,
                'SellerOrderId' => $SellerOrderId,
                'MaxResultsPerPage' => $MaxResultsPerPage,
                'EasyShipShipmentStatuses' => implode('&', $EasyShipShipmentStatuses ?? []),
                'ElectronicInvoiceStatuses' => implode('&', $ElectronicInvoiceStatuses ?? []),
                'NextToken' => $NextToken,
                'AmazonOrderIds' => implode('&', $AmazonOrderIds ?? []),
                'ActualFulfillmentSupplySourceId' => $ActualFulfillmentSupplySourceId,
                'IsISPU' => $IsIspu,
                'StoreChainStoreId' => $StoreChainStoreId,
                'EarliestDeliveryDateBefore' => $EarliestDeliveryDateBefore,
                'EarliestDeliveryDateAfter' => $EarliestDeliveryDateAfter,
                'LatestDeliveryDateBefore' => $LatestDeliveryDateBefore,
                'LatestDeliveryDateAfter' => $LatestDeliveryDateAfter,
            ])
        );

        return self::get(
            $base_uri.'/orders/v0/orders?'.$query,
            ["x-amz-access-token: $access_token"],
            $user_agent,
            $options
        );
    }

    /**
     * Returns the order that you specify.
     *
     * @param  string  $base_uri      Base endpoint for order.
     * @param  string  $access_token  Access token to validate the request.
     * @param  string  $orderId       Amazon order id
     * @param  array   $options       Merge curl options.
     * @param ?string  $user_agent    The user-agent for the request. If none is supplied, a default one will be provided.
     *
     * @return array{
     *     info: array{
     *         url: string,
     *         content_type: string,
     *         http_code: int,
     *         header_size: int,
     *         request_size: int,
     *         filetime: int,
     *         ssl_verify_result: int,
     *         redirect_count: int,
     *         total_time: float,
     *         namelookup_time: float,
     *         connect_time: float,
     *         pretransfer_time: float,
     *         size_upload: int,
     *         size_download: int,
     *         speed_download: int,
     *         speed_upload: int,
     *         download_content_length: int,
     *         upload_content_length: int,
     *         starttransfer_time: float,
     *         redirect_time: float,
     *         redirect_url: string,
     *         primary_ip: string,
     *         certinfo: array,
     *         primary_port: int,
     *         local_ip: string,
     *         local_port: int,
     *         http_version: int,
     *         protocol: int,
     *         ssl_verifyresult: int,
     *         scheme: string,
     *         appconnect_time_us: int,
     *         connect_time_us: int,
     *         namelookup_time_us: int,
     *         pretransfer_time_us: int,
     *         redirect_time_us: int,
     *         starttransfer_time_us: int,
     *         total_time_us: int
     *     },
     *     error: string,
     *     headers: array{
     *         Server: string,
     *         Date: string,
     *         Content-Type: string,
     *         Content-Length: string,
     *         Connection: string,
     *         X-Amz-Rid: string,
     *         X-Amzn-Ratelimit-Limit: string,
     *         X-Amzn-Requestid: string,
     *         X-Amz-Apigw-Id: string,
     *         X-Amzn-Trace-Id: string,
     *         Vary: string,
     *         Strict-Transport-Security: string
     *     },
     *     response: array{
     *         payload: array{
     *             BuyerInfo: array{
     *                 BuyerEmail: string,
     *                 BuyerName: string
     *             },
     *             AmazonOrderId: string,
     *             EarliestShipDate: string,
     *             SalesChannel: string,
     *             OrderStatus: string,
     *             NumberOfItemsShipped: int,
     *             OrderType: string,
     *             IsPremiumOrder: bool,
     *             IsPrime: bool,
     *             FulfillmentChannel: string,
     *             NumberOfItemsUnshipped: int,
     *             HasRegulatedItems: bool,
     *             IsReplacementOrder: bool,
     *             IsSoldByAB: bool,
     *             LatestShipDate: string,
     *             ShipServiceLevel: string,
     *             IsISPU: bool,
     *             MarketplaceId: string,
     *             PurchaseDate: string,
     *             ShippingAddress: array{
     *                 StateOrRegion: string,
     *                 AddressLine1: string,
     *                 PostalCode: string,
     *                 City: string,
     *                 CountryCode: string,
     *                 Name: string
     *             },
     *             IsAccessPointOrder: bool,
     *             SellerOrderId: string,
     *             PaymentMethod: string,
     *             IsBusinessOrder: bool,
     *             OrderTotal: array{
     *                 CurrencyCode: string,
     *                 Amount: string
     *             },
     *             PaymentMethodDetails: array<string>,
     *             IsGlobalExpressEnabled: bool,
     *             LastUpdateDate: string,
     *             ShipmentServiceLevelCategory: string
     *         }
     *     }
     * }
     * @link https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference#get-ordersv0ordersorderid
     */
    public static function getOrder(
        string $base_uri,
        string $access_token,
        string $orderId,
        ?string $user_agent = null,
        array $options = []
    ): array {
        return self::get(
            $base_uri.'/orders/v0/orders/'.$orderId,
            ["x-amz-access-token: $access_token"],
            $user_agent,
            $options
        );
    }

    private static function get(string $url, array $headers, ?string $user_agent = null, array $options = []): array
    {
        $CurlHandle = curl_init($url);

        curl_setopt_array(
            $CurlHandle,
            [
                CURLOPT_HTTPHEADER => array_merge(
                    [
                        'x-amz-date: '.gmdate('Ymd\THis\Z'),
                        'user-agent: '.($user_agent ?: '(Language=PHP/'.PHP_VERSION.'; Platform='.php_uname('s').'/'.php_uname('r').')')
                    ],
                    $headers
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
            ] + $options
        );

        $response = curl_exec($CurlHandle);
        $info = curl_getinfo($CurlHandle);
        $error = curl_error($CurlHandle);
        $header_size = curl_getinfo($CurlHandle, CURLINFO_HEADER_SIZE);

        curl_close($CurlHandle);

        return [
            'info' => $info,
            'error' => $error,
            'headers' => CurlHelper::parseHeaders($response, $header_size),
            'response' => json_decode(substr($response, $header_size), true)
        ];
    }
}