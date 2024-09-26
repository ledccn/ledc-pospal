<?php

namespace Ledc\Pospal;

/**
 * HTTP响应
 */
class HttpResponse
{
    /**
     * 响应
     * @var bool|string
     */
    protected $response;
    /**
     * 响应代码
     * @var int
     */
    protected int $statusCode = 0;
    /**
     * 返回最后一次的错误代码，错误代码或在没有错误发生时返回 0 (零)
     * @var int
     */
    protected int $curlErrorNo = 0;
    /**
     * 返回错误信息，或者如果没有任何错误发生就返回 '' (空字符串)。
     * @var string
     */
    protected string $curlErrorMessage = '';

    /**
     * 构造函数
     * @param bool|string $response
     * @param int $statusCode
     * @param int $curlErrorNo
     * @param string $curlErrorMessage
     */
    public function __construct($response, int $statusCode, int $curlErrorNo, string $curlErrorMessage)
    {
        $this->response = $response;
        $this->statusCode = $statusCode;
        $this->curlErrorNo = $curlErrorNo;
        $this->curlErrorMessage = $curlErrorMessage;
    }

    /**
     * 获取响应体
     * @return bool|string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 获取响应的HTTP状态码
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * 获取错误代码
     * - 在没有错误发生时返回 0 (零)
     * @return int
     */
    public function getCurlErrorNo(): int
    {
        return $this->curlErrorNo;
    }

    /**
     * 获取错误信息
     * - 没有任何错误发生就返回 '' (空字符串)。
     * @return string
     */
    public function getCurlErrorMessage(): string
    {
        return $this->curlErrorMessage;
    }

    /**
     * 判断响应成功
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return 200 <= $this->getStatusCode() && $this->getStatusCode() < 300;
    }

    /**
     * 判断响应失败啦
     * @return bool
     */
    public function isFailed(): bool
    {
        return !$this->isSuccessful();
    }
}
