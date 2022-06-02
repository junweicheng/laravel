<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Brand') }}

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
           
            <div class="col-md-8">
                <div class="card">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('success')}}</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    @endif
                    <div class="card-header">All Brand</div>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Brand Image</th>
                            <th scope="col">Created At</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- @php($i=1) -->
                            @foreach($brands as $brand)
                            <tr>
                            <th scope="row">{{$brands->firstItem()+$loop->index}}</th>
                            <td>{{$brand->brand_name}}</td>
                            <td>{{$brand->brand_image}} <img style="height:40px;" src="{{asset($brand->brand_image)}}"></td>
                            <td>@if($brand->created_at == null)
                                <span class="text-danger">No date set</span>
                                @else
                                {{Carbon\Carbon::parse($brand->created_at)->diffForHumans()}}</td>
                                @endif
                            <td>
                                <a href="{{url('brand/edit/'.$brand->id)}}" class="btn btn-info">Edit</a>
                                <a href="{{url('softdelete/brand/'.$brand->id)}}" class="btn btn-danger">Delete</a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$brands->links()}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Add Brand</div>
                    <div class="card-body">
                    <form action="{{route('store.brand')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- without csrf token, it will not instert any data into db -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control" id="exampleInputEmail1" aria-describedby="categoryHelp">
                        @error('brand_name')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                        <small id="categoryHelp" class="form-text text-muted">Brand Name.</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Brand Image</label>
                        <input type="file" name="brand_image" class="form-control" id="exampleInputEmail1" aria-describedby="categoryHelp">
                        @error('brand_image')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                        <small id="categoryHelp" class="form-text text-muted">Brand Image.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Brand</button>
                    </form>
                    </div>
                </div>
            </div>

          
            </div>
        </div>
    </div>

    <!-- Trash Part -->

    <div class="py-12">
        <div class="container">
            <div class="row">
           
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Trash List</div>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Brand Image</th>
                            <th scope="col">Deleted At</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- @php($i=1) -->
                            @foreach($trashBrand as $brand)
                            <tr>
                            <th scope="row">{{$trashBrand->firstItem()+$loop->index}}</th>
                            <td>{{$brand->brand_name}}</td>
                            <td><img style="height:40px;" src="{{asset($brand->brand_image)}}"></td>
                            <td>@if($brand->created_at == null)
                                <span class="text-danger">No date set</span>
                                @else
                                {{Carbon\Carbon::parse($brand->deleted_at)->diffForHumans()}}</td>
                                @endif
                            <td>
                                <a href="{{url('brand/restore/'.$brand->id)}}" class="btn btn-info">Restore</a>
                                <a href="{{url('forcedelete/brand/'.$brand->id)}}" class="btn btn-danger">Delete</a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$trashBrand->links()}} 
                </div>
            </div>
            

          
            </div>
        </div>
    </div>

    <!-- End Trash -->

</x-app-layout>
