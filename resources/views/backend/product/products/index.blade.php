@extends('backend.master')

@section('title', 'Products')
@section('breadcrumb', 'Products')

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-hover">
                    <div class="card-header bg-info">
                        <h4 class="text-white float-start">Products</h4>
{{--                        @can('create-permission-category')--}}
                            <a href="{{  route('products.create') }}" class="rounded-circle float-end text-white text-light f-s-20 ">
                                <span class="f-s-22 border-5"><i class="mdi mdi-plus-circle-outline"></i></span>
                            </a>
{{--                        @endcan--}}
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table responsive dt-responsive table-responsive"  id="dataTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Name</th>
                                    <th>price</th>
{{--                                    <th>Stock</th>--}}
                                    <th>Images</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $key => $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product?->category?->name ?? '' }}</td>
                                         <td>{{ $product->product_name ?? '' }}</td>
                                         <td>{{ $product->price ?? 0 }}</td>
{{--                                         <td>{{ $product->available_stock ?? 0 }} {{ $product->unit_name ?? '' }}</td>--}}
                                        <td>
                                            <div>
                                                Main Image: <img src="{{ asset($product->main_image) }}" alt="" style="height: 50px">
                                            </div>
                                            <div>
                                                Sub Images:
                                                @foreach(json_decode($product->sub_images) as $image)
                                                    <img src="{{ asset($image) }}" alt="" style="height: 40px; margin-right: 5px" />
                                                @endforeach
                                            </div>
                                        </td>

                                        <td>{!! str()->words(strip_tags($product->description), 30) ?? '' !!}</td>

                                        <td>{{ $product->status == 1 ? 'Published' : 'Unpublished' }}</td>
                                        <td class="">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary mt-1">
                                                <i class="mdi mdi-eye"></i>
                                            </a> <br>
                                            <a href="{{ route('products.edit', $product->id ) }}" class="btn btn-sm btn-warning mt-1">
                                                <i class="mdi mdi-square-edit-outline"></i>
                                            </a> <br>
                                            {{--                                        @endcan--}}
                                            {{--                                        @can('delete-permission-category')--}}
                                            <form class="d-inline" action="{{ route('products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger delete-data mt-1">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>
                                            {{--                                        @endcan--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/font-awesome.min.css">
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">--}}
@endpush

@push('script')

@include("backend.includes.asset.plugin-files.datatable")
{{--<link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">--}}
{{--<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>--}}
<script>
    // let table = new DataTable('#dataTable');
    // $('#dataTable').DataTable( {
    //     responsive: true
    // } );
</script>
@include("backend.includes.asset.plugin-files.sweet-alert-2")


@endpush
