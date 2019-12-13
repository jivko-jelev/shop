<?php

namespace App\Http\Controllers;

use App\SubVariation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubVariation  $subVariation
     * @return Response
     */
    public function show(SubVariation $subVariation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubVariation  $subVariation
     * @return Response
     */
    public function edit(SubVariation $subVariation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubVariation  $subVariation
     * @return Response
     */
    public function update(Request $request, SubVariation $subVariation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SubVariation $subVariation
     * @return Response
     * @throws \Exception
     */
    public function destroy(SubVariation $subvariation)
    {
        $subvariation->delete();
        return response()->json();
    }
}
