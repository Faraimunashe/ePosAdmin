<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counts = [
            'usd' => [
                'total' => Sale::where('currency', 'USD')->sum('amount'),
                'card' => Sale::where('currency', 'USD')->where('type', 'EFT')->sum('amount'),
                'cash' => Sale::where('currency', 'USD')->where('type', 'CASH')->sum('amount'),
            ],
            'zwg' => [
                'total' => Sale::where('currency', 'ZWG')->sum('amount'),
                'card' => Sale::where('currency', 'ZWG')->where('type', 'EFT')->sum('amount'),
                'cash' => Sale::where('currency', 'ZWG')->where('type', 'CASH')->sum('amount'),
            ],
        ];

        //dd($counts);
        return inertia('DashboardPage', [
            'counts' => $counts,
            'salesByCurrencyData' => [
                'labels' => ['USD', 'EUR', 'GBP'],
                'datasets' => [
                    [
                        'label' => 'Sales by Currency',
                        'data' => [500, 300, 200],
                        'backgroundColor' => ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                        'borderColor' => ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
                        'borderWidth' => 1
                    ]
                ]
            ],
            'salesByItemData' => [
                'labels' => ['Item A', 'Item B', 'Item C'],
                'datasets' => [
                    [
                        'label' => 'Sales by Item',
                        'data' => [150, 200, 50],
                        'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                        'borderColor' => ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                        'borderWidth' => 1
                    ]
                ]
            ],
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
}
