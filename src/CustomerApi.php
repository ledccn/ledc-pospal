<?php

namespace Ledc\Pospal;

/**
 * 银豹收银系统，会员API
 */
class CustomerApi extends HttpClient
{
    /**
     * 根据会员号查询会员
     * @param string $number 会员号
     * @return HttpResponse
     */
    public function queryByNumber(string $number): HttpResponse
    {
        return $this->postRequest('/pospal-api2/openapi/v1/customerOpenApi/queryByNumber', [
            'appId' => $this->getCertificate()->getAppId(),
            'customerNum' => $number
        ]);
    }

    /**
     * 根据会员在银豹系统的唯一标识查询
     * @param int $uid 会员在银豹系统的唯一标识
     * @return HttpResponse
     */
    public function queryByUid(int $uid): HttpResponse
    {
        return $this->postRequest('/pospal-api2/openapi/v1/customerOpenApi/queryByUid', [
            'appId' => $this->getCertificate()->getAppId(),
            'customerUid' => $uid
        ]);
    }

    /**
     * 根据会员手机号查询会员
     * @param string $tel 手机号
     * @return HttpResponse
     */
    public function queryByTel(string $tel): HttpResponse
    {
        return $this->postRequest('/pospal-api2/openapi/v1/customerOpenapi/queryBytel', [
            'appId' => $this->getCertificate()->getAppId(),
            'customerTel' => $tel
        ]);
    }

    /**
     * 修改会员余额积分
     * @param int $customerUid 会员在银豹系统的唯一标识
     * @param string $dataChangeTime 调用方的金额变动时间，格式为yyyy-MM-dd HH:mm:ss，不可为空。 2次请求时，如果customerUid 跟 dataChangeTime 都一样，会报错：重复提交修改
     * @param float $balanceIncrement 金额增长量,修改结果为银豹系统中的会员余额+balanceIncrement    传负数，表示扣减
     * @param float $pointIncrement 积分增长量, 修改结果为银豹系统中的会员积分+ pointIncrement    传负数，表示扣减
     * @param string $remark 备注
     * @return HttpResponse
     */
    public function updateBalancePointByUid(int $customerUid, string $dataChangeTime = '', float $balanceIncrement = 0, float $pointIncrement = 0, string $remark = ''): HttpResponse
    {
        $data = [
            'appId' => $this->getCertificate()->getAppId(),
            'customerUid' => $customerUid,
            'dataChangeTime' => $dataChangeTime
        ];
        $_balance = bccomp((string)$balanceIncrement, '0', 2);
        $_point = bcdiv((string)$pointIncrement, '0', 2);

        // 余额
        if (0 !== $_balance) {
            $data['balanceIncrement'] = $balanceIncrement;
            //当balanceIncrement为负数时，是否校验。1：校验 0或空：不校验（默认）
            //检验逻辑：扣完不能为负数或不许超过会员赊账额度。假设会员当前余额5元，balanceIncrement=-6，且会员不许赊账，则报错
            $data['validateBalance'] = 1;
        }

        // 积分
        if (0 !== $_point) {
            $data['pointIncrement'] = $pointIncrement;
            //当pointIncrement为负数时，是否校验。1：校验 0或空：不校验（默认）
            //检验逻辑：扣完不能为负数。假设会员当前5积分，pointIncrement=-6，则报错
            $data['validatePoint'] = 1;
        }

        // 积分
        if (!empty($remark)) {
            $data['remark'] = $remark;
        }

        return $this->postRequest('/pospal-api2/openapi/v1/customerOpenApi/updateBalancePointByIncrement', $data);
    }

    /**
     * 修改会员密码
     * @param int $customerUid 会员唯一标识
     * @param string $password 会员密码（明文），长度为1~16位
     * @return HttpResponse
     */
    public function updatePassword(int $customerUid, string $password): HttpResponse
    {
        return $this->postRequest('/pospal-api2/openapi/v1/customerOpenApi/updateCustomerPassword', [
            'appId' => $this->getCertificate()->getAppId(),
            'customerUid' => $customerUid,
            'customerPassword' => $password
        ]);
    }

    /**
     * 添加会员
     * @param array $data
     * @return HttpResponse
     */
    public function add(array $data): HttpResponse
    {
        if (isset($data['customerInfo'])) {
            $data['appId'] = $this->getCertificate()->getAppId();
        } else {
            $data = [
                'appId' => $this->getCertificate()->getAppId(),
                'customerInfo' => $data,
            ];
        }

        return $this->postRequest('/pospal-api2/openapi/v1/customerOpenApi/add', $data);
    }
}
