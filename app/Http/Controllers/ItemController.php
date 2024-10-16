<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SaleItem;
use Exception;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $items = Item::paginate(15);
        if(isset($search))
        {
            $items = Item::where('name', 'LIKE', '%'.$search.'%')->paginate(15);
        }
        return inertia('ItemsPage',[
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Items/CreateItemPage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.Item::class],
            'price' => ['required', 'numeric', 'min:0.01'],
        ]);


        try{

            $item = new Item();
            $item->name = $request->name;
            $item->price = $request->price;
            $item->save();

            //dd("here");

            return back()->withErrors(['success' => 'Item created successfully.']);
        }catch(Exception $e){
            return back()->withErrors(['error' => 'Exception error']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::find($id);

        $salesData = [
            'totalSales' => SaleItem::where('item_id', $id)->sum('qty'),
            'totalRevenue' => SaleItem::where('item_id', $id)->sum('total_price'),
            'history' => SaleItem::join('epos.sales', 'epos.sales.id', '=', 'sale_items.sale_id')
            ->select('sale_items.id', 'sale_items.qty as quantity', 'sale_items.total_price as revenue', 'epos.sales.created_at as date')
            ->where('sale_items.item_id', $id)
            ->paginate(10)
        ];
        return inertia('Items/ShowItemPage',[
            'item' => $item,
            'salesData' => $salesData
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
        ]);


        try{

            $item = Item::find($id);
            $item->name = $request->name;
            $item->price = $request->price;
            $item->save();

            //dd("here");

            return back()->withErrors(['success' => 'Item updated successfully.']);
        }catch(Exception $e){
            return back()->withErrors(['error' => 'Exception error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $item = Item::find($id);
            $item->delete();
            return back()->withErrors(['success' => 'Item deleted successfully.']);
        }catch(Exception $e){
            return back()->withErrors(['error' => 'Exception error']);
        }
    }
}
