<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/4
 * Time: 16:31
 */
namespace Veikejin\Address;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HaveAddress
{
    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function deleted($callback);

    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $type
     * @param string $id
     * @param string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Boot the addressable trait for the model.
     *
     * @return void
     */
    public static function bootHaveAddress()
    {
        static::deleted(function (self $model) {
            $model->addresses()->delete();
        });
    }

    /**
     * Get all attached addresses to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany('SMG\Address\AddressModel', 'haveaddress');
    }

    /**
     * Get default addresses to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address(): MorphOne
    {
        $relation = $this->morphOne('SMG\Address\AddressModel', 'haveaddress');
        $relation->isDefault();

        return $relation;
    }

    /**
     * 复制地址
     *
     * @param $id
     * @param array $merge
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function copyAddressFromId($id, $merge = ['is_default' => 1])
    {
        $address = AddressModel::find($id);
        throw_unless($address, '\Exception', '地址不存在');
        $data = array_except($address->toArray(), ['haveaddress_type', 'haveaddress_id', 'created_at', 'updated_at']);
        $data = array_merge($data, $merge);

        return $this->addresses()->create($data);
    }
}
