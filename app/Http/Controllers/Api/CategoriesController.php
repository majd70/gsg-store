<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $user=Auth::guard('sanctum')->user();

        if(! $request->user()->tokenCan('categories.create')){
             abort(403,'not allowed');
        }

        $request->validate([
             'name'=>'required',
             'parent_id'=>'nullable|int|exists:categories,id:'
        ]);
        $category=category::create($request->all());
        //$category = Category::with('children')->find($category->id);

        $category->refresh()->load('children');// عشان يرجع الكولوم الي ما اجت ب الريكويست والي قيمتها نل

        return response()->json($category,201,[
            'x-application-name'=>config('app.name')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $category= category:: with('children')->findOrFail($id);
        return[
            'id'=>$category->id,
            'title'=>$category->name,
            'sub_categories'=>$category->children,
        ];

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
        $request->validate([
            'name'=>'sometimes|required',//سوم تايم يعني ريكوايرد اذا كان موجود بالريطكويست بودي يعني اذا كان اليوزر باعتو
            'parent_id'=>'nullable|int|exists:categories,id:'
       ]);
       $category=category::findOrFail($id);
       $category->update($request->all());

       return response()->json([
        'message'=>'category updated',
        'category'=>$category,
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=category::findOrfail($id);
        $category->delete();

        return response()->json([
            'message'=>'category deleted'
        ]);

    }
}
