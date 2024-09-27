<?php

namespace Ledc\Pospal\Contracts;

use Ledc\Pospal\Traits\HasDataStruct;

/**
 * 银豹会员信息
 * @property int $customerUid
 * @property string $phone
 * @property string $number
 * @property string $name
 * @property string $password
 * @property float $balance
 * @property float $point
 * @property float $discount
 * @property string $address
 * @property string $remarks
 */
class MemberRocket
{
    use HasDataStruct;
}
