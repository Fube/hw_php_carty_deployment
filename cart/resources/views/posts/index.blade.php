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
                    <li class="my-2 bg-green-500 w-24 rounded p-1 text-center mx-auto">
                        <button item-id={{ $item->id }} onclick="addItemToCart(event)">Add to Cart</button>
                    </li>
                </ul>
            </div>
        @endforeach

        <div class="mt-5">
            {{ $items->links() }}
        </div>
    </div>
</div>

<script defer>

    function addItemToCart({ target: { attributes: { 'item-id': { value:itemID } } } }) {

        axios.post(`/item/${itemID}`);
    }

</script>
@endsection