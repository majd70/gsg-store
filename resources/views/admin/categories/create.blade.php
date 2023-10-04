@extends('layouts.admin')

@section('title')
    Create new category
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Categories</li>
        <li class="breadcrumb-item active"> Create</li>
    </ol>
@endsection

@section('content')

    <form action="{{ route('categories.store') }}" method="post">
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
            <label for="">{{__('Category Name')}}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}">
            @error('name')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Parent</label>
            <select name="parent_id" id="parent_id" class="form-control" >
                <option value="">No Parent</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}">{{ old($parent->name,$parent->name)}}</option>
                @endforeach
            </select>

            @error('parent_id')
                <!--read validate error in spesific field-->
                <p class="text-danger">{{ $message }} </p>
            @enderror

        </div>


        <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>

            @error('description')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>


        <div class="form-group">
            <label for="">Image</label>
            <input type="file" class="form-control" name="image">

            @error('image')
                <!--read validate error in spesific field-->
                <p class="text-danger">{{ $message }} </p>
            @enderror

        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-active" value="active"
                    @if ($category02->status == 'active') checked @endif>
                <label class="form-check-label" for="flexRadioDefault1">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft"
                    @if ($category02->status == 'draft') checked @endif>
                <label class="form-check-label" for="flexRadioDefault2">
                    Draft
                </label>
            </div>

        </div>



        <div class="form-group">
            <button type="submit" class="btn btn-primary">save</button>
        </div>




    </form>

@endsection
