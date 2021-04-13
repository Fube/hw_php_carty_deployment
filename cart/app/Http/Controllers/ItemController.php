<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class ItemController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function addItem(Request $request, $id) {

        if(!Session::get('items')) {
            Session::put('items', [
                $id => 1
            ]);
        }
        else {

            $items = Session::get('items');

            if(isset($items[$id])) $items[$id]++;
            else $items[$id] = 1;

            Session::put('items', $items);
        }

        Session::save();
    
        response()->json(['success' => 'success'], 200);
    }

    public function deleteItem(Request $request, $id) {

        $items = Session::get('items');

        if(!$items) {
            return response()->json(['success' => 'No items. No change'], 200);
        }

        if(!isset($items[$id])) {

            return response()->json(['success' => 'No item. No change'], 200);
        }

        unset($items[$id]);

        Session::put('items', $items);
        Session::save();

        return response()->json(['success' => 'success'], 200);
    }

    public function decrementItem(Request $request, $id) {

        $items = Session::get('items');

        if(!$items) {
            
            return response()->json(['success' => 'No items. No change'], 200);
        }

        if($items) {

            if(!isset($items[$id])) {
                return response()->json(['success' => 'Item not set. No change'], 200);
            }

            $items[$id]--;

            if($items[$id] == 0) {

                unset($items[$id]);
            }

            Session::put('items', $items);
        }

        Session::save();

        response()->json(['success' => 'success'], 200);
    }
}
