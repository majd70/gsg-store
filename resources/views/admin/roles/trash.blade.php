@extends('layouts.admin')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Products</li>

    </ol>
@endsection

@section('content')

    <x-alert success="{{ $success }}" />

      <div class="d-flex mb-4">


            <form action="{{ route('products.restore') }}" method="post" class="mr-3">
                <!--    حطينا الراوت بفورم لانو الراوت معمول بطريقة الديليت ولازم اخليه بطريقة الديليت عن طريق الفنكشن ميثود-->
                @csrf
                @method('put')
                <button type="submit" class="btn btn-small btn-warning">Restore all </button>
            </form>




            <form action="{{ route('products.forceDelete') }}" method="post">
                <!--    حطينا الراوت بفورم لانو الراوت معمول بطريقة الديليت ولازم اخليه بطريقة الديليت عن طريق الفنكشن ميثود-->
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-small btn-danger">Delete Forevar</button>
            </form>



     </div>

@section('title')
    <div class="d-flex justify-content-between">
        <h2>Trashed Products </h2>
        <div class="">

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
            <th> deleted at </th>

        </tr>

    </thead>

    <tbody>
        @foreach ($products as $product)
            <!--categories is the variable from categorycontroller -->


            <tr>

                <td> <img src="{{ asset('uploads/' . $product->image_path) }}" width="70" alt=""> </td>
                <td>{{ $product->name }} </td>

                <td>{{ $product->category_name }} </td>
                <td>{{ $product->price }} </td>
                <td>{{ $product->quantity }} </td>
                <td>{{ $product->status }} </td>
                <td>{{ $product->deleted_at }} </td>

                <td>
                    <form action="{{ route('products.restore', $product->id) }}" method="post">
                        <!--    حطينا الراوت بفورم لانو الراوت معمول بطريقة الديليت ولازم اخليه بطريقة الديليت عن طريق الفنكشن ميثود-->
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-small btn-warning">Restore</button>
                    </form>
                </td>



                <td>
                    <form action="{{ route('products.forceDelete', $product->id) }}" method="post">
                        <!--    حطينا الراوت بفورم لانو الراوت معمول بطريقة الديليت ولازم اخليه بطريقة الديليت عن طريق الفنكشن ميثود-->
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-small btn-danger">Delete Forevar</button>
                    </form>
                </td>



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
