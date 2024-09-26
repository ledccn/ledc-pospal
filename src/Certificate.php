<?php

namespace Ledc\Pospal;

/**
 * 银豹收银系统凭证
 */
class Certificate
{
    /**
     * 银豹appId
     * @var string
     */
    protected string $appId;
    /**
     * 银豹appKey
     * @var string
     */
    protected string $appKey;
    /**
     * 接口地址前缀
     * @var string
     */
    protected string $urlPrefix;

    /**
     * 构造函数
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * 银豹appId
     * @return string
     */
    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * 银豹appKey
     * @return string
     */
    public function getAppKey(): string
    {
        return $this->appKey;
    }

    /**
     * 接口地址前缀
     * @return string
     */
    public function getUrlPrefix(): string
    {
        return $this->urlPrefix;
    }
}
