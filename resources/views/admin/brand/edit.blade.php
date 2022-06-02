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
                    <div class="card-header">Edit Brand</div>
                    <div class="card-body">
                    <form action="{{url('brand/update/'.$brand->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="old_image" value="{{$brand->brand_image}}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Brand Name</label>
                        <input type="text" value="{{$brand->brand_name}}" name="brand_name" class="form-control" id="exampleInputEmail1" aria-describedby="brandHelp">
                        @error('brand_name')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                        <small id="brandHelp" class="form-text text-muted">Brand Name.</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Brand Image</label>
                        <input type="file" name="brand_image" class="form-control" id="exampleInputEmail1" aria-describedby="brandHelp">
                        @error('brand_image')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                        <small id="brandHelp" class="form-text text-muted">Brand Name.</small>
                    </div>

                    <div class="form-group">
                        <img style="height:40px;" src="{{asset($brand->brand_image)}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Brand</button>
                    </form>
                    </div>
                </div>
            </div>

          
            </div>
        </div>
    </div>
</x-app-layout>
