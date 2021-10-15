<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;


class CustomerController extends Controller
{
    //

   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addCustomer()
    {
        return view('layouts.add_customer');
    }




    public function storeCustomer(Request $request)
    {
  
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_address' => 'required',           
            'customer_phone' => 'required',
            'customer_email' => 'required',
        ]);

       if ($validator->fails()) 
       {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [];
        $data['customer_name'] = $request->customer_name;
        $data['customer_address'] = $request->customer_address;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;



        $customer = DB::table('customers')->insert($data);
        if($customer) {

           session()->flash('msg', 'Customer Added successfully');
            return redirect()->back();

        } else {

           session()->flash('msg', 'Customer insertion failed');
            return redirect()->back();
 
        } 
    }   

 

    public function showAllCustomer()
    {
        $data = [];
        // $data['customers'] = Customer::all();
        $data['customers'] = Customer::LeftJoin('orders', 'customers.id', '=', 'orders.customer_id')
        ->select(DB::raw('SUM(orders.total_amount) As order_amount'), 'customers.*')
        ->groupBy('customers.id')
        ->get();


        $data['payments'] = Customer::LeftJoin('payments', 'customers.id', '=', 'payments.payments_customer_id')
        ->select(DB::raw('SUM(payments.payment_amount) As total_payment_amount'), 'customers.*')
        ->groupBy('customers.id')
        ->get();

        // to copy total payment amount 
        for($i=0; $i<COUNT( $data['customers']); $i++){
            $data['customers'][$i]['total_payment_amount'] = $data['payments'][$i]['total_payment_amount'];
        }
        // dd($data['customers']);
        return view('layouts.all_customer', $data);
    }


    public function deleteSupplier($id)
    {
        $deleteSupplier = Supplier::where('id', $id)->delete();

        if ($deleteSupplier) {
            
            session()->flash('msg', 'Supplier deleted successfully');
            return redirect()->back();
        } else {
            session()->flash('msg', 'Supplier deletion failed');
            return redirect()->back();
        }
    }




    public function editSupplier($id)
    {
        $data = [];
        $data['supplier'] = Supplier::where('id', $id)->first();
        return view('layouts.edit_supplier',$data);
    }



    public function updateSupplier(Request $request, $id)
    {
  
        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required',
            'supplier_address' => 'required',           
            'supplier_contact_one' => 'required',
            'supplier_contact_two' => 'required',

        ]);

       if ($validator->fails()) 
       {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [];
        $data['supplier_name'] = $request->supplier_name;
        $data['supplier_address'] = $request->supplier_address;
        $data['supplier_contact_one'] = $request->supplier_contact_one;
        $data['supplier_contact_two'] = $request->supplier_contact_two;



        $supplier = DB::table('suppliers')->where('id', $id)->update($data);
        if($supplier) {

           session()->flash('msg', 'Supplier Update successfully');
            return redirect()->back();

        } else {

           session()->flash('msg', 'Supplier update failed');
            return redirect()->back();
 
        } 
    } 




    public function viewSupplier($supplier_name)
    {
        $data = [];
        $data['stocks'] = Stock::where('stock_supplier_name', $supplier_name)->get();
        return view('layouts.view_supplier',$data);
    }





    public function addPayment()
    {
        return view('layouts.add_customer_payment');
    }

    public function action(Request $request)
    {

    

        $customers = [];

        if($request->has('q')){
            $search = $request->q;
            $customers = Customer::select("id", "customer_name")
                      ->where('customer_name', 'LIKE', "%$search%")
                      ->orWhere('id', 'LIKE', "%$search%")
                      ->get();
        }
        return response()->json($customers);
    }

    public function  insertPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'payment_amount' => 'required|numeric'
        ]);


        if ($validator->fails()) 
       {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [];
        $data['payments_customer_id'] = $request->customer_id;
        $data['payment_amount'] = $request->payment_amount;


        $payment = DB::table('payments')->insert($data);
        if($payment) {

           session()->flash('msg', 'Your Payment is successful');
            return redirect()->back();

        } else {

           session()->flash('msg', 'Your Payment is failed');
            return redirect()->back();
 
        } 
    }




    public function customerPayment()
    {
        $data = [];
        $data['payments'] = Payment::LeftJoin('customers', 'payments.payments_customer_id', '=', 'customers.id')
                            ->select('customers.id', 'customers.customer_name', 'payments.*')
                            ->get();
        return view('layouts.all_payment',$data);
    }


}
