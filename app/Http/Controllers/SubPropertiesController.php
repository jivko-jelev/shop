<?php

namespace App\Http\Controllers;

use App\Property;
use App\SubProperty;
use Illuminate\Http\Request;

class SubPropertiesController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\SubProperty $subProperties
     * @return \Illuminate\Http\Response
     */
    public function show(SubProperty $subProperties)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\SubProperty $subProperties
     * @return \Illuminate\Http\Response
     */
    public function edit(SubProperty $subProperties)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\SubProperty         $subProperties
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubProperty $subProperties)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SubProperty $subProperties
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(SubProperty $subProperties)
    {
        $isLastSubProperty = SubProperty::where('property_id', $subProperties->property_id)->limit(2)->count();
        if ($isLastSubProperty > 1) {
            $subProperties->delete();
        } else {
            return response()->json(['errors' => [0 => 'Не може да изтриете последния податрибут']], 404);
        }
    }
}
