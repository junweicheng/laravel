<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Multi Pictures') }}

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
           
            <div class="col-md-8">
                <div class="card-group">
                    @foreach($images as $multi)
                    <div class="col-md-4 mt-5">
                        <div class="card">
                            <img src={{asset($multi->image)}}>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Multi Image</div>
                    <div class="card-body">
                    <form action="{{route('store.image')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- without csrf token, it will not instert any data into db -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Brand Image</label>
                        <input type="file" name="image[]" class="form-control" id="exampleInputEmail1" aria-describedby="categoryHelp" multiple="">
                        @error('image')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                        <small id="categoryHelp" class="form-text text-muted">Brand Image.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Image</button>
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
  
                </div>
            </div>
            

          
            </div>
        </div>
    </div>

    <!-- End Trash -->

</x-app-layout>
