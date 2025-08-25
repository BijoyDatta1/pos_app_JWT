<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function summary(Request $req)
    {
        $product = Product::where('user_id', $req->header('id'))->count();
        $category = Category::where('user_id', $req->header('id'))->count();
        $customer = Customer::where('user_id', $req->header('id'))->count();
        $invoice = Invoice::where('user_id', $req->header('id'))->count();

        $totalSale = Invoice::where('user_id', $req->header('id'))->sum('total');
        $vat = Invoice::where('user_id', $req->header('id'))->sum('vat');
        $collection = Invoice::where('user_id', $req->header('id'))->sum('payable');
        $discount = Invoice::where('user_id', $req->header('id'))->sum('discount');

        return response()->json([
            'product' => $product,
            'category' => $category,
            'customer' => $customer,
            'invoice' => $invoice,
            'total_sale' => $totalSale,
            'vat' => $vat,
            'collection' => $collection,
            'discount' => $discount
        ]);
    }
};
