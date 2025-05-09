<?php

namespace App\Models\Backend;

use App\Models\Backend\Product\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'price',
        'discounted_price',
        'description',
        'main_image',
        'sub_images',
        'unit_name',
        'unit_id',
        'available_stock',
        'warning_amount',
        'status',
        'is_discounted',
        'is_featured',
    ];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        parent::deleting(function ($product){
            if (file_exists($product->main_image))
            {
                unlink($product->main_image);
            }
            if (isset($product->sub_images))
            {
                foreach (json_decode($product->sub_images) as $item)
                {
                    if (file_exists($item))
                    {
                        unlink($item);
                    }
                }
            }
        });
    }

    public static function createOrUpdateProduct($request, $productId = null)
    {
        return Product::updateOrCreate(['id' => $productId], [
            'category_id'    => $request->category_id,
            'product_name'  => $request->product_name,
            'price'  => $request->price ?? 0,
            'discounted_price'  => $request->discounted_price ?? 0,
            'description'  => $request->description ?? '',
            'main_image'  => imageUpload($request->file('main_image'), 'product', 'product-', 300, 400, isset($productId) ? Product::find($productId)->main_image : null),
            'sub_images'  => self::generateSubImagesLinks($request->file('sub_images'), isset($productId), $productId ?? null),
            'unit_name'  => $request->unit_name,
            'unit_id'  => $request->unit_id,
            'available_stock'  => $request->available_stock ?? 0,
            'warning_amount'  => $request->warning_amount ?? 0,
            'is_featured'  => $request->is_featured ?? 0,
            'is_discounted'  => $request->is_discounted ?? 0,
            'status' => $request->status == 'on' ? 1 : 0,
        ]);
    }

    public static function generateSubImagesLinks($imageObjects = [], $requestedForUpdate = false, $productId = null)
    {
        if ($requestedForUpdate)
        {
            if (isset($productId))
            {
                $existProduct = Product::find($productId);
                foreach (json_decode($existProduct->sub_images) as $item)
                {
                    if (file_exists($item))
                    {
                        unlink($item);
                    }
                }
            }
        }
        $finalImagesLinksArray = [];
        if (is_array($imageObjects) && count($imageObjects) > 0)
        {
            foreach ($imageObjects as $key => $imageObject)
            {
                $singleImageUrl = imageUpload($imageObject, 'product-sub-images', 'sub-image-', 300, 400);
                array_push($finalImagesLinksArray, $singleImageUrl);
            }
        }
        return json_encode($finalImagesLinksArray);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
