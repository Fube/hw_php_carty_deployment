@extends('layouts.app')

@section('content')

    <div class="flex justify-center">

        <div class="flex flex-col">

            @if (isset($items) && sizeof($items) > 0)
                @foreach ($items as $item)
                    <div class="item block border-2 border-black p-2 w-64 rounded-lg my-2 flex justify-center self-center" item-id={{ $item->id }}>
                        <ul>
                            <li class="my-2 name">Name: {{ $item->name }}</li>
                            <li class="my-2 price">Price: {{ $item->price }}</li>
                            <li class="my-2 stock">Stock: {{ $item->stock }}</li>
                            <li class="my-2 quantity">Quantity: {{ $item->quantity }}</li>
                            <li class="my-2 image">Image: <img class="inline" src="data:image/png;base64, {{ $item->image }}" alt="{{ $item->name }}" width="125"></li>
                            <li class="flex justify-around">
                                <button class="bg-yellow-500 p-1 rounded" item-id={{ $item->id }} onclick="decrementItem(event)">Decrement</button>
                                <button class="bg-red-500 p-1 rounded" item-id={{ $item->id }} onclick="deleteItem(event)">Delete</button>
                            </li>
                        </ul>
                    </div>
                @endforeach

                <div class="border-t border-black w-96 mt-2"></div>
                <div id="total" class="mt-6 text-3xl text-center">Total Price: ${{ $total }}</div>
            @else
                <div class="text-3xl">No items in cart</div>
            @endif
        </div>
    </div>

    <script>

        const total = document.querySelector`#total`;

        // Updates quantities and price
        function updateView(target, reason) {
            if(typeof target !== 'number' && reason !== 'delete') return;

            const items = document.querySelectorAll`div[item-id]`;
            let total = 0;
            
            for(const item of items) {

                const itemID = Number(item.attributes['item-id'].value);
                const price = Number(item.querySelector`.price`.textContent.replace(/\D/g, ''));

                let quantity = Number(item.querySelector`.quantity`.textContent.replace(/\D/g, ''));

                if(itemID !== target) {

                    total += quantity * price;
                    continue;
                }

                quantity--;

                console.log(quantity)
                
                if(quantity <= 0) {

                    item.remove();
                    continue; // No need to update price
                }
                else 
                    item.querySelector`.quantity`.textContent = `Quantity: ${quantity}`;

                total += quantity * price;
            }

            globalThis.total.textContent = `Total Price: $${total}`;
        }

        async function decrementItem({ target: { attributes: { 'item-id': { value:itemID } } } }) {
            
            await axios.put(`item/${itemID}`);
            updateView(+itemID, 'decrement');
        }

        async function deleteItem({ target: { attributes: { 'item-id': { value:itemID } } } }) {

            await axios.delete(`/item/${itemID}`);

            document.querySelector(`div[item-id="${itemID}"]`).remove();

            updateView(null, 'delete');
        }

    </script>
@endsection