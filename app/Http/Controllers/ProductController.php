<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function productPage()
    {
        return view('pages.dashboard.product-page');
    }
    public function getall(Request $req)
    {
        $products = Product::where('user_id', '=', $req->header('id'))->get();
        if ($products) {
            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Product not found"
            ]);
        }
    }
    public function getItem(Request $req)
    {
        $product = Product::where(['user_id' => $req->header('id'), 'id' => $req->id])->get();
        if ($product) {
            return response()->json([
                'status' => 'success',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Product not found"
            ]);
        }
    }
    public function createProduct(Request $req)
    {
        $Img = $req->file('productImg');
        $imgPath = $req->header('id') . "_" . time() . "." . $Img->getClientOriginalExtension();
        $Img->move(public_path('uploads'), $imgPath);
        $product = Product::create([
            'productName' => $req->productName,
            'productPrice' => $req->productPrice,
            'productUnit' => $req->productUnit,
            'productImg' => $imgPath,
            'user_id' => $req->header('id'),
            'category_id' => $req->category_id,
        ]);

        if ($product) {
            return response()->json([
                'status' => 'success',
                'message' => "Product Create Successfully",
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Customer create faield"
            ]);
        }
    }
    public function updateProduct(Request $req)
    {
        $product = Product::where(['user_id' => $req->header('id'), 'id' => $req->id])->first();

        //if file is uploaded
        if ($req->hasFile('productImg')) {
            // delete old file
            $oldPath = public_path('uploads/' . $product->productImg);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            // create new img file path and move the img in public/uploads folder
            $Img = $req->file('productImg');
            $newPath = $req->header('id') . "_" . time() . "." . $Img->getClientOriginalExtension();
            $Img->move(public_path('uploads'), $newPath);

            // update the image in database
            $product->productImg = $newPath;
        }

        //update product details 
        $product->productName = $req->productName;
        $product->productPrice = $req->productPrice;
        $product->category_id = $req->category_id;
        $product->productUnit = $req->productUnit;

        if ($product->save()) {
            return response()->json([
                'status' => 'success',
                'message' => "Product Update Successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Product Update Failed"
            ]);
        }
    }
    public function deleteProduct(Request $req)
    {
        $product = Product::where([
            'user_id' => $req->header('id'),
            'id' => $req->id,
            'productImg' => $req->productImg
        ])->first();

        if ($product) {
            $path = public_path('uploads/' . $req->productImg);
            if (file_exists($path)) {
                unlink($path);
            }
            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => "Product Delete Successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Product Delete Failed"
            ]);
        }
    }
}
