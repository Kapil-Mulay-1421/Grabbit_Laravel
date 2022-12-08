<?php

namespace App\Http\Controllers;

use App\Models\DailyDoseItem;
use App\Http\Requests\StoreDailyDoseItemRequest;
use App\Http\Requests\UpdateDailyDoseItemRequest;

class DailyDoseItemController extends Controller
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
     * @param  \App\Http\Requests\StoreDailyDoseItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyDoseItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyDoseItem  $dailyDoseItem
     * @return \Illuminate\Http\Response
     */
    public function show(DailyDoseItem $dailyDoseItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyDoseItem  $dailyDoseItem
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyDoseItem $dailyDoseItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDailyDoseItemRequest  $request
     * @param  \App\Models\DailyDoseItem  $dailyDoseItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDailyDoseItemRequest $request, DailyDoseItem $dailyDoseItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyDoseItem  $dailyDoseItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyDoseItem $dailyDoseItem)
    {
        //
    }
}
