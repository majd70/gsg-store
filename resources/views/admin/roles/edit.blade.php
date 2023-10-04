@extends('layouts.admin')

@section('title')
    Edit Role
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Roles</li>
        <li class="breadcrumb-item active"> edit</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('roles.update',  $role->id) }}" method="post" enctype="multipart/form-data" > <!--الانكتايب لازم ينضاف باي فورم حيتم تسليم فيه ملفات -->
        <!-- ['id'=>$category02->id]  الباراميتر الي ب الراوت ابديت -->
        @csrf
        @method('put')

        <!--read validate error-->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $message)
                        <li> {{ $message }}</li>
                        @endforeach
                </ul>
        </div>
         @endif




        <div class="form-group">
            <label for="">Role Name</label>
            <input type="text" class="form-control" name="name" value="{{ $role->name }}">
        </div>

        <div class="form-group">
            @foreach (config('abilities') as $key=>$value)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="abilities[]" value="{{$key}}" @if (in_array($key,$role->abilities ?? [])) checked   @endif >


             <label class="form-check-label" >
                     {{$value}}
                </label>
              </div>
            @endforeach
        </div>




        <div class="form-group">
            <button type="submit" class="btn btn-primary">update</button>
        </div>


    </form>
@endsection
