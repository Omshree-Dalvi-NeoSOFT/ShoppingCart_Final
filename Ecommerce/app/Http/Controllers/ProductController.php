<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributesAssoc;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;

use function PHPUnit\Framework\once;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // add product page
    public function addProduct(){
        try{
            $subcategories = SubCategory::all();
            return view('product.addproduct',compact('subcategories'));
        }catch(\Illuminate\Database\QueryException $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // add product
    public function postaddProduct(Request $req){
        try{
            $validate = $req->validate([
                'prodname' => ['required' , 'string' , 'max:100'],
                'subcat' => ['required'],
                'prodcolour' => ['required'],
                'prodquant' => ['required','integer'],
                'prodprics' => ['required' , 'numeric'],
                'proddescription' => ['max:1000'],
                'imgmain' => ['required']
            ]);
            if($validate){
                $subcategory = SubCategory::where('id',$req->subcat)->first();
                $product = new Product();
                $product->sub_category_id = $req->subcat;
                $product->prod_name = $req->prodname;
                $product->prod_description = $req->proddescription;
                $product->colour = $req->prodcolour;
                $product->quantity = $req->prodquant;
                $product->price = $req->prodprics;
                $file = $req->file('imgmain');
                $fname = $file->getClientOriginalName();
                $filename = rand() . "-" . time() . "-" . $fname;
                $dest = public_path("/images/product");
    
                if($file->move($dest,$filename)){
                    $product->prod_mainimage = $filename;
                    $subcategory->prod()->save($product);
                }
                if($req->attr){
                    $productid = Product::latest()->first();
                    foreach ($req->attr as $key => $value ) {
                        $n = $value;
                        $prodassoc = new ProductAttributesAssoc();
                        $prodassoc->attr_name = $n['name'];
                        $prodassoc->arrt_value = $n['value'];
                        $productid->prodAttr()->save($prodassoc);
                    }
                }
                if($files=$req->file('img')){
                    $productid = Product::latest()->first();
                    foreach($files as $file):
                        $prodimg = new ProductImage();
                        $fname=$file->getClientOriginalName();
                        $filename=rand() . "-" . time() . "-" . $fname;
                        $prodimg->prodimg=$filename;
                        $dest=public_path("/images/product");
                        if($file->move($dest,$filename))
                            {
                                $productid->images()->save($prodimg);
                            }
                    endforeach;
                    
                }
    
                return back()->with('status',"Product Added Successfully !");
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // display all products
    public function showProduct(){
        try{
            $products = Product::all();
            $prodsubcat = SubCategory::all();
            return view('product.showproduct',compact('products','prodsubcat'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // display detail product
    public function displayProduct($id){
        try{
            $product = Product::where('id',$id)->firstorFail();
            $productImages = ProductImage::where('product_id',$product->id)->get();
            $productAssocs = ProductAttributesAssoc::where('product_id',$product->id)->get();
            $subcat = SubCategory::where('id',$product->sub_category_id)->firstorFail();
            $catid = Category::where('id',$subcat->category_id)->firstorFail();

            return view('product.displayproduct',compact('product','productImages','productAssocs','subcat','catid'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // edit product
    public function editProduct($id){
        try{
            $product = Product::where('id',$id)->firstorFail();
            $productImages = ProductImage::where('product_id',$product->id)->get();
            $productAssocs = ProductAttributesAssoc::where('product_id',$product->id)->get();
            $subcat = SubCategory::where('id',$product->subcat_id)->firstorFail();
            $catid = Category::where('id',$subcat->category_id)->firstorFail();
            $subcategories = SubCategory::all()->except($product->subcat_id);

            return view('product.editproduct',compact('product','productImages','productAssocs','subcat','catid','subcategories'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // delete product image
    public function deleteProductImage(Request $req){
        try{
            ProductImage::where('id',$req->aid)->delete();
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // delete product attributes
    public function deleteProductAttr(Request $req){
        try{
            ProductAttributesAssoc::where('id',$req->atrid)->delete();
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // update product
    public function updateProduct(Request $req){
        try{
            $validate = $req->validate([
                'prodname' => ['required' , 'string' , 'max:100'],
                'subcat' => ['required'],
                'prodcolour' => ['required'],
                'prodquant' => ['required','integer'],
                'prodprics' => ['required' , 'numeric'],
                'proddescription' => ['max:1000'],
                
            ]);
            if($validate){
                Product::where('id',$req->id)->update([
                    'subcat_id' => $req->subcat,
                    'prod_name' => $req->prodname,
                    'prod_description' => $req->proddescription,
                    'colour' => $req->prodcolour,
                    'quantity' => $req->prodquant,
                    'price' => $req->prodprics,
                ]);
                if($file=$req->file('imgmain')){
                    $fname=$file->getClientOriginalName();
                        $filename = rand() . "-" . time() . "-" . $fname;
                        $dest = public_path("/images/product");
                        
                        if($file->move($dest,$filename)){
                            Product::where('id',$req->id)->update([
                                'prod_mainimage' => $filename
                            ]);
                        }             
                }
                if($files=$req->file('img'))
                {
                    $productid=Product::where('id',$req->id)->first();
                    foreach($files as $file):
                        $prodimg = new ProductImage();
                        $fname=$file->getClientOriginalName();
                        $filename=rand() . "-" . time() . "-" . $fname;
                        $prodimg->prodimg=$filename;
                        $dest=public_path("/images/product");
                        if($file->move($dest,$filename))
                            {
                                $productid->Images()->save($prodimg);
                            }
                    endforeach;
                }
                if($req->attr){
                    $productid = Product::where('id',$req->id)->first();
                    foreach ($req->attr as $key => $value ) {
                        $n = $value;
                        $prodassoc = new ProductAttributesAssoc();
                        $prodassoc->attr_name = $n['name'];
                        $prodassoc->arrt_value = $n['value'];
                        $productid->ProdAttr()->save($prodassoc);
                    }
                }            
            }
            return back();
        }catch(\Illuminate\Database\QueryException $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // delete product
    public function deleteProduct(Request $req){
        try{
            Product::where('id',$req->aid)->delete();
        }catch(\Exception $e){
            return view('layouts.pagenotfound')->with('error', $e->getMessage());
        }
    }
}
