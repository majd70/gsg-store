@extends('layouts.admin')

@section('title')
    Create new product
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Products</li>
        <li class="breadcrumb-item active"> Create</li>
    </ol>
@endsection

@section('content')

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
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
            <label for="">product Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}">
            @error('name')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Category</label>
            <select name="category_id" id="category_id" class="form-control" >
                <option value="">select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ old($category->name,$category->name)}}</option>
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
            <label for="price">Price</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old('price')}}">
            @error('price')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="sale_price">Sale Price</label>
            <input type="number" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{old('sale_price')}}">
            @error('sale_price')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>


        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{old('quantity')}}">
            @error('quantity')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="weight">Weight</label>
            <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" value="{{old('weight')}}">
            @error('weight')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="sku">Sku</label>
            <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{old('sku')}}">
            @error('sku')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="width">Width</label>
            <input type="number" class="form-control @error('width') is-invalid @enderror" name="width" value="{{old('width')}}">
            @error('width')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="height">Height</label>
            <input type="number" class="form-control @error('height') is-invalid @enderror" name="height" value="{{old('height')}}">
            @error('height')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>

        <div class="form-group">
            <label for="lenght">Lenght</label>
            <input type="number" class="form-control @error('lenght') is-invalid @enderror" name="lenght" value="{{old('lenght')}}">
            @error('lenght')
                <!--read validate error in spesific field-->
                <p class="invalid-feedback">{{ $message }} </p>
            @enderror
        </div>





        <div class="form-group">
            <label for="status">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-active" value="active"
                    @if ($product->status == 'active') checked @endif>
                <label class="form-check-label" for="flexRadioDefault1">
                    Active
                </label>
            </div>


            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft"
                    @if ($product->status == 'draft') checked @endif>
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
