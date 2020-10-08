<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use Illuminate\Http\Request;
use DataTables;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Subcategory::latest()->get();
        $categories = Category::where('publication_status',1)->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editSubcategory">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteSubcategory">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('subcategory', compact('data','categories'));
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
        Subcategory::updateOrCreate(['id' => $request->subcategory_id],
            [
                'category_id'=> $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'description' => $request->description,
                'publication_status'=>  $request->publication_status
            ]);

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
//        $categoreys= Category::where('publication_status',1);
        $subcategory = Subcategory::find($id);
        return response()->json($subcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subcategory::find($id)->delete();
        return response()->json(['success'=>'Subcategory deleted successfully.']);
    }
}
