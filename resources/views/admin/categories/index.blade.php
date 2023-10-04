@extends('layouts.admin')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active"> Categories</li>

</ol>
@endsection

@section('content')

  @if($success)
  <div class="alert alert-success">
   {{$success}}
  </div>
   @endif

   @section('title')
    <h2> {{ $title }} <a href="{{ route('categories.create') }}"> Create</a> </h2>
    @endsection
    <table class="table">
        <thead>
            <tr>
                <td> {{__('ID')}} </td>
                <td> {{__('Name')}} </td>
                <td> {{__('Slug')}} </td>
                <td> {{__('Parent Name')}}</td>
                <td>  {{__('Products count')}}</td>
                <td> {{__('Status')}} </td>
                <td> {{__('Created')}} </td>
                <td> </td>
            </tr>

        </thead>

        <tbody>
            @foreach ($categories as $category)
                <!--categories is the variable from categorycontroller -->


                <tr>
                   <!-- <td>{{$loop->first? 'First': ($loop->last? 'Last':$loop->iteration)}} </td>-->
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }} </td>
                    <td>{{ $category->slug }} </td>
                    <td>{{ $category->parent->name }} </td>
                    <td>{{$category->count}} </td>
                    <td>{{ $category->status }} </td>
                    <td>{{ $category->created_at }} </td>
                    <td><a href="{{route('categories.edit',$category->id)}}" class="btn btn-small btn-dark">Edit</a></td>
                    <td>
                        <form action="{{route('categories.destroy',['id'=>$category->id])}}" method="post" ><!--    حطينا الراوت بفورم لانو الراوت معمول بطريقة الديليت ولازم اخليه بطريقة الديليت عن طريق الفنكشن ميثود-->
                         @csrf
                         @method('delete')
                         <button type="submit" class="btn btn-small btn-danger">delete</button>
                    </form>
                   </td>



                </tr>
            @endforeach
        </tbody>

    </table>


@endsection
