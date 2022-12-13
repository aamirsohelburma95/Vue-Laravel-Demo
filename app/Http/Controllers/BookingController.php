<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(
            Property::get()
        );
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        error_log(print_r($request->all(),true));
        $data['user_id'] = $request->user()->id;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['prop_id'] = $request->prop_id;
        $property = Booking::create($data);
        return response()->json($property);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function getBookingData(Request $request)
    {
        $selectedData = [
            'title','price','photo','Address','Desc','start_date','end_date'];
        // $data = DB::table('booking')
        // ->select($selectedData)
        // ->join('properties', 'bookings.prop_id', '=', 'properties.id')
        // ->where('user_id','=',$request->user()->id)
        // ->get();
        // print_r($data);
        // return response()->json($data);
            error_log(print_r($selectedData),true);
        return response()->json($selectedData);
    }
}
