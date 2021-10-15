@extends('master')
@section('body-content')

 
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title">Datatable</h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="#">Moltran</a></li>
                                    <li><a href="#">Tables</a></li>
                                    <li class="active">Datatable</li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">All Cash</h3>
                                        @if(session()->has('msg'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('msg') }}
                                        </div>
                                        @endif

                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table id="datatable" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Customer Name</th>
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <th>Address</th>
                                                            <th>Due</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                             
                                                    <tbody>
<?php $id=0; ?>
                                                    @foreach($customers as $customer)   
<?php $id++; 


?>
                                                        <tr>
                                                            <td>{{$id}}</td>
                                                            <td>{{$customer->customer_name}}</td>
                                                            <td>{{$customer->customer_phone}}</td>
                                                            <td>{{$customer->customer_email}}</td>
                                                            <td>{{$customer->customer_address}}</td>
                                                            <td>{{$customer->order_amount - $customer->total_payment_amount}}</td>
                                                             <td>
                                                                <a href="{{ route('edit.customer', $customer->id)}}" class="btn btn-sm btn-info">Edit</a>
                                                                <a href="{{ route('view.customer', $customer->id)}}" class="btn btn-sm btn-info">View</a>
                                                                <a href="{{ route('delete.customer', $customer->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger" id="delete">Delete</a>
                                                            </td>
                                                        </tr>
                                                     @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div> <!-- End Row -->


                    </div> <!-- container -->
                               
                </div> <!-- content -->

               

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

@endsection