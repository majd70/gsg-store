@extends('layouts.admin')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Roles</li>

    </ol>
@endsection

@section('content')

    <x-alert success="{{ $success }}" />



@section('title')
    <div class="d-flex justify-content-between">
        <h2>Roles </h2>
        <div class="">

            <a class="btn btn-s btn-outline-primary" href="{{ route('roles.create') }}"> Create</a>


        </div>
    </div>
@endsection

<table class="table">
    <thead>
        <tr>

            <th> Name </th>
            <th> craeted at </th>

        </tr>

    </thead>

    <tbody>
        @foreach ($roles as $role)
            <!--categories is the variable from categorycontroller -->


            <tr>


                <td>{{ $role->name }} </td>
                <td>{{ $role->created_at }} </td>
                <td>

                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-small btn-dark">Edit</a></td>


                <td>

                    <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                        <!--    حطينا الراوت بفورم لانو الراوت معمول بطريقة الديليت ولازم اخليه بطريقة الديليت عن طريق الفنكشن ميثود-->
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-small btn-danger">delete</button>
                    </form>

                </td>



            </tr>
        @endforeach
    </tbody>

</table>

<div class="d-flex">

    <div class="">

        {{ $roles->links() }}
        <!-- تقسيم البجينيت على لنكات كل لنك ك صفحة -->
    </div>
    <div class="ml-auto">
        {{ $roles->total() }} Entries
        <!--ميثود على مستوى الباجينيشن-->

    </div>
</div>


@endsection
