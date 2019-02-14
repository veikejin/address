<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/15
 * Time: 9:47
 */
namespace Veikejin\Address;

use Modules\Base\Transformers\BaseTransformer;

class AddressTransformer extends BaseTransformer
{
    public function transform(AddressModel $address)
    {
        $area = $address->area;

        return [
            'id' => $address->id,
            'name' => $address->name,
            'mobile' => $address->mobile,
            'area' => $area->getArea(),
            'area_ids' => $area->getAreaIds(),
            'detail' => $address->detail,
            'is_default' => $address->is_default,
        ];
    }
}
