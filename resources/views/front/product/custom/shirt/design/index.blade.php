@extends('front.layout')
@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area bg-grey">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Design</a></li>
                        <li class="breadcrumb-item active">Shirts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->
     <!-- content-wraper start -->
    <div class="content-wraper pb--70">
        <div class="mobile-container">
            <div class="mobile-content-cover">
                <div class="fabric-listing-title">2. SELECT DESIGN</div>
                <div class="instruction-content pt--30">
                    <p>Select from our shirt designs and continue to customize your shirt. </p>
                </div>
                <div id="product-design-list-cover" class="row">
                    @foreach($data['designs'] as $design)
                    <div class="col-12 col-md-3">
                        <div class="product-design-list-item">
                            <a href="{{$design->id}}" class="load-design-modal">
                                <div class="product-design-image"><img src="/images/product/design/{{$design->folder}}/{{$design->p_image}}" alt="Gold Class"></div>
                                <div class="product-design-name">{{$design->name}}</div>
                                <div class="product-design-description">{{$design->summary}}</div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    @include('front.modals.class-compare')
    @include('front.modals.load-design')
@endsection
@section('script')
    <script type="text/javascript">
        var fabric_id  = {!! json_encode($data['fabric']) !!};
    </script>
    <script type="text/javascript" src="/front/code/js/shirt/selectShirtDesign.js?version=<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
@endsection