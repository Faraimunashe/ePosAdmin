<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use App\Models\PosUser;
use App\Models\Sale;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CashierReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$search = $request->search;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $currency = $request->currency;
        $type = $request->type;
        $cashier = $request->cashier;

        $salesQuery = Sale::with("items.item")->join("epos.users", "epos.users.id", "=", "epos.sales.user_id")
            ->select("epos.sales.id", "epos.sales.amount", "epos.sales.reference", "epos.sales.type", "epos.sales.created_at", "epos.users.name", "epos.sales.currency");

        $totalsQuery = DB::table('epos.sales')
            ->join("epos.users", "epos.users.id", "=", "epos.sales.user_id")
            ->select(DB::raw('SUM(amount) as total_amount'), 'currency');

        // if (isset($search) && $search !== '') {
        //     $salesQuery->where("epos.sales.reference", "LIKE", "%" . $search . "%");
        // }

        // Date filters
        if (isset($start_date) && $start_date !== '') {
            $salesQuery->where("epos.sales.created_at", ">=", $start_date);
            $totalsQuery->where("epos.sales.created_at", ">=", $start_date);
        }

        if (isset($end_date) && $end_date !== '') {
            $salesQuery->where("epos.sales.created_at", "<=", $end_date);
            $totalsQuery->where("epos.sales.created_at", "<=", $end_date);
        }

        // Currency filter
        if (isset($currency) && $currency !== '') {
            $salesQuery->where("epos.sales.currency", "=", $currency);
            $totalsQuery->where("epos.sales.currency", "=", $currency);
        }

        // Type filter
        if (isset($type) && $type !== '') {
            $salesQuery->where("epos.sales.type", "=", $type);
            $totalsQuery->where("epos.sales.type", "=", $type);
        }

        if (isset($cashier) && $cashier !== '') {
            $salesQuery->where("epos.users.id", "=", $cashier);
            $totalsQuery->where("epos.users.id", "=", $cashier);
        }


        $sales = $salesQuery->paginate(30);
        $currencies = CurrencyRate::where("active", 1)->get();
        $types = Sale::select('type')->groupBy('type')->get();
        $cashiers = PosUser::all();

        $totals = $totalsQuery->groupBy('currency')
        ->get();

        return inertia("CashierSalesPage", [
            "sales" => $sales,
            "currencies"=> $currencies,
            "trans_types"=> $types,
            'cashiers' => $cashiers,
            "totals" => $totals
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

    public function exportPdf(Request $request)
    {
        //dd("We are here!");
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $currency = $request->currency;
        $type = $request->type;
        $cashier = $request->cashier;

        $salesQuery = Sale::with("items.item")->join("epos.users", "epos.users.id", "=", "epos.sales.user_id")
            ->select("epos.sales.id", "epos.sales.amount", "epos.sales.reference", "epos.sales.type", "epos.sales.created_at", "epos.users.name", "epos.sales.currency");

        $totalsQuery = DB::table('epos.sales')
            ->join("epos.users", "epos.users.id", "=", "epos.sales.user_id")
            ->select(DB::raw('SUM(amount) as total_amount'), 'currency');

        // if (isset($search) && $search !== '') {
        //     $salesQuery->where("epos.sales.reference", "LIKE", "%" . $search . "%");
        // }

        // Date filters
        if (isset($start_date) && $start_date !== '') {
            $salesQuery->where("epos.sales.created_at", ">=", $start_date);
            $totalsQuery->where("epos.sales.created_at", ">=", $start_date);
        }

        if (isset($end_date) && $end_date !== '') {
            $salesQuery->where("epos.sales.created_at", "<=", $end_date);
            $totalsQuery->where("epos.sales.created_at", "<=", $end_date);
        }

        // Currency filter
        if (isset($currency) && $currency !== '') {
            $salesQuery->where("epos.sales.currency", "=", $currency);
            $totalsQuery->where("epos.sales.currency", "=", $currency);
        }

        // Type filter
        if (isset($type) && $type !== '') {
            $salesQuery->where("epos.sales.type", "=", $type);
            $totalsQuery->where("epos.sales.type", "=", $type);
        }

        if (isset($cashier) && $cashier !== '') {
            $salesQuery->where("epos.users.id", "=", $cashier);
            $totalsQuery->where("epos.users.id", "=", $cashier);
        }


        $sales = $salesQuery->get();

        $totals = $totalsQuery->groupBy('currency')
        ->get();


        $pdf = Pdf::loadView('pdf.sales', [
            'sales' => $sales,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'generated_by' => auth()->user()->name,
            'totals' => $totals
        ]);

        return $pdf->download('sales_report.pdf');
    }
}
