<?php

namespace App\Http\Controllers;

use App\Models\WeeklyWonderItem;
use App\Http\Requests\StoreWeeklyWonderItemRequest;
use App\Http\Requests\UpdateWeeklyWonderItemRequest;

class WeeklyWonderItemController extends Controller
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
     * @param  \App\Http\Requests\StoreWeeklyWonderItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWeeklyWonderItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeeklyWonderItem  $weeklyWonderItem
     * @return \Illuminate\Http\Response
     */
    public function show(WeeklyWonderItem $weeklyWonderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeeklyWonderItem  $weeklyWonderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(WeeklyWonderItem $weeklyWonderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWeeklyWonderItemRequest  $request
     * @param  \App\Models\WeeklyWonderItem  $weeklyWonderItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWeeklyWonderItemRequest $request, WeeklyWonderItem $weeklyWonderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeeklyWonderItem  $weeklyWonderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeeklyWonderItem $weeklyWonderItem)
    {
        //
    }
}
