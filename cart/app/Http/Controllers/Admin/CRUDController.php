<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class CRUDController extends Controller
{

    public function __construct() {
        
        $this->middleware(['admin']);
    }

    public function index() {
        
        return view('admin.index');
    }
    
    public function getInsert() {
        
        return view('admin.insert');
    }

    public function postInsert(Request $request) {
        
        $this->validate($request, [

            'name' => 'required'
            ,'price' => ['required','regex:/^[1-9]{1,}[0-9]*/','not_in:0']
            ,'stock' => ['required','regex:/^[1-9]{1,}[0-9]*/','not_in:0']
            ,'image' => 'required|image|max:16000' // 64kb max
        ]);

        $item = Item::create($request->only('name', 'price', 'stock', 'image'));

        $path = $request->file('image')->getRealPath();
        $logo = file_get_contents($path);
        $base64 = base64_encode($logo);
        $item->image = $base64;
        $item->save();
        // Copied from SO

        return redirect()->route('admin/insert');
    }

    public function getUpdate() {
        
        return view('admin.update', [
            'items' => $this->paginate(),
        ]);
    }

    public function getFilledUpdate($id) {

        return view('admin.filledUpdate', [

            'item' => DB::table('items')->where('id', $id)->first(),
        ]);
    }

    public function postUpdate(Request $request, $id) {

        if($request->hasFile('image')){

            $path = $request->file('image')->getRealPath();
            $logo = file_get_contents($path);
            $base64 = base64_encode($logo);
            DB::table('items')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $base64,
            ]);
        }
        else{

            DB::table('items')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);
        }
        
        return redirect()->route('admin/update');
    }

    public function postDelete(Request $request, $id) {
        
        DB::table('items')->delete($id);

        return redirect()->route('admin/update');
    }

    private function paginate($units=15) {

        return DB::table('items')->paginate($units);
    }
}
