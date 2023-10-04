@extends('layouts.admin')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Products</li>

    </ol>
@endsection

@section('content')

    <x-alert success="{{ $success }}" />

    <x-message type="info" :count="1 + 1">
        <x-slot name="title"> Info </x-slot>

        <p> welcome to laravel </p>

    </x-message>

@section('title')
    <div class="d-flex justify-content-between">
        <h2>Products </h2>
        <div class="">
            @can('create',App\Models\product::class)
            <a class="btn btn-s btn-outline-primary" href="{{ route('products.create') }}"> Create</a>
            @endcan

            <a class="btn btn-s btn-outline-dark" href="{{ route('products.trash') }}"> Trash</a>

        </div>
    </div>
@endsection

<table class="table">
    <thead>
        <tr>
            <th> Image </th>
            <th> Name </th>
            <th> Category</th>
            <th> Price </th>
            <th> Quantity </th>
            <th> status </th>
            <th> craeted at </th>

        </tr>

    </thead>

    <tbody>
        @foreach ($products as $product)
            <!--categories is the variable from categorycontroller -->


            <tr>

                <td> <img src="{{ $product->image_url }}" width="70" alt=""> </td>
                <td>{{ $product->name }} </td>

                <td>{{ $product->category->name }} /{{ $product->category->parent->name}}</td>
                <td>{{ $product->formatted_price }} </td>
                <td>{{ $product->quantity }} </td>
                <td>{{ $product->status }} </td>
                <td>{{ $product->created_at }} </td>

                @can('update',$product)
                <td><a href="{{ route('products.edit', $product->id) }}" class="btn btn-small btn-dark">Edit</a></td>
                @endcan

                 @can('delete',$product)
                 <td>
                    <form action="{{ route('products.destroy', $product->id) }}" method="post">
                        <!--    حطينا الراوت بفورم لانو الراوت معمول بطريقة الديليت ولازم اخليه بطريقة الديليت عن طريق الفنكشن ميثود-->
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-small btn-danger">delete</button>
                    </form>
                </td>
                 @endcan




            </tr>
        @endforeach
    </tbody>

</table>

<div class="d-flex">

    <div class="">

        {{ $products->links() }}
        <!-- تقسيم البجينيت على لنكات كل لنك ك صفحة -->
    </div>
    <div class="ml-auto">
        {{ $products->total() }} Entries
        <!--ميثود على مستوى الباجينيشن-->

    </div>
</div>


@endsection
