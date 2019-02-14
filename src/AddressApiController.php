<?php

namespace Veikejin\Address;

use \Illuminate\Http\Request;

class AddressApiController extends \Modules\Base\Http\Controllers\Api\ApiController
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        //$list = $this->user->addresses;
        $list = $this->user->addresses()->with('area')->get();

        return $this->response->collection($list, new AddressTransformer());
    }

    /**
     * 返回用户默认地址
     *
     * @return \Dingo\Api\Http\Response
     */
    public function address()
    {
        $address = $this->user->addresses()->isDefault()->first();

        return $this->response->item($address, new AddressTransformer());
    }

    public function show(AddressModel $address){

        return $this->response->item($address, new AddressTransformer());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = $this->user->addresses()->create($request->all());

        return $this->response->item($address, new AddressTransformer())
            ->setStatusCode(201);
    }

    /**
     * @param Request $request
     * @param $address
     *
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $address)
    {
        $address = $this->user->addresses()->findOrFail($address);

        $address->update($request->except(['haveaddress_id', 'haveaddress_type', 'id']));

        return $this->response->item($address, new AddressTransformer());
    }

    /**
     * 删除用户地址
     *
     * @param $address
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($address)
    {
        $address = $this->user->addresses()->findOrFail($address);

        $address->delete();

        return $this->response->noContent();
    }
}
