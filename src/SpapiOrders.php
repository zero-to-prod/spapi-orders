<?php

namespace Zerotoprod\SpapiOrders;

use Zerotoprod\CurlHelper\CurlHelper;

class SpapiOrders
{
    /**
     * Retrieves detailed information about an Amazon order.
     *
     * This method fetches and returns comprehensive data related to an Amazon order,
     * including order specifics, response headers, and potential errors.
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
     */
    public static function getOrder(string $amazon_order_id, string $access_token, string $base_uri = 'https://sellingpartnerapi-na.amazon.com/orders/v0/orders/'): array
    {
        $CurlHandle = curl_init($base_uri.$amazon_order_id);

        curl_setopt_array($CurlHandle, [
            CURLOPT_HTTPHEADER => [
                "x-amz-access-token: $access_token",
            ],
            CURLOPT_RETURNTRANSFER => true
        ]);

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