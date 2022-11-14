@extends('layouts.backendapp')

@section('content')
<h2 class="text-2xl font-medium ">Category Management</h2>


<div class="row">
    <div class="col-lg-8">
        <table class="table table-responsive text-center">
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Category Image</th>
                <th>Actions</th>
            </tr>

            @forelse ($categories as $key=>$category)
            <tr>
                <td>
                    {{ ++$key }}
                </td>
                <td>
                    {{ $category->title }}
                </td>
                <td>
                    @if (!$category->image_url)
                    <img src="{{ asset('storage/placeholderImage.png') }}" alt="" class=" w-40">
                    @else
                    <img src="{{ $category->image_url }}" alt="{{ $category->title }}" class="w-40">
                    @endif

                </td>
                <td>
                    <a href="{{ route('category.edit', $category->slug) }}" class="btn btn-primary btn-sm">edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No Category Found</td>
            </tr>

            @endforelse




        </table>
    </div>
    <div class="col-lg-4">

        @if (isset($editedCategory))
        <div class="card shadow rounded p-3">
            <form action="{{ route('category.update', $editedCategory->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h4 class="mb-2">Edit Category</h4>
                <input type="text" class="form-control" placeholder="category Name" name="title"
                    value="{{ $editedCategory->title }}">
                @error('title')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="text" class="form-control my-3" placeholder="category Slug" name="slug"
                    value="{{ $editedCategory->slug }}">
                @error('slug')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="file" class="form-control my-3" name="categoryImage">
                @error('categoryImage')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <button class="w-full btn btn-primary">Update Category</button>
            </form>
        </div>
        @else
        <div class="card shadow rounded p-3">
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="mb-2">Add New Category</h4>
                <input type="text" class="form-control" placeholder="category Name" name="title">
                @error('title')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="text" class="form-control my-3" placeholder="category Slug" name="slug">
                @error('slug')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="file" class="form-control my-3" name="categoryImage">
                @error('categoryImage')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <button class="w-full btn btn-primary">Upload Category</button>
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