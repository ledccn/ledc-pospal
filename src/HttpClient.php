<?php

namespace Ledc\Pospal;

/**
 * 银豹请求客户端
 */
class HttpClient
{
    /**
     * @var Certificate
     */
    protected Certificate $certificate;

    /**
     * 构造函数
     * @param Certificate $certificate
     */
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * @return Certificate
     */
    public function getCertificate(): Certificate
    {
        return $this->certificate;
    }

    /**
     * 请求之前回调
     * @param string $url
     * @param array $data
     * @return void
     */
    protected function eventRequestBefore(string &$url, array &$data)
    {
    }

    /**
     * POST请求（自动处理签名逻辑）
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function postRequest(string $url, array $data): HttpResponse
    {
        // 请求之前回调
        $this->eventRequestBefore($url, $data);
        $json = json_encode($data);
        $signature = strtoupper(md5($this->getCertificate()->getAppKey() . $json));
        $timestamp = microtime(true) * 1000;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json; charset=utf-8",
            "User-Agent: openApi",
            //"accept-encoding: gzip,deflate",
            "time-stamp: " . $timestamp,
            "data-signature: " . $signature
        ]);
        curl_setopt($curl, CURLOPT_URL, $this->joinUrl($url));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

        $result = curl_exec($curl);
        $response = new HttpResponse($result, (int)curl_getinfo($curl, CURLINFO_RESPONSE_CODE), curl_errno($curl), curl_error($curl));
        // 请求之后回调
        $this->eventRequestAfter($url, $data, $response);
        curl_close($curl);

        return $response;
    }

    /**
     * 请求之后回调
     * @param string $url
     * @param array $data
     * @param HttpResponse $response
     * @return void
     */
    protected function eventRequestAfter(string $url, array $data, HttpResponse $response)
    {
    }

    /**
     * 拼接接口地址前缀，返回完整的URL
     * @param string $url
     * @return string
     */
    protected function joinUrl(string $url): string
    {
        return rtrim($this->getCertificate()->getUrlPrefix(), '/') . '/' . ltrim($url, '/');
    }
}
