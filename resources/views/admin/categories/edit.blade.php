@extends('layouts.admin')

@section('title')
    Edit category
@endsection

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"> Categories</li>
        <li class="breadcrumb-item active"> edit</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('categories.update', ['id' => $category02->id]) }}" method="post" enctype="multipart/form-data" > <!--الانكتايب لازم ينضاف باي فورم حيتم تسليم فيه ملفات -->
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
            <label for="">{{__('Category Name')}}</label>
            <input type="text" class="form-control" name="name" value="{{ $category02->name }}">
        </div>

        <div class="form-group">
            <label for="">{{__('Parent')}}</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">No Parent</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @if ($parent->id == $category02->parent_id) selected @endif>
                        {{ $parent->name }}</option>
                @endforeach
            </select>

        </div>


        <div class="form-group">
            <label for="">{{__('Description')}}</label>
            <textarea class="form-control" name="description">{{ $category02->description }}</textarea>
        </div>


        <div class="form-group">
            <label for="">{{__('Image')}}</label>
            <input type="file" class="form-control" name="image">
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-primary">save</button>
        </div>

        <div class="form-group">
            <label for="status">{{__('Status')}}</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-active" value="status" @if($category02->status=='active') checked @endif>
                <label class="form-check-label" for="flexRadioDefault1">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft"  @if($category02->status=='draft') checked @endif>
                <label class="form-check-label" for="flexRadioDefault2">
                    Draft
                </label>
            </div>

        </div>


    </form>
@endsection
