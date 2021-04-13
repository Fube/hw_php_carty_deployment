@extends('layouts.app')

@section('content')
    <div class="flex justify-center">

        <div class="flex flex-col">
            @foreach ($items as $item)
                <div class="block border-2 border-black p-2 w-64 rounded-lg my-2 flex justify-center">
                    <ul>
                        <li class="my-2">Name: {{ $item->name }}</li>
                        <li class="my-2">Price: {{ $item->price }}</li>
                        <li class="my-2">Stock: {{ $item->stock }}</li>
                        <li class="my-2">Image: <img class="inline" src="data:image/png;base64, {{ $item->image }}" alt="{{ $item->name }}" width="125"></li>
                        <li class="flex justify-around">
                            <a href="{{ route('admin/update/id', $item->id) }}"><button type="submit" class="bg-yellow-500 p-1 rounded">Edit</button></a>
                            <form action="{{ route('admin/delete/id', $item->id) }}" method="post">
                                @csrf
                                <button type="submit" class="bg-red-500 p-1 rounded">Delete</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endforeach

            <div class="mt-5">
                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection