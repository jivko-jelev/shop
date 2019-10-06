<?php

namespace App\Http\Controllers;

use App\Picture;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PictureController extends Controller
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
        $year  = Carbon::today()->year;
        $month = Carbon::today()->month;
        foreach ($request->picture as $item) {
            $filename=Picture::generateUniqueFilename("storage/$year/$month/{$item->getClientOriginalName()}");

            $item->storeAs("$year/$month", $filename);
            $picture = Picture::create([
                'filename' => "storage/$year/$month/$filename",
            ]);

            Picture::cropImage($picture->filename);
            $picture->generateThumbnails();
        }
        die;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Picture $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Picture $picture)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Picture $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Picture             $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Picture $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
