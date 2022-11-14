@extends('layouts.backendapp')
@section('content')

<h2 class=" text-2xl mb-11">Add Product</h2>

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-6 mb-3">
            <input type="text" class="form-control" placeholder="Product Title" name="title">
        </div>
        <div class="col-lg-6 mb-3">
            <input type="text" class="form-control" placeholder="Product Slug" name="slug">
        </div>


        {{-- price --}}
        <div class="col-lg-6 mb-3">
            <input type="text" class="form-control" placeholder="Product Price" name="price">
        </div>

        <div class="col-lg-6 mb-3">
            <input type="text" class="form-control" placeholder="Discounted Price" name="discount_price">
        </div>





        {{-- price --}}

        {{-- category --}}

        <div class="col-lg-6 mb-3">
            <select name="category" class="form-control">
                <option disabled selected>Select A Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6 mb-3">
            <select name="subCategory" class="form-control">
                <option disabled selected>Select A Sub Category</option>
            </select>
        </div>


        {{-- category --}}



        <div class="col-lg-4 mb-3">
            <br>
            <select name="status" class="form-control">
                <option value="{{ true }}">In Stock</option>
                <option value="{{ false }}">Out Of Stock</option>
            </select>
        </div>
        <div class="col-lg-4 mb-3">
            <label for="">Discount Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>
        <div class="col-lg-4 mb-3">
            <label for="">Discount End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>







        {{-- product code --}}
        <div class="col-lg-4 mb-3">
            <input type="text" placeholder="Product Code" name="product_code" class="form-control">
        </div>
        <div class="col-lg-4 mb-3">
            <select name="brand" class="form-control">
                <option disabled selected>Select A Brand</option>
                @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-lg-12 mb-3">
            <textarea name="short_description" class="form-control" placeholder="Short Description"></textarea>
        </div>
        <div class="col-lg-12 mb-3">
            <textarea name="long_description" class="form-control" placeholder="Long Description"></textarea>
        </div>



        {{-- product image --}}
        <div class="col-lg-6 mb-3">
            <label for="">Product Thumbnail Image</label>
            <input type="file" name="thubnail_img" class="form-control">
        </div>
        <div class="col-lg-6 mb-3">
            <label for="">Product Gallery Images</label>
            <input type="file" multiple name="product_gallery_images[]" class="form-control">
        </div>
        <div class="col-lg-12 mb-3">
            <label for="">Product Youtube Video</label>
            <input type="text" name="video_url" class="form-control">
        </div>


    </div>

    <button type="submit" class="btn bg-blue-700 text-gray-50 w-full">Upload Product</button>
</form>

@push('customJs')

<script>
    let categorySelect = $('select[name="category"]')
    let subCategory = $('select[name="subCategory"]')
        categorySelect.on('change', function(){
           let id = $(this).val()
           let rawUrl = `{{ route('product.fetch.subcategory', ':id') }}`;
           let newUrl = rawUrl.replace(':id', id)
            $.ajax({
                url: newUrl,
                type:'GET',
                dataType: 'json',
                success: function(response) {
                console.table(response)
                    let options = [];
                    response.map(element => {
                       let option = `<option value="${element.id}">${element.title}</option>`
                       options.push(option)
                    })
                    subCategory.html('')
                    subCategory.html(options)
                },
                error: function(data){
                    let option = `<option selected disable>${data.responseText}</option>`
                    subCategory.html('')
                    subCategory.html(option)
                }
                

            })



        })


</script>


@endpush

@endsection