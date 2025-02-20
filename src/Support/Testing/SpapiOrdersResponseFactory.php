<?php

namespace Zerotoprod\SpapiOrders\Support\Testing;

use Zerotoprod\Factory\Factory;

/**
 * @link https://github.com/zero-to-prod/spapi-orders
 */
class SpapiOrdersResponseFactory
{
    use Factory;

    private function definition(): array
    {
        return array(
            'info' => [
                'url' => 'https://sellingpartnerapi-na.amazon.com/orders/v0/orders/123-1234567-1234567',
                'content_type' => 'application/json',
                'http_code' => 200,
                'header_size' => 470,
                'request_size' => 2560,
                'filetime' => -1,
                'ssl_verify_result' => 0,
                'redirect_count' => 0,
                'total_time' => 1.32608,
                'namelookup_time' => 0.008719,
                'connect_time' => 1.087884,
                'pretransfer_time' => 1.182583,
                'size_upload' => 0.0,
                'size_download' => 1021.0,
                'speed_download' => 769.0,
                'speed_upload' => 0.0,
                'download_content_length' => 1021.0,
                'upload_content_length' => -1.0,
                'starttransfer_time' => 1.326,
                'redirect_time' => 0.0,
                'redirect_url' => '',
                'primary_ip' => '44.215.139.122',
                'certinfo' => [],
                'primary_port' => 443,
                'local_ip' => '172.22.0.2',
                'local_port' => 44176,
            ],
            'error' => '',
            'headers' => [
                'Server' => 'Server',
                'Date' => 'Thu, 20 Feb 2025 21:47:01 GMT',
                'Content-Type' => 'application/json',
                'Content-Length' => '1021',
                'Connection' => 'keep-alive',
                'X-Amz-Rid' => 'EQ2C31TCR4JC1QF5G3DM',
                'X-Amzn-Ratelimit-Limit' => '0.5',
                'X-Amzn-Requestid' => '3f8c91b2-0f36-4f5a-b1be-8326aaff71e1',
                'X-Amz-Apigw-Id' => 'OPF3f8c91b20f36',
                'X-Amzn-Trace-Id' => 'Root=1-67b7a2d5-3f8c91b20f364f5a',
                'Vary' => 'Content-Type,Accept-Encoding,User-Agent',
                'Strict-Transport-Security' => 'max-age=47474747; includeSubDomains; preload',
            ],
            'response' => []
        );
    }
}