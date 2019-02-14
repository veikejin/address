地址包
=====

安装
------

在composer.json require下添加
```$xslt
"veikejin/area":"dev-master"
```
在 repositories 键（如没有，请添加）下添加
```$xslt
{
    "type": "git",
    "url": "git@source.shengmage.com:smg/address.git",
    "reference":"master"
},
```
然后再在命令行下运行 `composer update` 更新即可


使用
---

在需要包含地址功能的 Model (如 User, Shop等)里面引入 `HaveAddress` Trait即可。下面以User为例

```$php

use SMG\Address\HaveAddress;

class User extends Model
{
    //引入地址Trait
    use HaveAddress;
    ...
}
```

获取一个用户登陆
```$php
$user = new User();
```

添加地址
```$php
$user->addresses()->create([
    'name'=>'test',
    'mobile'=>'15511111111',
    'area_id'=>'1966',//地区ID，具体参考smg/area模块地址的ID
    'detail' => '科苑北高新南一道中科大厦',
    'is_default' => 1,//默认地址，可空
    'label' => '公司', //地址标签，可空
    'postal_code'=>',//邮编，可空
    'lat'=>'113.959807',//地址径度，可空
    'lng'=>'22.543491',//地址维度，可空
    'other'=>'{"tel":"075512345678"}',//其它信息JSON字符串，可空
]);
//$user->addresses()->create($request->all());
```

获取用户的地址列表
```$xslt
$address_list = $user->addresses

//或者
$address_list = $user->addresses()->with('area')->get()
```

获取用户默认地址
```$xslt
$address = $user->address()
```

更新地址
```$xslt
$address = $user->addresses()->findOrFail($address);
$address->update(request()->except(['haveaddress_id', 'haveaddress_type', 'id']));
```

删除地址
```$xslt
$address = $user->addresses()->findOrFail($address);
$address->delete();
```


其他
---
本包附带用户地址增删改查API
请使用 `php artisan base:import_api_doc address`发布文档后查看API文档 