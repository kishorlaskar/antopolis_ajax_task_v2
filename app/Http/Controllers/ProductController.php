<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Subcategory;
use App\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $sub        =  Subcategory::latest()->get();
        $categories  =  Category::where('publication_status',1)->get();
        $brands      = Brand::where('publication_status',1)->get();

        if ($request->ajax()) {
            return Datatables::of($sub,$categories,$brands)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('products', compact('data','categories','brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'category_id'    =>  'required',
            'subcategory_id' => 'required',
            'brand_id' => 'required',
            'product_name' => 'required',
            'product_size' => 'required',
            'product_color' => 'required',
            'product_price' => 'required',
            'product_quantity' => 'required',
            'product_short_description'     =>  'required',
            'product_image'         =>  'required|image|max:2048',
            'publication_status'  => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $image = $request->file('product_image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('pimages'), $new_name);

        $form_data = array(
            'brand_name'        =>  $request->brand_name,
            'brand_description'         =>  $request->brand_description,
            'brand_image'             =>  $new_name,
            'publication_status'      => $request->publication_status
        );

        Brand::create($form_data);

        return response()->json(['success' => 'Brand Added successfully.']);

        return response()->json(['success'=>'Subcategory saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
