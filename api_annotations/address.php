<?php

/**
 *
 * @OA\Get(
 *     tags={"收货地址"},
 *     summary="用户地址列表",
 *     path="/api/package/user/addresses",
 *     security={
 *         {"jwt_auth": {}}
 *     },
 *     @OA\Response(
 *          response="200",
 *          description="成功",
 *          @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(
 *                  type="object",
 *                  @OA\Property(
 *                      property="data",
 *                      type="array",
 *                      @OA\Items(ref="#/components/schemas/Address"),
 *                      description="列表"
 *                  ),
 *              )
 *          )
 *      )
 * )
 */

/**
 *
 * @OA\Get(
 *     tags={"收货地址"},
 *     summary="用户默认地址",
 *     path="/api/package/user/address",
 *     security={
 *         {"jwt_auth": {}}
 *     },
 *     @OA\Response(
 *          response="200",
 *          description="成功",
 *          @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(type="object",
 *                  @OA\Property(property="data", type="object", ref="#/components/schemas/Address")
 *              )
 *          )
 *      )
 * )
 */

/**
 * @OA\Get(
 *     tags={"收货地址"},
 *     summary="用户地址详情",
 *     path="/api/package/user/addresses/{address_id}",
 *     security={
 *         {"jwt_auth": {}}
 *     },
 *     @OA\Parameter(
 *         name="address_id",
 *         in="path",
 *         description="地址ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="成功",
 *          @OA\MediaType(
 *             mediaType="application/json",
 *              @OA\Schema(type="object",
 *                  @OA\Property(property="data", type="object", ref="#/components/schemas/Address")
 *              )
 *          )
 *      )
 * )
 */

/**
* @OA\Post(
 *     tags={"收货地址"},
 *     summary="用户创建地址",
 *     path="/api/package/user/addresses",
 *     security={
 *         {"jwt_auth": {}}
 *     },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"type","file"},
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
*                 ),
 *                @OA\Property(
 *                     property="mobile",
 *                     ref="#/components/schemas/phone"
 *                 ),
 *                @OA\Property(
 *                     property="area_id",
 *                     type="integer",
 *                 ),
 *                @OA\Property(
 *                     property="detail",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="is_default",
 *                     type="integer",
 *                     enum={0,1}
 *                 ),
 *                 @OA\Property(
 *                     property="other",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="lat",
 *                     type="number",
 *                 ),
 *                 @OA\Property(
 *                     property="lng",
 *                     type="number",
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="201",
 *          description="成功",
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(type="object",
 *                  @OA\Property(property="data", type="object", ref="#/components/schemas/Address")
*              )
 *          )
 *      )
 * )
 */

/**
 * @OA\Put(
 *     tags={"收货地址"},
 *     summary="更新地址",
 *     path="/api/package/user/addresses/{address_id}",
 *     security={
 *         {"jwt_auth": {}}
 *     },
 *     @OA\Parameter(
 *         name="address_id",
 *         in="path",
 *         description="地址ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"type","file"},
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                 ),
 *                @OA\Property(
 *                     property="mobile",
 *                     ref="#/components/schemas/phone"
 *                 ),
 *                @OA\Property(
 *                     property="area_id",
 *                     type="integer",
 *                 ),
 *                @OA\Property(
 *                     property="detail",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="is_default",
 *                     type="integer",
 *                     enum={0,1}
 *                 ),
 *                 @OA\Property(
 *                     property="other",
 *                     type="string",
 *                 ),
 *                 @OA\Property(
 *                     property="lat",
 *                     type="number",
 *                 ),
 *                 @OA\Property(
 *                     property="lng",
 *                     type="number",
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="成功",
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(type="object",
 *                  @OA\Property(property="data", type="object", ref="#/components/schemas/Address")
 *              )
 *          )
 *      )
 * )
 */


/**
 * @OA\Delete(
 *     tags={"收货地址"},
 *     summary="用户删除地址",
 *     path="/api/package/user/addresses/{address_id}",
 *     security={
 *         {"jwt_auth": {}}
 *     },
 *     @OA\Parameter(
 *         name="address_id",
 *         in="path",
 *         description="地址ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="成功"
 *      )
 * )
 */

/**
 *
 * @OA\Schema(
 *     description="地址信息",
 *     type="object",
 *     schema="Address",
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="name", type="string", description="姓名"),
 *     @OA\Property(property="mobile", type="string", description="电话"),
 *     @OA\Property(property="area", type="string", description="地区"),
 *     @OA\Property(property="area_ids", type="string", description="地区ID列表"),
 *     @OA\Property(property="detail", type="string", description="地址详情"),
 *     @OA\Property(property="is_default", type="string", description="是否是默认地址"),
 * )
 */