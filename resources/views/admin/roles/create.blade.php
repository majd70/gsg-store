@extends('layouts.admin')

@section('title')
    Create new Role
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Products</li>
        <li class="breadcrumb-item active"> Create</li>
    </ol>
@endsection

@section('content')

    <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
        @csrf


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
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}">
            @error('name')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            @foreach (config('abilities') as $key=>$value)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="abilities[]" value="{{$key}}" >
                <label class="form-check-label" >
                     {{$value}}
                </label>
              </div>
            @endforeach
        </div>



        <div class="form-group">
            <button type="submit" class="btn btn-primary">save</button>
        </div>




    </form>

@endsection
