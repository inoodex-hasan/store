<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    private static $category, $image, $imageName, $directory, $imageUrl;

    protected $fillable = [
        'category_name',
        'category_image',
    ];


    public static function getImageUrl($request)
    {
        self::$image = $request->file('category_image');
        self::$imageName = self::$image->getClientOriginalName();
        self::$directory = 'upload/category-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory . self::$imageName;
        return self::$imageUrl;
    }


    public static function newCategory($request)
    {
        self::$category = new Category();

        self::$category->category_name = $request->category_name;
        self::$category->category_image = $request->hasFile('category_image')
            ? self::getImageUrl($request)
            : null;

        self::$category->save();
    }


    public static function updateCategory($request, $id)
    {
        self::$category = Category::find($id);

        if ($request->hasFile('category_image')) {
            if (file_exists(self::$category->category_image)) {
                unlink(self::$category->category_image);
            }
            self::$imageUrl = self::getImageUrl($request);
        } else {
            self::$imageUrl = self::$category->category_image;
        }

        self::$category->category_name = $request->category_name;
        self::$category->category_image = self::$imageUrl;
        self::$category->save();
    }


    public static function deleteCategory($id)
    {
        self::$category = Category::find($id);

        if (self::$category && file_exists(self::$category->category_image)) {
            unlink(self::$category->category_image);
        }

        if (self::$category) {
            self::$category->delete();
        }
    }



    public function products()
    {
        return $this->hasMany(Product::class);
    }



}