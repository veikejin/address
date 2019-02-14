<?php

namespace Veikejin\Address;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Veikejin\Support\Validating\ValidatingTrait;

class AddressModel extends Model
{
    use ValidatingTrait;

    protected $table = 'address';
    protected $hidden = ['haveaddress_type', 'haveaddress_id'];

    protected $fillable = [
        'haveaddress_id',
        'haveaddress_type',
        'label',
        'name',
        'mobile',
        'area_id',
        'detail',
        'is_default',
        'postal_code',
        'lat',
        'lng',
        'other',
    ];

    /*
    **
    * {@inheritdoc}
    */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'haveaddress_id' => 'required|integer',
        'haveaddress_type' => 'required|string|max:150',
        'label' => 'nullable|string|max:150',
        'name' => 'string|max:150',
        'mobile' => 'string|max:20',
        'area_id' => 'required|integer|exists:area,id',
        'detail' => 'required|string|max:250',
        'is_default' => 'nullable|integer|boolean',
        'other' => 'nullable|json',
        'lat' => 'nullable|numeric',
        'lng' => 'nullable|numeric',
    ];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Get the owner model of the address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function haveaddress(): MorphTo
    {
        return $this->morphTo();
    }

    public function area()
    {
        return $this->belongsTo('SMG\Area\AreaModel');
    }

    /**
     * Scope primary addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsDefault(Builder $builder): Builder
    {
        return $builder->where('is_default', 1);
    }

    /**
     * 当前地址是否属于某个对象
     *
     * @param Model $model
     *
     * @return boolean
     */
    public function isBelongsTo(Model $model)
    {
        return $this->haveaddress_type == get_class($model) && $this->haveaddress_id == $model->id;
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function (self $address) {
            if (false) {
                //根据地址用百度API获取经纬度
            }
        });

        static::saved(function (self &$address) {
            if ($address->is_default) {
                static::where('haveaddress_id', $address->haveaddress_id)
                    ->where('haveaddress_type', $address->haveaddress_type)
                    ->where('id', '<>', $address->id)
                    ->update(['is_default' => 0]);
            } else {
                $count = static::where('haveaddress_id', $address->haveaddress_id)
                    ->where('haveaddress_type', $address->haveaddress_type)
                    ->where('is_default', 1)
                    ->count();
                if ($count < 1) {
                    static::where('haveaddress_id', $address->haveaddress_id)
                        ->where('haveaddress_type', $address->haveaddress_type)
                        ->where('id', $address->id)
                        ->update(['is_default' => 1]);
                    $address->is_default = 1;
                }
            }
        });

        static::deleting(function (self $address) {
            if (static::where('haveaddress_id', $address->haveaddress_id)
                    ->where('haveaddress_type', $address->haveaddress_type)->count() < 2) {
                abort(500, '请至少保留一个收货地址');
            }
        });

        static::deleted(function (self $address) {
            if ($address->is_default) {
                static::where('haveaddress_id', $address->haveaddress_id)
                    ->where('haveaddress_type', $address->haveaddress_type)
                    ->limit(1)
                    ->update(['is_default' => 1]);
            }
        });
    }
}
