<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',product::class);

        $products = product::

             with('category.parent')//من خلال علاقة الكاتيغوري استغنينا عن الجوين
              /*join('categories', 'categories.id', '=', 'products.category_id')
            ->select([
                'products.*',
                'categories.name as category_name',
            ])*/
            ->withoutGlobalScope('active')
            ->paginate(3); //بتقسم الداتا الراجعة على صفحات و=الرقم هو عدد الصفوف بكل صفحة


        $success = session()->get('success');

        return view('admin.products.index', [
            'products' => $products,
            'success' => $success
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $this->authorize('create',product::class);

        $categories = category::all();
        return view('admin.products.create', [
            'categories' => $categories,
            'product' => new product()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $this->authorize('viewAny',product::class);

        $request->validate(product::validateRule());
      /*  $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);*/
        if ($request->hasFile('image')) {
            $file = $request->file('image'); //ublodedfile object
            $image_path = $file->store('/', [   //البراميتر الاول هو الباث تاع المجلد داخل الديسك والبراميتر الثاني هو نوع الديسك
                'disk'=>'uploads' //الابلود ديسك هو عبارة عن كستم ديسك بتعملو من الفايل سستم
            ]);
            $request->merge([
                'image_path' => $image_path,
            ]);
        }
        $product = product::create($request->all());
        return redirect()->route('products.index')
            ->with('success', "Product ($product->name) created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = product::withoutGlobalScope('active')->findOrFail($id);
        $this->authorize('view',$product);

        return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $categories = category::withTrashed()->get();

        $product = product::withoutGlobalScope('active')->findOrFail($id);

        $this->authorize('update',$product);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
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

        $product = product::withoutGlobalScope('active')->find($id);

        $this->authorize('update',$product);

        $request->validate(product::validateRule());

        if ($request->hasFile('image')) {
            $file = $request->file('image'); //ublodedfile object
            // $file->getClientOriginalName();//return file name
            // $file->getClientOriginalExtension();
            // $file->getClientMimeType();
            //$file->getSize();

            //Filesystem-Disks
            //local:Storage/app
            //public:Storage/app/public
            //s3:Amazon Drive
            //custom:define by us

            $image_path = $file->store('/', [   //البراميتر الاول هو الباث تاع المجلد داخل الديسك والبراميتر الثاني هو نوع الديسك
                'disk'=>'uploads' //الابلود ديسك هو عبارة عن كستم ديسك بتعملو من الفايل سستم
            ]);
            $request->merge([
                'image_path' => $image_path,
            ]);
        }
        //dd($request->all());

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', "product ($product->name) updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = product::withoutGlobalScope('active')->find($id);
        $this->authorize('delete',$product);

        $product->delete();
      //  Storage::disk('uploads')->delete($product->image_path);
        //or unlink(public_path('uploads/' . $product->image_path));

        return redirect()->route('products.index')
            ->with('success', "product ($product->name) deleted");
    }


    public function trash()
    {

        $success = session()->get('success');
        $products=product::withoutGlobalScope('active')->onlyTrashed()->paginate();
        return view('admin.products.trash',[
            'products'=>$products,
            'success'=>$success,
        ]);
    }


    public function restore(Request $request,$id=null )
    {
          if($id){
          $product=product::withoutGlobalScope('active')->onlyTrashed()->findOrFail($id);
          $product->restore();//بتخلي قيمة عمود الديليت ات في البروكت تساوي نل

          return redirect()->route('products.index')
          ->with('success', "product ($product->name) restored");

          }

          product::withoutGlobalScope('active')->onlyTrashed()->restore();

          return redirect()->route('products.index')
          ->with('success', "all trashed products restored");
    }

    public function forceDelete($id=null){
        if($id){
            $product=product::withoutGlobalScope('active')->onlyTrashed()->findOrFail($id);
            $product->forceDelete();//بتخلي قيمة عمود الديليت ات في البروكت تساوي نل

            return redirect()->route('products.index')
            ->with('success', "product ($product->name) deleted forever");

            }

            product::withoutGlobalScope('active')->onlyTrashed()->forceDelete();

            return redirect()->route('products.index')
            ->with('success', "all trashed products deleted forever");

    }
}
