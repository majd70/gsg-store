@extends('layouts.admin')

@section('title')
    Edit category
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Products</li>
        <li class="breadcrumb-item active"> edit</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('products.update',  $product->id) }}" method="post" enctype="multipart/form-data" > <!--الانكتايب لازم ينضاف باي فورم حيتم تسليم فيه ملفات -->
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
            <label for="">Product Name</label>
            <input type="text" class="form-control" name="name" value="{{ $product->name }}">
        </div>

        <div class="form-group">
            <label for="">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($category->id == $product->category_id) selected @endif>
                        {{ $category->name }}</option>
                @endforeach
            </select>

        </div>


        <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" name="description">{{ $product->description }}</textarea>
        </div>


        <div class="form-group">
            <label for="">Image</label>
            <input type="file" class="form-control" name="image">
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
