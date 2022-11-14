@extends('layouts.backendapp')

@section('content')
<h2 class="text-2xl font-medium ">Sub-Category Management</h2>


<div class="row">
    <div class="col-lg-8">
        <table class="table table-responsive text-center">
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Sub-Category Name</th>
                <th>Sub-Category Image</th>
                <th>Actions</th>
            </tr>

            @forelse ($subCategories as $key=>$subCategory)

            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $subCategory->category->title }}</td>
                <td>{{ $subCategory->title }}</td>
                <td>
                    @if ($subCategory->image != null)
                    <img class=" w-40" src="{{ $subCategory->image_url }}" alt="{{ $subCategory->slug }}">
                    @else
                    <img class=" w-40" src="{{ asset('storage/placeholderImage.png') }}" alt="{{ $subCategory->slug }}">
                    @endif
                </td>
                <td>
                    <a href="{{ route('subcategory.edit' , $subCategory->slug) }}">edit</a>
                </td>
            </tr>

            @empty

            @endforelse





        </table>
    </div>
    <div class="col-lg-4">

        @if (isset($editedSubCategory))

        <div class="card shadow rounded p-3">
            <form action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="mb-2">Edit Sub-Category</h4>
                <input type="text" class="form-control" placeholder="Sub Category Name" name="title" value="{{ $editedSubCategory->title }}">
                @error('title')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input value="{{ $editedSubCategory->slug }}" type="text" class="form-control my-3" placeholder="Sub Category Slug" name="slug">
                @error('slug')
                <span class="text-red-500">{{ $message }}</span>
                @enderror

                <select name="parent_category" id="" class="form-control">
                    <option selected disabled>Select A parent Category</option>
                    @foreach ($categories as $category)
                    <option @selected($editedSubCategory->category_id == $category->id) value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>

                <input type="file" class="form-control my-3" name="subCategoryImage">
                @error('subCategoryImage')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <button class="w-full btn btn-primary">Upload Sub-Category</button>
            </form>
        </div>

        @else
        <div class="card shadow rounded p-3">
            <form action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="mb-2">Add New Sub-Category</h4>
                <input type="text" class="form-control" placeholder="Sub Category Name" name="title">
                @error('title')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="text" class="form-control my-3" placeholder="Sub Category Slug" name="slug">
                @error('slug')
                <span class="text-red-500">{{ $message }}</span>
                @enderror

                <select name="parent_category" id="" class="form-control">
                    <option selected disabled>Select A parent Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>

                <input type="file" class="form-control my-3" name="subCategoryImage">
                @error('subCategoryImage')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <button class="w-full btn btn-primary">Upload Sub-Category</button>
            </form>
        </div>


        @endif








    </div>
</div>


@push('customJs')
<script>
    let title = $('input[name="title"]')
    let slug = $('input[name="slug"]')
    title.keyup(function(){
        let value = $(this).val().toLowerCase().split(' ').join('-')
        
        slug.val(value)
    })


    //*Sweet Alert 2
    $('.brandDeleteBtn').on('click', function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $(this).next('form').submit()
            }
            })
    })





</script>
@endpush


@endsection