<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth']);
        //$this->middleware('auth')->except('index');
    }




    //بتجيب كل الكاتيجوري وبتعرضهم بصفحة
    public function index()
    {
        /*
        retern collection of category model object
        select *from categories table
        $entries=category::all(['*']);

        */

        /*
          retern collection of category model object
          select id and status from categories table where status=active
          $entries=category::where('status','=','active')
          ->get(['id','status']);
        */


        /*
        return collection of stdObj object
        $entries=DB::table('catagories')
        ->where('status','=','active')
        ->orderBy('created_at','asc')
        ->get();
       */



        /*
        select categories.*,parent.name as parent_name From
        categories LEFT JOIN categories as parents
        ON parents.id=categories.parent_id
        Where status ='active'
        ORDER BY created_at DESC

      */
        $entries = category::/*leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            // ->where('categories.status','=','active')
            */with('parent')
            // ->has('products')
            ->withCount('products as count') //from 1-m relation
           // ->orderBy('categories.created_at', 'DESC')

            ->withTrashed()
            ->get();

        $success = session()->get('success'); //السيشن هاي حطينا فيها الداتا في ال الديستروي فنكشن
        //  session()->forget('success');






        return view('admin.categories.index', [
            'categories' => $entries,
            'title' => 'Categories List',
            'success' => $success

        ]); // الاريي هي الداتا الي حتمررها ل ملف الفيو  وال كاتيغوري والتايتل هما فاريبل حيتمررو ل ملف الفيو

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //انشاء كاتيجوري جديد يعني مفروض يرجعلي صفحة تحتوي على فورم للاضافة
    public function create()
    {
        $parents = category::all();
        $category02 = new category();

        return view('admin.categories.create', [
            'parents' => $parents,
            'category02' => $category02

        ]);
    }







    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //بتخزن الكاتيجوري الي تم انشائو
    public function store(CategoryRequest $request)
    {

        /*
        //vallidation method1

        $rule = [
            'name' => 'required|string|max:255|min:3|unique:categories,name',  //the key of array is the name of input that come from form
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'min:5',
            'status' => 'required|in:active,draft',
            'image' => 'nullable|image|max:512000|dimensions:min_width=300,min_height=300',
        ];

         $clean= $request->validate($rule,[
            'name.required'=> 'الرجاء ادخال اسم',
         ]);

       */

        //validation(method2)(with return the input that entered in the previes request)
        /*
        $data = $request->all();
        $validator = Validator::make($data, $rule);
        //$clean= $validator->validate();
        try{
            $clean= $validator->validate();
        }catch(Throwable $e){
            return redirect()->back()->withErrors($validator)
            ->withInput();
        }

     */


        //validation method3 (usning custom request )



        /*his how laravel views read the errors object

         if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

       */







        $request->merge([   //ل اضافة بيانات ما اجتني من الفورم على الريكويست
            'slug' => Str::slug($request->name),
            'status' => 'active'
        ]);


        //return assioative array of all form field
        //the key of array is the name of form field and the value is the value of form field
        $request->all();

        //return single field value
        $request->description;
        $request->input('description');
        $request->get('description');
        $request->post('description');

        //store data that come from form into database

        //method 1
        /*  $categoru01=new category();
        $categoru01->name=$request->post('name');
        $categoru01->slug=Str::slug($request->post('name'));
        $categoru01->parent_id=$request->post('parent_id');
        $categoru01->description=$request->post('description');
        $categoru01->status=$request->post('status','active');
        $categoru01->save();

    */

        //method2:mass assigment (neeed fillable in model)
        $categoru01 = category::create([
            'name' => $request->post('name'),
            'slug' => Str::slug($request->post('name')),
            'parent_id' => $request->post('parent_id'),
            'description' => $request->post('description'),
            'status' => $request->post('status', 'active')
        ]);


        //method3:mass assigment (neeed fillable in model)
        /* $categoru01=new category([
            'name'=>$request->post('name'),
            'slug'=>Str::slug($request->post('name')),
            'parent_id'=>$request->post('parent_id'),
            'description'=>$request->post('description'),
            'status'=>$request->post('status','active')
        ]);
        $categoru01->save();
        */

        //method 4
        /*
        $request->merge([   //ل اضافة بيانات ما اجتني من الفورم على الريكويست
            'slug'=>Str::slug($request->post('name')),
            'status'=>$request->post('status','active')
        ]);
        $categoru01=new category($request->all());//هان ممكن تستخدم طريقة 2
        $categoru01->save();
     */


        /*
        $categoru01=category::create($request->except('image'));
        $categoru01=category::create($request->only('name'));
    */


        //PRG

        return redirect(route('categories.index'))
            ->with('success', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = category::findOrFail($id);
        return $category->load([
            'parent',
            'products' => function ($query) {
                $query->orderBy('price', 'ASC')->where('status', 'draft ');
            }
        ]);
        /*
        return $category->products()
        ->with('category:id,name')//تحميل الريليشن كاتيجوري على الريليشن الاولى بمصطلح ايجر لودنق وبعد النقطتين بتحدد اسماء الاعمدة الي بدك اياها ترجع من الكاتيجوري وال لاي دي لازم تحطو
        ->where('price','>',12)
        ->orderBy('price','ASC')
        ->get();
        */
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //يتعرضلي فورم عشان اعدل ع كاتيجوري معين
    public function edit($id)
    {
        //$category01=category::where('id','=',$id)->first();
        $category02 = category::find($id);
        if (!$category02) {
            abort(404);
        }
        $parents = category::withTrashed()->where('id', '!=', $category02->id)->get();

        return view('admin.categories.edit', [
            'category02' => $category02,
            'parents' => $parents
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
        $category01 = category::find($id);

        //validation rule
        $clean = $request->validate([
            'name' => 'required|string|max:255|min:3|unique:categories,name',  //the key of array is the name of input that come from form
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => 'min:5',
            'status' => 'required|in:active,draft',
            // 'image'=> 'nullable|image|max:512000|dimensions:min_width=300,min_height=300',

        ]);

        /*
        //method1
        $category01->name=$request->post('name');
        $category01->parent_id=$request->post('parent_id');
        $category01->decription=$request->post('description');
        $category01->status=$request->post('status');
        $category01->save();
         */

        //method2
        $category01->update([
            'name' => $request->post('name'),
            // 'slug'=>Str::slug($request->post('name')),
            'parent_id' => $request->post('parent_id'),
            'description' => $request->post('description'),
            'status' => $request->post('status')
        ]);


        //method3 mass assigment
        /*
        $category01->update($request->all());//[س بدو يكون اسم الفيلد الي دخل بالفورم نفس اسم العمود بالداتا لبز]
        */


        /*
        //method4 mass asssigment
        $category01->fill($request->all())->save();

       */


        /*
        //method5 mass asssigment
        category::where('id','=',$id)-update($request()->all);

       */




        //PRG
        return redirect(route('categories.index'))
            ->with('success', 'Category updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //method1
        $category01 = category::find($id);
        $category01->delete();

        /*
         //method2
        category::destroy($id);
        */

        /*
        //method3
        category::where('id','=',$id)->delete();
        */

        // session()->put('success',' Category deleted');





        //PRG
        return redirect(route('categories.index'))
            ->with('success', 'Category deleted');
    }
}
