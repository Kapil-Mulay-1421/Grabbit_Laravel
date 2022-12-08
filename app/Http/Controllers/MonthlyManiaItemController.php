<?php

namespace App\Http\Controllers;

use App\Models\MonthlyManiaItem;
use App\Http\Requests\StoreMonthlyManiaItemRequest;
use App\Http\Requests\UpdateMonthlyManiaItemRequest;

class MonthlyManiaItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMonthlyManiaItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonthlyManiaItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonthlyManiaItem  $monthlyManiaItem
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyManiaItem $monthlyManiaItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonthlyManiaItem  $monthlyManiaItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MonthlyManiaItem $monthlyManiaItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMonthlyManiaItemRequest  $request
     * @param  \App\Models\MonthlyManiaItem  $monthlyManiaItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMonthlyManiaItemRequest $request, MonthlyManiaItem $monthlyManiaItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonthlyManiaItem  $monthlyManiaItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyManiaItem $monthlyManiaItem)
    {
        //
    }
}
