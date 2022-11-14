@extends('layouts.backendapp')

@section('content')
<h2 class="text-2xl font-medium ">Brand Management</h2>


<div class="row">
    <div class="col-lg-8">
        <table class="table table-responsive text-center">
            <tr>
                <th>#</th>
                <th>Brand Name</th>
                <th>Brand Image</th>
                <th>Actions</th>
            </tr>

            @forelse ($brands as $key=>$brand)
            <tr>
                <td>{{ ++$key }}</td>
                <td>
                    {{ $brand->title }}
                </td>
                <td>
                    <img style="max-width: 100px;object-fit:cover;" src="{{ $brand->image_uri }}"
                        alt="{{ $brand->title }}">
                </td>
                <td>
                    <a href="{{ route('brand.edit', $brand->slug) }}" class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger brandDeleteBtn">Delete</a>
                    <form action="{{ route('brand.delete', $brand->slug) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No Brand Found !</td>
            </tr>
            @endforelse


        </table>
    </div>
    <div class="col-lg-4">
        @if (!isset($editedBrand))


        <div class="card shadow rounded p-3">
            <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h4 class="mb-2">Add New Brand</h4>
                <input type="text" class="form-control" placeholder="Brand Name" name="title">
                @error('title')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="text" class="form-control my-3" placeholder="Brand Slug" name="slug">
                @error('slug')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="file" class="form-control my-3" name="brandImage">
                @error('brandImage')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <button class="w-full btn btn-primary">Upload Brand</button>
            </form>
        </div>
        @else

        <div class="card shadow rounded p-3">
            <form action="{{ route('brand.update', $editedBrand->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h4 class="mb-2">Edit Brand</h4>
                <input type="text" class="form-control" placeholder="Brand Name" name="title"
                    value="{{ $editedBrand->title }}">
                @error('title')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <input type="text" value="{{ $editedBrand->title }}" class="form-control my-3" placeholder="Brand Slug"
                    name="slug">
                @error('slug')
                <span class="text-red-500">{{ $message }}</span>
                @enderror

                <input type="file" class="form-control my-3" name="brandImage">
                @error('brandImage')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
                <button class="w-full btn btn-primary">Update Brand</button>
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