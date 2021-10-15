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
                                                            <th>Customer</th>
                                                            <th>Amount</th>
                                                            <th>Date & Time</th>
                                                        </tr>
                                                    </thead>

                                             
                                                    <tbody>
<?php $id=0; ?>
                                                    @foreach($payments as $payment) 
<?php $id++; ?>
                                                        <tr>
                                                            <td>{{$id}}</td>
                                                            <td>id: {{$payment->payments_customer_id }}  Name: {{$payment->customer_name }}</td>
                                                            <td>{{$payment->payment_amount}}</td>
                                                            <td>{{$payment->created_at->isoFormat('LLLL')}}</td>
                                                            
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