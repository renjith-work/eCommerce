<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Product\Brand;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductAttributeValueSave;
use App\Models\Product\Order\PoType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Auth;
use Validator;
use Session;
Use Image;
Use Storage;
Use Purifier;
use File;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'product']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       	$products = Product::orderBy('id', 'asc')->paginate(15);
       	return view('admin.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = ProductCategory::orderBy('id', 'asc')->get();
        $po_types = PoType::all();
        $brands = Brand::orderBy('id', 'asc')->get();
        return view('admin.product.create')->with('categories', $categories)->with('po_types', $po_types)->with('brands', $brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255|unique:products,name',
            'category' => 'required',
            'description' => 'required',
            'summary' => 'required',
            'price' => 'required',
            'po_type' => 'required',
            'p_image' =>   'required|image|mimes:jpeg,png,jpg,gif,svg|max:2000',
            's_image' =>   'required|image|mimes:jpeg,png,jpg,gif,svg|max:2000',
            'album*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
            'metatag' => 'required',
            'metadescp' => 'required',
        ],
        [
            'p_image.max' => 'Max image upload size is 2 MB.',
            'p_image.required' => 'A primary image is required to display the product.',
            's_image.max' => 'Max image upload size is 2 MB.',
            's_image.required' => 'A secondary image is required to display the product.',
            'album.max' => 'Max image upload size is 2 MB.',
            'category.required' => 'Please select a category.',
            'po_type.required' => 'Please select a purchase type.',
        ]);

        if ($validator->passes()) {


        	$product = new Product;
        	$product->name = $request->name;
        	$product->user_id = 1;
        	$product->slug = Str::slug($request->name, '-'); 
        	$product->product_category_id = $request->category ;
            $product->fabric_id = $request->fabric;
        	$product->description = $request->description ;
        	$product->summary = $request->summary ;
            $product->price = $request->price ;
        	$product->og_price = $request->og_price ;
        	$product->video = $request->video;
            $product->metatag = $request->metatag;
            $product->metadescp = $request->metadescp;
            $product->featured = $request->featured;
            $product->menu = $request->menu;
            $product->brand_id = $request->brand;

        	if ($request-> hasFile('p_image')) //Check if the file exists
            {
                $image = $request->file('p_image'); //Grab and store the file on to $image
                $filename = Str::slug($request->name, '-').'-'.Str::slug(pathinfo($request->p_image->getClientOriginalName(), PATHINFO_FILENAME), '-').'-'.time(). '.'. $image->getClientOriginalExtension(); //Create a new filename
                $location = public_path('images/product/product/'. $filename);
                Image::make($image)->resize(600, 600)->save($location); //Use intervention to create an image model and store the file with the resize.
                $product->p_image= $filename; //store the filename in to the database.
            }

            if ($request-> hasFile('s_image')) //Check if the file exists
            {
                $image = $request->file('s_image'); //Grab and store the file on to $image
                $filename = Str::slug($request->name, '-').'-'.Str::slug(pathinfo($request->s_image->getClientOriginalName(), PATHINFO_FILENAME), '-').'-'.time(). '.'. $image->getClientOriginalExtension(); //Create a new filename
                $location = public_path('images/product/product/'. $filename);
                Image::make($image)->resize(600, 600)->save($location); //Use intervention to create an image model and store the file with the resize.
                $product->s_image= $filename; //store the filename in to the database.
            }

            if ($request-> hasFile('album')) //Check if the file exists
            {
                $count = 1;
                foreach($request->only('album') as $files){
                    foreach ($files as $file) {
                        if(is_file($file)) {    // not sure this is needed
                            $filename = Str::slug($request->name, '-').'-'.$count.'-'.time(). '.'. $file->getClientOriginalExtension();
                            $location = public_path('images/product/product/'. $filename);
                            Image::make($file)->resize(600, 600)->save($location); // path to file
                            $album_array[] = $filename;
                            $product->album = json_encode($album_array);
                            $count ++;
                        }
                    }
                }
            }

            $product->save();
            $product->po_types()->sync($request->po_type, false);

            $input = $request->all();
            $productAttribute_array = array();
            $attributes = ProductAttribute::where('product_category_id', $input['category'])->get();
            foreach($attributes as $attribute)
            {
                if (array_key_exists($attribute->code, $input)){
                    $productAttribute_array[] =array(
                                                
                                                'product_id' => $product->id, 
                                                'product_attribute_id' => $attribute->id, 
                                                'product_attribute_value_id' => $input[$attribute->code], 
                                            );
                }
            }

            ProductAttributeValueSave::insert($productAttribute_array);
            Session::flash('success', 'The data was successfully inserted.');
            return redirect()->back();
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }	

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.product.view')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::orderBy('id', 'asc')->get();
        $brands = Brand::orderBy('id', 'asc')->get();
        $po_types = PoType::all();
        
        $sel_poTypes = array();
        foreach($product->po_types as $type)
        {
            $sel_poTypes[] = $type->id;
        }
        return view('admin.product.edit')->with('categories', $categories)->with('po_types', $po_types)->with('sel_poTypes', $sel_poTypes)->with('product', $product)->with('brands', $brands);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|min:5|max:255|unique:products,name, $id",
            'category' => 'required',
            'description' => 'required',
            'summary' => 'required',
            'price' => 'required',
            'p_image' =>   'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
            's_image' =>   'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
            'album*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2000',
            'metatag' => 'required',
            'metadescp' => 'required',
        ],
        [
            'p_image.max' => 'Max image upload size is 2 MB.',
            's_image.max' => 'Max image upload size is 2 MB.',
            'album.max' => 'Max image upload size is 2 MB.',
            'category.required' => 'Please select a category.',
        ]);

        if ($validator->passes()) {


            $product = Product::find($id);
            $product->name = $request->name;
            $product->user_id = 1;
            $product->slug = Str::slug($request->name, '-'); 
            $product->product_category_id = $request->category ;
            $product->fabric_id = $request->fabric;
            $product->description = $request->description ;
            $product->summary = $request->summary ;
            $product->price = $request->price ;
            $product->og_price = $request->og_price ;
            $product->video = $request->video;
            $product->metatag = $request->metatag;
            $product->metadescp = $request->metadescp;
            $product->featured = $request->featured;
            $product->menu = $request->menu;
            $product->brand_id = $request->brand;

            if ($request-> hasFile('p_image')) //Check if the file exists
            {
                $image = $request->file('p_image'); //Grab and store the file on to $image
                $filename = Str::slug($request->name, '-').'-'.Str::slug(pathinfo($request->p_image->getClientOriginalName(), PATHINFO_FILENAME), '-').'-'.time(). '.'. $image->getClientOriginalExtension(); //Create a new filename
                $location = public_path('images/product/product/'. $filename);
                Image::make($image)->resize(600, 600)->save($location); //Use intervention to create an image model and store the file with the resize.
                
                $oldFilename1 = $product->p_image;
                $product->p_image= $filename; //store the filename in to the database.
                Storage::delete('product/product/'. $oldFilename1);
            }

            if ($request-> hasFile('s_image')) //Check if the file exists
            {
                $image = $request->file('s_image'); //Grab and store the file on to $image
                $filename = Str::slug($request->name, '-').'-'.Str::slug(pathinfo($request->s_image->getClientOriginalName(), PATHINFO_FILENAME), '-').'-'.time(). '.'. $image->getClientOriginalExtension(); //Create a new filename
                $location = public_path('images/product/product/'. $filename);
                Image::make($image)->resize(600, 600)->save($location); //Use intervention to create an image model and store the file with the resize.
                
                $oldFilename2 = $product->s_image;
                $product->s_image= $filename; //store the filename in to the database.
                Storage::delete('product/product/'. $oldFilename2);
            }

             if ($product->album) {
               $album_array = json_decode($product->album, true);
            }
            else{
                $album_array = [];
            }

            if ($request-> hasFile('album')) //Check if the file exists
            {
                $count = 1;
                foreach($request->only('album') as $files){
                    foreach ($files as $file) {
                        if(is_file($file)) {    // not sure this is needed
                            $filename = Str::slug($request->name, '-').'-'.$count.'-'.time(). '.'. $file->getClientOriginalExtension();
                            $location = public_path('images/product/product/'. $filename);
                            Image::make($file)->resize(600, 600)->save($location); // path to file
                            $album_array[] = $filename;
                            $product->album = json_encode($album_array);
                            $count ++;
                        }
                    }
                }
            }

            $product->save();

            if(isset($request->po_type)){
                $product->po_types()->sync($request->po_type);
            }else{
                $product->po_types()->sync(array());
            }

            $input = $request->all();
            $productAttribute_array = array();
            $attributes = ProductAttribute::where('product_category_id', $input['category'])->get();
            foreach($attributes as $attribute)
            {
                if (array_key_exists($attribute->code, $input)){
                    $productAttribute_array[] =array(
                                                
                                                'product_id' => $product->id, 
                                                'product_attribute_id' => $attribute->id, 
                                                'product_attribute_value_id' => $input[$attribute->code], 
                                            );
                }
            }

            ProductAttributeValueSave::where('product_id', $product->id)->delete();
            ProductAttributeValueSave::insert($productAttribute_array);

            Session::flash('success', 'The data was successfully inserted.');
            return redirect()->back();
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }   

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if($product->p_image)
        {
             Storage::delete('product/product/'. $product->p_image);
        }
        
        if($product->s_image)
        {
             Storage::delete('product/product/'. $product->s_image);
        }

        $images = json_decode($product->album);
        foreach($images as $image ){
            Storage::delete('product/product/'.$image);
        }

        ProductAttributeValueSave::where('product_id', $product->id)->delete();

        $product->po_types()->detach();
        $product->delete();

        Session::flash('success', 'The data was successfully deleted.');
        return redirect()->back();
    }


    public function imageDel($id, $image_id)
    {
        $product = Product::find($id);
        $images = json_decode($product->album);
        foreach($images as $image ){
            if ($image != $image_id){
                $image_array[] = $image;
            }else{
                 Storage::delete('product/product/'.$image);
            }
        }
        if(!empty($image_array)){
            $product->album = json_encode($image_array);
        }else{
            $product->album = json_encode (json_decode ("{}"));
        }
        
        $product->save();
        // return redirect()->back()->with;
        return redirect(url()->previous() . "#uploaded_images");
    }
}
