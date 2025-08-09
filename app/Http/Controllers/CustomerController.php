<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerPage()
    {
        return view("pages.dashboard.customer-page");
    }

    public function getall(Request $req)
    {
        $userid = $req->header('id');
        $allCustomer = Customer::where('user_id', '=', $userid)->get();
        if (!empty($allCustomer) && count($allCustomer) > 0) {
            return response()->json([
                'status' => 'success',
                'customer' => $allCustomer
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Customer not found"
            ]);
        }
    }

    public function getItem(Request $req)
    {
        $item =  Customer::where("id", "=", $req->id)->where('user_id', '=', $req->header('id'))->first();
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

    public function customerCreate(Request $req)
    {
        $create = Customer::create([
            'customerName' => $req->customerName,
            'customerEmail' => $req->customerEmail,
            'customerMobile' => $req->customerMobile,
            'user_id' => $req->header('id')
        ]);

        if ($create) {
            return response()->json([
                'status' => 'success',
                'message' => "Customer Create Successfully",
                'Customer' => $create
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Customer create faield"
            ]);
        }
    }
    public function customerUpdate(Request $req)
    {
        $update =  Customer::where(['user_id' => $req->header('id'), "id" => $req->id])
            ->update([
                'customerName' => $req->customerName,
                'customerEmail' => $req->customerEmail,
                'customerMobile' => $req->customerMobile,
            ]);
        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => "Customer Update Successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Customer Update Failed"
            ]);
        }
    }
    public function customerdelete(Request $req)
    {
        $delete = Customer::where(['user_id' => $req->header('id'), "id" => $req->id])->delete();
        if ($delete) {
            return response()->json([
                'status' => 'success',
                'message' => "Customer Delete Successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Customer Delete Failed"
            ]);
        }
    }
}
