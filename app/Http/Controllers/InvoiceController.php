<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    //
    public function invoicePage()
    {
        return view('pages.dashboard.invoice-page');
    }

    public function salePage()
    {
        return view('pages.dashboard.sale-page');
    }
    public function createInvoice(Request $req)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'user_id' => $req->header('id'),
                'customer_id' => $req->customer_id,
                'total' => $req->total,
                'payable' => $req->payable,
                'vat' => $req->vat,
                'discount' => $req->discount
            ]);
            $invoice_id = $invoice->id;
            $products = $req->product; // {"productId" : productId,"productName" : productName,"productPrice":productPrice,"ProductQnt":ProductQnt,"ProductTotalPrice":ProductTotalPrice}
            foreach ($products as $eachProduct) {
                InvoiceProduct::create([
                    "invoice_id" => $invoice_id,
                    "user_id" => $req->header('id'),
                    "product_id" => $eachProduct["productId"],
                    "qty" => $eachProduct["ProductQnt"],
                    "sale_price" => $eachProduct["ProductTotalPrice"]

                ]);
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => " Invoice Created Successfully",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => " Invoice Creation Faield",
            ]);
        }
    }

    public function deleteInvoice(Request $req)
    {
        DB::beginTransaction();
        try {
            InvoiceProduct::where('user_id', $req->header('id'))->where('invoice_id', $req->invoice_id)->delete();
            Invoice::where('user_id', $req->header('id'))->where('id', $req->invoice_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => " Invoice Delete Successfully",
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'faield',
                'message' => " Invoice Delete Failed",
            ]);
        }
    }
}
