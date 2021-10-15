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
                                <h4 class="pull-left page-title">General elements</h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="#">Moltran</a></li>
                                    <li><a href="#">Forms</a></li>
                                    <li class="active">General elements</li>
                                </ol>
                            </div>
                        </div>


                        <div class="row">
                            
                            <!-- Horizontal form -->
                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">Cash Add Or Out</h3></div>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @if(session()->has('msg'))
                                        <div class="alert alert-success">
                                            {{ session()->get('msg') }}
                                        </div>
                                        @endif
                                    <div class="panel-body">
                                        <form action="{{ route('customer.add.payment')}}" method="post" class="form-horizontal" role="form">
                                            @csrf
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Customer Name</label>
                                                <div class="col-sm-9">
                                                 <select class="autosearch form-control" name="customer_id"></select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Payment Amount</label>
                                                <div class="col-sm-9">
                                                  <input type="number" name="payment_amount" class="form-control" id="inputEmail3" placeholder="Payment Amount">
                                                </div>
                                            </div>
                                            
                                            
                                           
                                            <div class="form-group m-b-0">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                  <button type="submit" class="btn btn-info waves-effect waves-light">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- panel-body -->
                                </div> <!-- panel -->
                            </div> <!-- col -->

                        </div> <!-- End row -->




                        

                    </div> <!-- container -->
                               
                </div> <!-- content -->

                

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

<script type="text/javascript">
    $('.autosearch').select2({
        placeholder: 'Select Customer',
        ajax: {
            url: '/customer-add-payment/action',
            dataType: 'json',
            delay: 220,
            processResults: function (data) {
                return {
                    results: $.map(data, function (data) {
                        var customerNameId = data.customer_name+" " + " ID: "+ data.id;
                        return {
                            text: customerNameId,
                            id: data.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>


@endsection


