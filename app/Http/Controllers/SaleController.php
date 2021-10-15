<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use DB;


class SaleController extends Controller
{
    //

     protected $order, $sale;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function addSale()
    {

        $data = [];
        $data['customers'] = Customer::all();
        $data['products'] = Product::all();
        return view('layouts.add_sale', $data);
    }

    public function searchAddSaleProduct(Request $request)
    {

        $products = [];

        if($request->has('q')){
            $search = $request->q;
            $products = Product::select("id", "product_name")
                      ->where('product_name', 'LIKE', "%$search%")
                      ->get();
        }
        return response()->json($products);
    } 




    public function storeSale(Request $request)
    {
        // return $request->all();
  
        $validator = Validator::make($request->all(), [
            'customer_id' =>  'required',
            'product_id' => 'required',
            'sale_price' => 'required',
            'sale_quantity' => 'required',

        ]);

       if ($validator->fails()) 
       {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $order = [];
        $data = [];
        $invoice = (time());
        $total_amount =0;
        for ($i = 0; $i < count($request->product_id); $i++) 
        {
            
            $total_amount = $total_amount + ($request->sale_quantity[$i] * $request->sale_price[$i]); 

            $data[] = [
                        'product_id' => $request->product_id[$i],
                        'sale_invoice_id' => $invoice,
                        'sale_price' => $request->sale_price[$i],
                        'sale_quantity' => $request->sale_quantity[$i],
                        'sale_payment' => $total_amount
                      ];
        }
        
         $paymentsAmount[] = [
            'payments_customer_id' => $request->customer_id,
            'payment_amount' => empty($request->payments) ? 0 : $request->payments,
        ];
       
        $order[] = [
            'customer_id' => $request->customer_id,
            'order_invoice_id' => $invoice,
            'total_amount' => $total_amount
        ];
       
        $orderInsert = DB::table('orders')->insert($order);
        $sale = DB::table('sales')->insert($data);
        $payments = DB::table('payments')->insert($paymentsAmount);
        if($sale & $orderInsert & $payments) {

           session()->flash('msg', 'Sale Purchase successfully');
            return redirect()->back();

        } else {

           session()->flash('msg', 'Sale Purchase failed');
            return redirect()->back();
 
        }
    }


    public function showAllSale()
    {
        $data = [];
        $data['orders'] = Order::join('customers', 'orders.customer_id', '=', 'customers.id')
            ->LeftJoin('payments', 'customers.id', '=', 'payments.payments_customer_id')
             ->select('orders.*', 'customers.customer_name', 'payment_amount')->get();
        
        return view('layouts.all_sale', $data);
    }


    public function deleteSale($id)
    {
        $deleteSale = Sale::where('id', $id)->delete();

        if ($deleteSale) {
            
            session()->flash('msg', 'Sale deleted successfully');
            return redirect()->back();
        } else {
            session()->flash('msg', 'Sale deletion failed');
            return redirect()->back();
        }
    }



    public function editSale($id)
    {
        $data = [];
        $data['products'] = Product::all();
        $data['sale'] = Sale::where('id', $id)->first();
        return view('layouts.edit_sale',$data);
    }




    public function updateSale(Request $request, $id)
    {
  
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'sale_price' => 'required|numeric',
            'sale_quantity' => 'required',
            'sale_payment' => 'required',

        ]);

       if ($validator->fails()) 
       {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [];
        $data['product_id'] = $request->product_id;
        $data['sale_price'] = $request->sale_price;
        $data['sale_quantity'] = $request->sale_quantity;
        $data['sale_payment'] = $request->sale_payment;
        $data['sale_desc'] = $request->sale_desc;


        $stock = DB::table('sales')->where('id', $id)->update($data);
        if($stock) {

           session()->flash('msg', 'Sale Purchase Update successfully');
            return redirect()->back();

        } else {

           session()->flash('msg', 'Sale Purchase Update failed');
            return redirect()->back();
 
        } 
    }





}
