<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function categoryPage()
    {
        return view("pages.dashboard.category-page");
    }

    public function getall(Request $req)
    {
        $userid = $req->header('id');
        $allCategory = Category::where('user_id', '=', $userid)->get();
        if (!empty($allCategory) && count($allCategory) > 0) {
            return response()->json([
                'status' => 'success',
                'category' => $allCategory
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "category not found"
            ]);
        }
    }

    public function getItem(Request $req)
    {
        $item =  Category::where("id", "=", $req->id)->where('user_id', '=', $req->header('id'))->first();
        if ($item) {
            return response()->json([
                "status" => 'success',
                "category" => $item
            ], 200);
        } else {
            return response()->json([
                "status" => 'failed',
                "message" => "item not found"
            ]);
        }
    }

    public function categoryCreate(Request $req)
    {
        $create = Category::create([
            'category_name' => $req->category_name,
            'user_id' => $req->header('id')
        ]);

        if ($create) {
            return response()->json([
                'status' => 'success',
                'message' => "category Create Successfully",
                'category' => $create
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "category create faield"
            ]);
        }
    }
    public function categoryUpdate(Request $req)
    {
        $update =  Category::where(['user_id' => $req->header('id'), "id" => $req->id])->update(['category_name' => $req->category_name]);
        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => "Category Update Successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Category Update Failed"
            ]);
        }
    }
    public function CategoryDelete(Request $req)
    {
        $delete = Category::where(['user_id' => $req->header('id'), "id" => $req->id])->delete();
        if ($delete) {
            return response()->json([
                'status' => 'success',
                'message' => "Category Delete Successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Category Delete Failed"
            ]);
        }
    }
}
