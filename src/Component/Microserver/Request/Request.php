<?php
namespace YoLaile\Library\Component\Microserver\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;
use YoLaile\Library\Convention\Code\ErrorCode;
use YoLaile\Library\Convention\Code\SuccessCode;
use YoLaile\Library\Convention\Exception\ServiceErrorException;
use YoLaile\Library\Convention\Exception\ServiceLogicException;

class Request
{
    private $client;

    private $logger;

    private $headers;

    const HTTP_METHOD_GET    = "GET";
    const HTTP_METHOD_POST   = "POST";
    const HTTP_METHOD_DELETE = "DELETE";
    const HTTP_METHOD_PATCH  = "PATCH";
    const HTTP_METHOD_PUT    = "PUT";
    const RESULT_CODE        = 'code';

    public function __construct(
        array $headers = ["api-style" => "1"],
        LoggerInterface $logger = null
    ) {
        $this->logger    = $logger ?? new NullLogger();
        $this->headers   = $headers;
        $this->client = new Client();
    }

    /**
     * 发送请求
     *
     * @param RequestMetaData $requestMetaData
     * @return mixed
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:56
     */
    public function send(RequestMetaData $requestMetaData)
    {
        $headers = ['User-Agent' => 'micro-server/0.1'];
        $this->headers = array_merge($headers, $this->headers);

        $client = new Client([
            'headers'  => $this->headers
        ]);

        try {
            $res = $this->getHttpResult(
                $client,
                $requestMetaData->getMethod(),
                $requestMetaData->getRequestUri(),
                $requestMetaData->getRequestParams(),
                $this->headers);
        } catch (Throwable $ex) {
            $this->logger->warning("[" . date("Y-m-d H:i:s") . "]" .
                "http client failed  (code: " .
                $ex->getCode() . " msg:" . $ex->getMessage() . ")");
        }

        $body = $res->getBody();

        $result = \GuzzleHttp\json_decode($body, true);

        if (! property_exists($result, self::RESULT_CODE)) {
            $this->logger->error(' msg:' . ErrorCode::HTTP_ERROR_MSG . ' body:' . $body);
            throw new ServiceErrorException(
                ErrorCode::HTTP_ERROR_MSG,
                ErrorCode::HTTP_ERROR);
        }
        if ($result->code === SuccessCode::SUCCESS) {
            return $result->data;
        } else if (ErrorCode::isError($result->code)) {
            throw new ServiceErrorException($result->message, $result->code);
        } else {
            throw new ServiceLogicException($result->message, $result->code);
        }
    }

    /**
     * 发送请求
     *
     * @param Client $client
     * @param $method
     * @param $uri
     * @param $params
     * @param $headers
     * @return ResponseInterface
     * @throws GuzzleException
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:57
     */
    private function getHttpResult(Client $client, $method, $uri, $params, $headers): ResponseInterface
    {
        if ($method === self::HTTP_METHOD_GET) {
            $res = $client->get($uri, [ 'query' => $params, 'headers' => $headers ]);
        } elseif ($method === self::HTTP_METHOD_DELETE) {
            $res = $client->delete($uri, [ 'json' => $params, 'headers' => $headers ]);
        } elseif ($method === self::HTTP_METHOD_PATCH) {
            $res = $client->patch($uri, [ 'json' => $params, 'headers' => $headers ]);
        } elseif ($method === self::HTTP_METHOD_PUT) {
            $res = $client->put($uri, [ 'json' => $params, 'headers' => $headers ]);
        } else {
            $res = $client->post($uri, [ 'json' => $params, 'headers' => $headers ]);
        }

        return $res;
    }
}