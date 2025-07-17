<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 * schema="Product",
 * title="Product",
 * description="Product model",
 * @OA\Property(
 * property="id",
 * type="integer",
 * format="int64",
 * description="ID of the product",
 * readOnly=true
 * ),
 * @OA\Property(
 * property="name",
 * type="string",
 * description="Name of the product",
 * example="Laptop"
 * ),
 * @OA\Property(
 * property="description",
 * type="string",
 * description="Description of the product",
 * nullable=true,
 * example="Powerful laptop for gaming and work"
 * ),
 * @OA\Property(
 * property="price",
 * type="number",
 * format="float",
 * description="Price of the product",
 * example="1200.00"
 * ),
 * @OA\Property(
 * property="created_at",
 * type="string",
 * format="date-time",
 * description="Timestamp when the product was created",
 * readOnly=true
 * ),
 * @OA\Property(
 * property="updated_at",
 * type="string",
 * format="date-time",
 * description="Timestamp when the product was last updated",
 * readOnly=true
 * )
 * )
 *
 * @OA\Schema(
 * schema="ProductRequest",
 * title="Product Request",
 * description="Product request body for create/update",
 * required={"name", "price"},
 * @OA\Property(
 * property="name",
 * type="string",
 * description="Name of the product",
 * example="Smartphone"
 * ),
 * @OA\Property(
 * property="description",
 * type="string",
 * description="Description of the product",
 * nullable=true,
 * example="Latest model with advanced features"
 * ),
 * @OA\Property(
 * property="price",
 * type="number",
 * format="float",
 * description="Price of the product",
 * example="799.99"
 * )
 * )
 */

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
