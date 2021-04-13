@extends('layouts.app')

@section('content')
    <div class="flex justify-center">

        <div class="flex flex-column">
            <form action="{{ route('admin/update/id', $item->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <label class="block my-2 w-3/12" for="name">Name:
                    <input value="{{ old('name') ?? $item->name }}" type="text" name="name" id="name" placeholder="Item name" class="my-3 bg-gray-100 border-2 p-4 rounded-lg
                        @error('name')
                            border-red-500    
                        @enderror
                    ">
                    @error('name')
                        <div class="text-red-500 mt-2 text-sm w-80">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="block my-2 w-3/12" for="price">Price:
                    <input value="{{ old('price') ?? $item->price }}" type="number" name="price" id="price" placeholder="Price" class="my-3 bg-gray-100 border-2 p-4 rounded-lg
                        @error('price')
                            border-red-500    
                        @enderror
                    ">
                    @error('price')
                        <div class="text-red-500 mt-2 text-sm w-80">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="block my-2 w-3/12" for="stock">Stock:
                    <input value="{{ old('stock') ?? $item->stock }}" type="number" name="stock" id="stock" placeholder="Stock" class="my-3 bg-gray-100 border-2 p-4 rounded-lg
                        @error('stock')
                            border-red-500    
                        @enderror
                    ">
                    @error('stock')
                        <div class="text-red-500 mt-2 text-sm w-80">
                            {{ $message }}
                        </div>
                    @enderror
                </label>
                <label class="block my-2 w-3/12" for="image">Image:
                    <img class="inline" src="data:image/png;base64, {{ $item->image }}" alt="{{ $item->name }}" width="125">
                    <input value="{{ old('image') }}" type="file" name="image" id="image" class="my-3 bg-transparent border-2 rounded-lg
                        @error('image')
                            border-red-500        
                        @enderror
                    ">
                    @error('image')
                        <div class="text-red-500 mt-2 text-sm w-80">
                            {{ $message }}
                        </div>
                    @enderror
                </label>

                <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-8/12">Update Item</button>
            </form>
        </div>

    </div>

    <script defer>

        const preloadedImage = document.querySelector`img`;
        const image = document.querySelector`#image`;

        if(image.value) {

            preloadedImage.style.display = 'none';
        }

        image.addEventListener('change', ({ currentTarget: { value } }) => {

            if(value) {

                preloadedImage.style.display = 'none';
            }
        });

    </script>
@endsection