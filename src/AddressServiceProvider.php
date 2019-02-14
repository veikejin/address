<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 10:29
 */
namespace Veikejin\Address;

use Illuminate\Support\ServiceProvider;

class AddressServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
        static::registerRoutes();

        //$this->addMacro();
    }

    /**
     * Register routes for laravel-admin.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        $api = app('Dingo\Api\Routing\Router');

        $api->version(
            'v1',
            array_merge(
                [
                    'prefix' => 'api/package',
                ],
                config('api.defaultSetting', [])
            ),
            function ($api) {
                // 需要 token 验证的接口
                $api->group(['middleware' => 'api.auth'], function ($api) {
                    $api->resource('/user/addresses', '\SMG\Address\AddressApiController');
                    $api->get('/user/address', '\SMG\Address\AddressApiController@address')
                        ->name('api.package.user.address');
                });
            }
        );
    }

    public function addMacro()
    {
        $userClass = get_user_model();
        //我的地址列表
        $userClass::macro('addresses', function () {
            return $this->morphMany('SMG\Address\AddressModel', 'haveaddress');
        });

        //我的默认地址
        $userClass::macro('address', function () {
            $relation = $this->morphOne('SMG\Address\AddressModel', 'haveaddress');
            $relation->isDefault();

            return $relation;
        });

        $userTransformer = get_user_transformer();
        $userTransformer::addIncludes(['addresses', 'address']);
        //我的地址
        $userTransformer::macro('includeAddresses', function ($user) {
            return $this->collection($user->addresses, new AddressTransformer());
        });

        $userTransformer::macro('includeAddress', function ($user) {
            return $this->item($user->address, new AddressTransformer());
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        //
    }
}
