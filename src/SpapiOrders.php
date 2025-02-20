<?php

namespace Zerotoprod\SpapiOrders;

use Zerotoprod\Container\Container;
use Zerotoprod\CurlHelper\CurlHelper;
use Zerotoprod\SpapiOrders\Contracts\SpapiOrdersInterface;
use Zerotoprod\SpapiOrders\Support\Testing\SpapiOrdersFake;

/**
 * Amazon Selling Partner API (SPAPI) Orders API
 *
 * Programmatically retrieve order information.
 *
 * Use the Orders Selling Partner API to programmatically retrieve order information.
 * With this API, you can develop fast, flexible, and custom applications to manage
 * order synchronization, perform order research, and create demand-based decision
 * support tools.
 *
 * @link https://github.com/zero-to-prod/spapi-orders
 * @see  https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference
 */
class SpapiOrders implements SpapiOrdersInterface
{
    /**
     * @var string
     */
    private $access_token;
    /**
     * @var string
     */
    private $base_uri;
    /**
     * @var string|null
     */
    private $user_agent;
    /**
     * @var array
     */
    private $options;

    /**
     * Instantiate this class.
     *
     * @param  string       $access_token  Access token to validate the request.
     * @param  string       $base_uri      The base URI for the Orders API
     * @param  string|null  $user_agent    The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options       Merge curl options.
     *
     * @link https://github.com/zero-to-prod/spapi-orders
     * @see  https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference
     */
    private function __construct(
        string $access_token,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com',
        ?string $user_agent = null,
        array $options = []
    ) {
        $this->access_token = $access_token;
        $this->base_uri = $base_uri;
        $this->user_agent = $user_agent;
        $this->options = $options;
    }

    /**
     * Instantiate this class.
     *
     * @param  string       $access_token  Access token to validate the request.
     * @param  string       $base_uri      The base URI for the Orders API
     * @param  string|null  $user_agent    The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options       Merge curl options.
     *
     * @link https://github.com/zero-to-prod/spapi-orders
     * @see  https://developer-docs.amazon.com/sp-api/docs/orders-api-v0-reference
     */
    public static function from(
        string $access_token,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com',
        ?string $user_agent = null,
        array $options = []
    ): SpapiOrdersInterface {
        return Container::getInstance()->has(SpapiOrdersFake::class)
            ? Container::getInstance()->get(SpapiOrdersFake::class)
            : new self($access_token, $base_uri, $user_agent, $options);
    }

    /**
     * @inheritDoc
     * @link https://github.com/zero-to-prod/spapi-orders
     */
    public function getOrders(
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

        return $this->get(
            "$this->base_uri/orders/v0/orders?$query",
            ["x-amz-access-token: $this->access_token"],
            $this->user_agent,
            array_merge($options, $this->options)
        );
    }

    /**
     * @inheritDoc
     * @link https://github.com/zero-to-prod/spapi-orders
     */
    public function getOrder(string $orderId, array $options = []): array
    {
        return $this->get(
            "$this->base_uri/orders/v0/orders/$orderId",
            ["x-amz-access-token: $this->access_token"],
            $this->user_agent,
            array_merge($options, $this->options)
        );
    }

    /**
     * @inheritDoc
     * @link https://github.com/zero-to-prod/spapi-orders
     */
    public function getOrderBuyerInfo(string $orderId, array $options = []): array
    {
        return $this->get(
            "$this->base_uri/orders/v0/orders/$orderId/buyerInfo",
            ["x-amz-access-token: $this->access_token"],
            $this->user_agent,
            array_merge($options, $this->options)
        );
    }

    /**
     * @inheritDoc
     * @link https://github.com/zero-to-prod/spapi-orders
     */
    public function getOrderAddress(string $orderId, array $options = []): array
    {
        return $this->get(
            "$this->base_uri/orders/v0/orders/$orderId/address",
            ["x-amz-access-token: $this->access_token"],
            $this->user_agent,
            array_merge($options, $this->options)
        );
    }

    /**
     * @inheritDoc
     * @link https://github.com/zero-to-prod/spapi-orders
     */
    public function getOrderItems(string $orderId, array $options = []): array
    {
        return $this->get(
            "$this->base_uri/orders/v0/orders/$orderId/orderItems",
            ["x-amz-access-token: $this->access_token"],
            $this->user_agent,
            array_merge($options, $this->options)
        );
    }

    /**
     * @inheritDoc
     * @link https://github.com/zero-to-prod/spapi-orders
     */
    public function getOrderItemsBuyerInfo(string $orderId, array $options = []): array
    {
        return $this->get(
            "$this->base_uri/orders/v0/orders/$orderId/orderItems/buyerInfo",
            ["x-amz-access-token: $this->access_token"],
            $this->user_agent,
            array_merge($options, $this->options)
        );
    }

    private function get(string $url, array $headers, ?string $user_agent = null, array $options = []): array
    {
        $CurlHandle = curl_init($url);

        curl_setopt_array(
            $CurlHandle,
            [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array_merge(
                    [
                        'accept: application/json',
                        'x-amz-date: '.gmdate('Ymd\THis\Z'),
                        'user-agent: '.($user_agent ?: '(Language=PHP/'.PHP_VERSION.'; Platform='.php_uname('s').'/'.php_uname('r').')')
                    ],
                    $headers
                ),
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