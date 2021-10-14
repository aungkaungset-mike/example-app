<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Multi Picture<b></b>
            <b style = "float:right;">
            
            <span class="badge bg-danger"></span>           
            </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
              <div class="col-md-8">
              <div class="card-group">
                
                @foreach ($images as $img)
                    
                <div class="col-md-4 mt-5 p-2">
                  <div class="card">
                    <img src="{{ asset($img->image) }}" alt="">
                  </div>
                </div>

                @endforeach

              </div>
      </div>
        <div class="col-md-4">
          <div class="card">
             <div class="card-header">
                Multi Picture
            </div> 
            <div class="card-body">
            <form action = "{{ route('store_image') }}" method = "POST" enctype="multipart/form-data">
              @csrf

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Image</label>
    <input type="file" name = "image[]" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" multiple= "">

      @error('image')
        <span class = "text-danger">{{ $message }}</span>
      @enderror

  </div>
  
  <button type="submit" class="btn btn-primary">Add Image</button>
  </form>   
            </div>     
          </div>
        </div>
            </div>
        </div>

</x-app-layout>
