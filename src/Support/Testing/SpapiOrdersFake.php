<?php

namespace Zerotoprod\SpapiOrders\Support\Testing;

use Zerotoprod\Container\Container;
use Zerotoprod\SpapiOrders\Contracts\SpapiOrdersInterface;

/**
 * @link https://github.com/zero-to-prod/spapi-orders
 */
class SpapiOrdersFake implements SpapiOrdersInterface
{
    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    /**
     * Fakes a response.
     *
     * @link https://github.com/zero-to-prod/spapi-orders
     */
    public static function fake(array $response = [], ?SpapiOrdersInterface $fake = null): SpapiOrdersInterface
    {
        Container::getInstance()
            ->instance(
                __CLASS__,
                $instance = $fake ?? new self($response)
            );

        return $instance;
    }

    public function getOrders(array $MarketplaceIds, ?string $CreatedAfter = null, ?string $CreatedBefore = null, ?string $LastUpdatedAfter = null, ?string $LastUpdatedBefore = null, ?array $OrderStatuses = null, ?array $FulfillmentChannels = null, ?array $PaymentMethods = null, ?string $BuyerEmail = null, ?string $SellerOrderId = null, ?int $MaxResultsPerPage = null, ?array $EasyShipShipmentStatuses = null, ?array $ElectronicInvoiceStatuses = null, ?string $NextToken = null, ?array $AmazonOrderIds = null, ?string $ActualFulfillmentSupplySourceId = null, ?bool $IsIspu = null, ?string $StoreChainStoreId = null, ?string $EarliestDeliveryDateBefore = null, ?string $EarliestDeliveryDateAfter = null, ?string $LatestDeliveryDateBefore = null, ?string $LatestDeliveryDateAfter = null, array $options = []): array
    {
        return $this->response;
    }

    public function getOrder(string $orderId, array $options = []): array
    {
        return $this->response;
    }

    public function getOrderBuyerInfo(string $orderId, array $options = []): array
    {
        return $this->response;
    }

    public function getOrderAddress(string $orderId, array $options = []): array
    {
        return $this->response;
    }

    public function getOrderItems(string $orderId, array $options = []): array
    {
        return $this->response;
    }

    public function getOrderItemsBuyerInfo(string $orderId, array $options = []): array
    {
        return $this->response;
    }
}