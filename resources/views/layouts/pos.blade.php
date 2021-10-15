@extends('master')

@section('body-content')
 

 <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container">
                        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12 bg-info">
            <h4 class="pull-left page-title text-white">POS (Point Of Sale ) </h4>
            <ol class="breadcrumb pull-right">
               <li><a class="text-white" href="#">Moltran</a></li>
               <li class="text-white">{{date('d/m/y')}}</li>
            </ol>
          </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="price_card text-center">
                    @if(session()->has('msg'))
                    <div class="alert alert-success">
                        {{ session()->get('msg') }}
                    </div>
                    @endif
                    <ul class="price-features" style="border 1px solid grey;">
                        <table class="table">
                            <thead>
                                @php
                                $cartProducts = Cart::content()
                                @endphp
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Act</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cartProducts as $cartProduct)
                                <tr>
                                    <th>{{ $cartProduct->name}}</th>
                                    <th>
                                        <form action="{{ route('update.cart', $cartProduct->rowId)}}" method="post">
                                            @csrf
                                        <input type="number" name="qty" style="width: 40px;" value="{{ $cartProduct->qty}}">
                                        <button type="submit" style="margin-top: -2px;" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                        </form> 
                                    </th>
                                    <th>{{ $cartProduct->price}}</th>
                                    <th>{{ $cartProduct->price * $cartProduct->qty}}</th>
                                    <th><a href="{{ route('remove.cart', $cartProduct->rowId)}}"><i style="color: red;" class="fas fa-trash"></i></a></th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </ul>

                    <div class="pricing-footer" style="margin-top: 150px;">
                        <table class="table">

                            <tbody>
                               
                                <tr>
                                    <th>Total Quantity: </th>
                                    <th>{{Cart::count()}}</th>
                                </tr>
                                <tr>
                                    <th>Vat: </th>
                                    <th>0 %</th>
                                </tr>
                                <tr>
                                    <th>Total: </th>
                                    <th>{{Cart::subtotal()}}</th>
                                </tr>
                            </tbody>
                        </table>
                        
                        

                        <form action="{{ route('create.sale')}}" method="post">
                        @csrf
                    </div>
                    <button type="submit" class="btn btn-success"> Submit </button>
                    
                  </div>
              </div>
            </form>
            <div class="col-lg-7">
                  <div class="content">;
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title">Products</h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="#">Moltran</a></li>
                                    <li><a href="#">Components</a></li>
                                    <li class="active">Gallery</li>
                                </ol>
                            </div>
                        </div>

                        <!-- SECTION FILTER
                        ================================================== -->  
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 ">
                                <div class="portfolioFilter">
                                    <a href="#" data-filter="*" class="current">All</a>
                                    <a href="#" data-filter=".webdesign">Web Design</a>
                                    <a href="#" data-filter=".graphicdesign">Graphic Design</a>
                                    <a href="#" data-filter=".illustrator">Illustrator</a>
                                    <a href="#" data-filter=".photography">Photography</a>
                                </div>
                            </div>
                        </div>

                        <div class="row port">
                            <div class="portfolioContainer">

     <?php $id=0; ?>
                    @foreach($products as $product)  
    <?php $id++; ?>
                                <form action="{{ route('add.cart')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id}}">
                                <input type="hidden" name="name" value="{{ $product->product_name}}">
                                <input type="hidden" name="qty" value="1">
                                <input type="hidden" name="price" value="{{ $product->product_price}}">
                                <div class="col-sm-6 col-lg-3 col-md-4 webdesign illustrator">
                                    <div class="gal-detail thumb">
                                        <button type="submit">
                                        <a href="" class="image-popup" title="{{$product->product_name}}">
                                            <img src="{{ asset('product_image/'.$product->product_image) }}" class="thumb-img" alt="{{$product->product_name}}">
                                        </a>
                                        </button>
                                        <h6>{{ $product->product_name}}</h6>
                                        <h6>Price: {{ $product->product_price}}</h6>
                                        
                                    </div>
                                </div>
                    @endforeach

                            </div>
                        </div> <!-- End row -->

                    </div> 
                               
                </div> 
            </div>











            
        </div>


        
      </div> <!-- container -->                              
    </div> <!-- content -->

   @include('partials.__footer')
 </div>
 <script src="https://kit.fontawesome.com/f1cdd46680.js" crossorigin="anonymous"></script>

@endsection
