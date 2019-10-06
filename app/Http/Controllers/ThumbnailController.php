<?php

namespace App\Http\Controllers;

use App\Thumbnail;
use Illuminate\Http\Request;

class ThumbnailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thumbnails = Thumbnail::select('filename', 'picture_id')
                               ->where('size', 1)
                               ->latest()
                               ->get();

        return response()->json($thumbnails);
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
     * @param \App\Thumbnail $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function show(Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Thumbnail $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function edit(Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Thumbnail           $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Thumbnail $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thumbnail $thumbnail)
    {
        //
    }
}
