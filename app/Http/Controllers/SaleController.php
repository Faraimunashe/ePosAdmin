<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use App\Models\PosUser;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $currency = $request->currency;
        $type = $request->type;
        $cashier = $request->cashier;

        $salesQuery = Sale::join("epos.users", "epos.users.id", "=", "epos.sales.user_id")
            ->select("epos.sales.id", "epos.sales.amount", "epos.sales.reference", "epos.sales.type", "epos.sales.created_at", "epos.users.name", "epos.sales.currency");

        // Search filter
        if (isset($search) && $search !== '') {
            $salesQuery->where("epos.sales.reference", "LIKE", "%" . $search . "%");
        }

        // Date filters
        if (isset($start_date) && $start_date !== '') {
            $salesQuery->where("epos.sales.created_at", ">=", $start_date);
        }

        if (isset($end_date) && $end_date !== '') {
            $salesQuery->where("epos.sales.created_at", "<=", $end_date);
        }

        // Currency filter
        if (isset($currency) && $currency !== '') {
            $salesQuery->where("epos.sales.currency", "=", $currency);
        }

        // Type filter
        if (isset($type) && $type !== '') {
            $salesQuery->where("epos.sales.type", "=", $type);
        }

        if (isset($cashier) && $cashier !== '') {
            $salesQuery->where("epos.users.id", "=", $cashier);
        }

        // Pagination
        $sales = $salesQuery->paginate(15);
        $currencies = CurrencyRate::where("active", 1)->get();
        $types = Sale::select('type')->groupBy('type')->get();
        $cashiers = PosUser::all();

        return inertia("SalesPage", [
            "sales" => $sales,
            "currencies"=> $currencies,
            "trans_types"=> $types,
            'cashiers' => $cashiers
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::find($id);
        if(is_null($sale)){
            return redirect()->back()->withErrors(["error" => "Sale was not found."]);
        }

        $sale_items = SaleItem::join("epos.items","epos.items.id","=","sale_items.id")
            ->select("sale_items.id", "sale_items.qty", "sale_items.unit_price", "sale_items.total_price", "epos.items.name")
            ->where("sale_items.sale_id","=", $sale->id)
            ->get();

        //dd($sale, $sale_items);

        return inertia("sales/ShowSalePage", [
            "sale"=> $sale,
            "sale_items"=> $sale_items
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
