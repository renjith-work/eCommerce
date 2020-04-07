@extends('admin.layout')
@section('header')
    <link rel="stylesheet" type="text/css" href="/cmadmin/parsley/parsley.css">
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=olg2smjmsqjy5ogdk1zogy9sj5qginfm4e5ozpvxrm5ecfek"></script>
    <link rel="stylesheet" href="/cmadmin/bower_components/select2/dist/css/select2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/product">Product Management</a></li>
            <li class="active">Create Product</li>
        </ol>
    </section>
    <section class="content">
        <div class="admin-footer-error">@include('admin.partials.flashErrorMessage')</div>
        <div class="global-settings-cover">
            <form action="{{route('admin.product.store')}}" id="product_create" method="POST" enctype="multipart/form-data" data-parsley-validate >
                {{ csrf_field() }}
                <div class="row user">
                    <div class="col-md-3">
                        <div class="tile p-0 gb-settings-body" style="background: #fff;">
                            <ul class="nav nav-stacked gb-nav">
                                <li class="nav-item active" id="liMain"><a class="nav-link active" href="#mainPane" id="mainTab" data-toggle="tab">MAIN CONTENT</a></li>
                                <li class="nav-item" id="liAttr"><a class="nav-link active" href="#attrPane" id="attrTab" data-toggle="tab">ATTRIBUTES</a></li>
                                <li class="nav-item" id="liImage"><a class="nav-link active" href="#imagePane" id="imageTab" data-toggle="tab">MEDIA CONTENT</a></li>
                                <li class="nav-item" id="liSeo"><a class="nav-link" href="#seoPane" id="seoTab" data-toggle="tab">SEO CONTENT</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="mainPane">
                                <div class="box-header">
                                    <h3 class="box-title">Create Product</h3>
                                </div>
                                <div class="gb-body">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" maxlength="255" value="{{ old('name') }}">
                                        @error('name') <p class="error-p">{{$errors->first('name')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <div class="form-instruction">You may leave this blank if the product doesn't have any brand.</div>
                                        <select id="brand" class="form-control custom-select mt-15 @error('brand') is-invalid @enderror" name="brand">
                                            <option disabled selected>Select a brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}"> {{ $brand->name }} </option>                                            
                                            @endforeach
                                        </select>
                                        @error('brand') <p class="error-p">{{$errors->first('brand')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Product Category</label>
                                        <select id="category" class="form-control custom-select mt-15 @error('category') is-invalid @enderror" name="category">
                                            <option disabled selected>Select a category</option>
                                            @foreach($categories as $category)
                                                @if($category->id != 1)
                                                    <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('category') <p class="error-p">{{$errors->first('category')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="po_tyoe">Product Purchase Type</label>
                                        <div class="row">
                                            @foreach ($po_types as $po_type)
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <input type="checkbox" name="po_type[]" value="{{ $po_type->id }}">
                                                        <label>{{ ucfirst($po_type->name) }}</label>
                                                        <br>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        @error('po_type') <p class="error-p">{{$errors->first('po_type')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <div class="form-instruction">Use the editor to write the description of the product.</div>
                                        <textarea name="description" id="description" class="form-control wysiwyg @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                                        @error('description') <p class="error-p">{{$errors->first('description')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="summary">Product Summary</label>
                                        <textarea name="summary" id="summary" class="form-control @error('summary') is-invalid @enderror" rows="5">{{ old('summary') }}</textarea>
                                        @error('summary') <p class="error-p">{{$errors->first('summary')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="featured">Featured</label>
                                        <div class="form-instruction">Do you want the category to be a featued.</div>
                                        <select id="featured" class="form-control custom-select mt-15 @error('featured') is-invalid @enderror" name="featured">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error('featured') <p class="error-p">{{$errors->first('featured')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="menu">Menu</label>
                                        <div class="form-instruction">Do you want the category to be listed in the menu.</div>
                                        <select id="menu" class="form-control custom-select mt-15 @error('menu') is-invalid @enderror" name="menu">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error('menu') <p class="error-p">{{$errors->first('menu')}}</p> @enderror
                                    </div>
                                    
                                </div>
                                <div class="tile-footer">
                                    <div class="row d-print-none mt-2">
                                        <div class="col-md-12 text-right">
                                            <a class="btn btn-success" href="#" id="section1N"><i class="fa fa-fw fa-lg fa-arrow-circle-right"></i> &nbsp;Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="attrPane">
                                <div class="box-header">
                                    <h3 class="box-title">PRODUCT ATTRIBUTES</h3>
                                </div>
                                <div class="gb-body">
                                    <div class="section-sub-title">Product Attributes</div>
                                    <div id="prd-attr-cover">
                                        <div class="admin-blank-section">
                                            Please select a product category to load the product attributes.
                                        </div>
                                    </div>
                                    <div class="section-sub-title">Product Price</div>
                                    <div class="form-group">
                                        <label for="price">Product Price</label>
                                        <div class="form-instruction">Enter your product price here.</div>
                                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" maxlength="255" value="{{ old('price') }}">
                                        @error('price') <p class="error-p">{{$errors->first('price')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="og_price">Product Original Price</label>
                                        <div class="form-instruction">If you want to provide the product at an reduced price, enter the original price here and promotional price in the above price coloumn.</div>
                                        <input type="number" name="og_price" class="form-control @error('og_price') is-invalid @enderror" id="og_price" maxlength="255" value="{{ old('og_price') }}">
                                        @error('og_price') <p class="error-p">{{$errors->first('og_price')}}</p> @enderror
                                    </div>
                                </div>

                                <div class="tile-footer">
                                    <div class="row d-print-none mt-2">
                                        <div class="col-md-6 text-left">
                                            <a class="btn btn-success" href="#" id="section2P"><i class="fa fa-fw fa-lg fa-arrow-circle-left"></i> &nbsp;Previous</a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a class="btn btn-success" href="#" id="section2N"><i class="fa fa-fw fa-lg fa-arrow-circle-right"></i> &nbsp;Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="imagePane">
                                <div class="box-header">
                                    <h3 class="box-title">MEDIA CONTENT</h3>
                                </div>
                                <div class="gb-body">
                                    <div class="form-group">
                                        <label for="video">Product Video</label>
                                        <div class="form-instruction">You may leave this blank if the product has no video.</div>
                                        <textarea name="video" id="video" class="form-control @error('video') is-invalid @enderror" rows="1">{{ old('video') }}</textarea>
                                        @error('video') <p class="error-p">{{$errors->first('video')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="p_image">Product Primary Image - <span>(Image size should be less than 2 MB)</span></label>
                                        <input type="file" name="p_image" class="form-control  @error('p_image') is-invalid @enderror" id="p_image">
                                        @error('p_image') <p class="error-p">{{$errors->first('p_image')}}</p> @enderror
                                        <div id="p_image_preview" class="row"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="s_image">Product Secondary Image - <span>(Image size should be less than 2 MB)</span></label>
                                        <input type="file" name="s_image" class="form-control  @error('s_image') is-invalid @enderror" id="s_image">
                                        @error('s_image') <p class="error-p">{{$errors->first('s_image')}}</p> @enderror
                                        <div id="s_image_preview" class="row"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="album">Product Album Images - <span>(Image size should be less than 2 MB)</span></label>
                                        <div class="form-instruction">If you want to associate more images to the post please add them here. Preferred Image size is - </div>
                                        <input type="file" name="album[]" class="form-control  @error('album') is-invalid @enderror" id="album" multiple>
                                        @error('album') <p class="error-p">{{$errors->first('album')}}</p> @enderror
                                        <div id="images_preview" class="row"></div>
                                    </div>
                                </div>

                                <div class="tile-footer">
                                    <div class="row d-print-none mt-2">
                                        <div class="col-md-6 text-left">
                                            <a class="btn btn-success" href="#" id="section3P"><i class="fa fa-fw fa-lg fa-arrow-circle-left"></i> &nbsp;Previous</a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a class="btn btn-success" href="#" id="section3N"><i class="fa fa-fw fa-lg fa-arrow-circle-right"></i> &nbsp;Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="seoPane">
                                <div class="box-header">
                                    <h3 class="box-title">SEO CONTENT</h3>
                                </div>
                                <div class="gb-body">
                                    <div class="form-group">
                                        <label for="metatag">Meta Tags</label>
                                        <textarea name="metatag" id="metatag" class="form-control @error('metatag') is-invalid @enderror" rows="5">{{ old('metatag') }}</textarea>
                                        @error('metatag') <p class="error-p">{{$errors->first('metatag')}}</p> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="metadescp">Meta Description</label>
                                        <textarea name="metadescp" id="metadescp" class="form-control @error('metadescp') is-invalid @enderror" rows="5">{{ old('metadescp') }}</textarea>
                                        @error('metadescp') <p class="error-p">{{$errors->first('metadescp')}}</p> @enderror
                                    </div>
                                </div>
                                <div class="tile-footer">
                                    <div class="row d-print-none mt-2">
                                        <div class="col-md-6 text-left">
                                            <a class="btn btn-success" href="#" id="section4P"><i class="fa fa-fw fa-lg fa-arrow-circle-left"></i> &nbsp;Previous</a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </section>
</div>
@endsection

@section('footer')
    <script src="/cmadmin/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="/cmadmin/parsley/parsley.js"></script>
    <script src="/cmadmin/code/js/productCRUD.js"></script>
@endsection