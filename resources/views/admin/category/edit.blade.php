<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Category') }}

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
           
           
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Category</div>
                    <div class="card-body">
                    <form action="{{url('category/update/'.$categories->id)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category Name</label>
                        <input type="text" value="{{$categories->category_name}}" name="category_name" class="form-control" id="exampleInputEmail1" aria-describedby="categoryHelp">
                        @error('category_name')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                        <small id="categoryHelp" class="form-text text-muted">Category Name.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Category</button>
                    </form>
                    </div>
                </div>
            </div>

          
            </div>
        </div>
    </div>
</x-app-layout>
