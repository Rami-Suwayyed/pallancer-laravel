<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'category_id', 'price', 'image', 'description', 'user_id'
    ];

    protected $appends = [
        'image_url'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->attributes['image']) {
            return asset('images/' . $this->attributes['image']);
        }
    }

    public function category()
    {
        return $this->belongsTo(
            Category::class, // realted model
            'category_id', // forigen key in products table for category
            'id' // id of categories table
        );
    }

    public function images()
    {
        return $this->hasMany(
            ProductImage::class,
            'product_id',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class, // realted model
            'user_id', // forigen key in products table for user
            'id' // id of users table
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'products_tags',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
    }

    public function comments()
    {
        return $this->morphMany(
            Comment::class,
            'commentable'
        );
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->using(OrderProduct::class)
            ->withPivot([
                'quantity', 'price'
            ]);
    }

    public function orderedProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public static function getBestSales($limit = 10)
    {
        /*
SELECT products.id, products.name,
(SELECT SUM(order_products.quantity) FROM order_products WHERE order_products.product_id = products.id) as sales
FROM products
ORDER BY sales DESC
LIMIT 3;
        */
        return Product::select([
            'id',
            'name',
            'price',
            'image',
            DB::raw('(SELECT SUM(order_products.quantity) FROM order_products WHERE order_products.product_id = products.id) as sales'),
        ])
        ->selectRaw('(SELECT categories.name FROM categories WHERE categories.id = products.category_id) as category_name')
        ->orderBy('sales', 'DESC')
        ->limit($limit)
        ->get();
    }

    public function scopeHighPrice($query, $min, $max = null)
    {
        $query->where('price', '>=', $min);
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    protected static function booted()
    {
        //parent::booted();

        /*static::addGlobalScope('ordered', function($query) {
            $query->has('orders');
        });*/

    }

}
