<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counts = $this->getCounts();

        //dd($counts);
        return inertia('DashboardPage', [
            'counts' => $counts,
            'salesByCurrencyData' => $this->getSalesByCurrencyData(),
            'salesByItemData' => $this->getSalesByItemData(),
            'recentTransactions' => [
                ['id' => 1, 'transaction_id' => 'TX1234', 'amount' => 100],
                ['id' => 2, 'transaction_id' => 'TX1235', 'amount' => 150]
            ]
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

    public function getCounts()
    {
        $salesData = Sale::select('currency', 'type', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('currency', 'type')
            ->get();

        // Initialize counts array
        $counts = [];

        // Loop through the results and populate the counts array
        foreach ($salesData as $sale) {
            $currency = $sale->currency;
            $type = $sale->type;

            if (!isset($counts[$currency])) {
                $counts[$currency] = ['total' => 0];
            }

            // Store the amount for each type
            $counts[$currency][$type] = $sale->total_amount;

            // Update the total amount for the currency
            $counts[$currency]['total'] = ($counts[$currency]['total'] ?? 0) + $sale->total_amount;
        }

        //dd($counts);
        return $counts;
    }

    public function getSalesByCurrencyData()
    {
        $salesData = Sale::select('epos.sales.currency', DB::raw('SUM(epos.sales.amount) as total'))
            ->groupBy('epos.sales.currency')
            ->get();

        $labels = [];
        $data = [];
        $backgroundColors = [];
        $borderColors = [];

        $colorPalette = [
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
        ];
        $borderPalette = [
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
        ];

        foreach ($salesData as $index => $sale) {
            $labels[] = $sale->currency;
            $data[] = $sale->total;

            $backgroundColors[] = $colorPalette[$index % count($colorPalette)];
            $borderColors[] = $borderPalette[$index % count($borderPalette)];
        }

        $salesByCurrencyData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Sales by Currency',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 1
                ]
            ]
        ];

        return $salesByCurrencyData;
    }

    public function getSalesByItemData()
    {
        // Fetch sales data grouped by item
        $salesData = SaleItem::select('epos.sale_items.item_id', DB::raw('SUM(epos.sale_items.total_price) as total'))
            ->groupBy('epos.sale_items.item_id')
            ->with('item')
            ->get();

        // Initialize labels and data arrays
        $labels = [];
        $data = [];
        $backgroundColors = [];
        $borderColors = [];

        // Define color arrays
        $colorPalette = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
        ];
        $borderPalette = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
        ];


        foreach ($salesData as $index => $sale) {
            //dd($sale->item->name);
            $labels[] = $sale->item ? $sale->item->name : 'N/A';
            $data[] = $sale->total;

            // Assign colors based on index, cycling through the color palettes
            $backgroundColors[] = $colorPalette[$index % count($colorPalette)];
            $borderColors[] = $borderPalette[$index % count($borderPalette)];
        }

        // Prepare the salesByItemData array
        $salesByItemData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Sales by Item',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 1
                ]
            ]
        ];

        return $salesByItemData;
    }
}
