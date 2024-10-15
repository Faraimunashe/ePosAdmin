<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleCash;
use App\Models\SaleChange;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Validator;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            //sleep(30);
            $rules = [
                "amount" => ["required","numeric", 'min:0'],
                "type" => ["required","string","in:CASH,EFT"],
                "currency" => ["required","string","max:3", "min:3"],
                'items' => ['required', 'array', 'min:1'],
                'items.*.item_id' => ['required', 'integer', 'exists:'.SaleItem::class.',id'],
                'items.*.qty' => ['required', 'integer', 'min:1'],
                'items.*.price' => ['required', 'numeric', 'min:0'],
                'items.*.total_price' => ['required', 'numeric', 'min:0'],
                'change' => ['required', 'numeric', 'min:0'],
                'cash' => ['required', 'numeric', 'min:0'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails())
            {
                $errors = $validator->errors();
                $response = [
                    'message' => 'Validation error',
                    'errors' => $errors->all()
                ];

                return response()->json($response, 400);
            }

            $reference = $this->generate_sale_reference();

            $sale = new Sale();
            $sale->user_id = Auth::id();
            $sale->amount = $request->amount;
            $sale->type = $request->type;
            $sale->currency = $request->currency;
            $sale->reference = $reference;
            $sale->created_at = now();
            $sale->save();

            foreach ($request->items as $item) {
                $sale_item = new SaleItem();
                $sale_item->sale_id = $sale->id;
                $sale_item->item_id = $item['item_id'];
                $sale_item->qty = $item['qty'];
                $sale_item->unit_price = $item['price'];
                $sale_item->total_price = $item['total_price'];

                $sale_item->save();
            }

            $sale_change = new SaleChange();
            $sale_change->sale_id = $sale->id;
            $sale_change->amount = $request->change;
            $sale_change->save();

            $sale_cash = new SaleCash();
            $sale_cash->sale_id = $sale->id;
            $sale_cash->amount = $request->cash;
            $sale_cash->save();

            $response = [
                'message' => 'Successfully added new sale',
                'sale' => $sale,
                'items' => $request->items,
                'change' => $request->change,
                'cash' => $request->cash
            ];

            return response()->json($response, 200);
        }catch (\Exception $e){
            return response()->json(['message'=> $e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generate_sale_reference()
    {
        $date = now()->format('YmdHis');

        $last_sale = Sale::latest('id')->first();
        $next_sale_number = $last_sale ? $last_sale->id + 1 : 1;

        $sale_number = str_pad($next_sale_number, 6, '0', STR_PAD_LEFT);

        $random_string = Str::upper(Str::random(3));

        $user_id = Auth::id();

        $sale_reference = "{$date}-{$sale_number}{$random_string}{$user_id}";

        return $sale_reference;
    }
}
