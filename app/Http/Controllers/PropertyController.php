<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Exception;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(Property::whereUserId($request->user()->id)->get());
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
        $data['user_id'] = $request->user()->id;
        $data['title'] = $request->title;
        $data['price'] = $request->price;
        $data['Address'] = $request->Address;
        $data['Desc'] = $request->Desc;
        try{
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = time(). '-' . $file->getClientOriginalName();
                $file->move(public_path('images'), $file_name);
                $data['photo'] = $file_name;
            }
        } catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ]);
        }

        $property = Property::create($data);
        return response()->json($property);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return response()->json(Property::find($property));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $file_name = $request->photo;
        try{
            if ($request->hasFile('photo')) {
                unlink(public_path('images/') . $property->photo);
                $file = $request->file('photo');
                $file_name = time(). '-' . $file->getClientOriginalName();
                $file->move(public_path('images'), $file_name);
                $data['photo'] = $file_name;
            }
        } catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ]);
        }
        $property->update([
            'title' => $request->title,
            'price' => $request->price,
            'photo' => $file_name,
            'Address' => $request->Address,
            'Desc' => $request->Desc
        ]);
        return response()->json($property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        unlink(public_path('images/') . $property->photo);
        $property->delete();
        return response()->json('Successfully deleted');
    }
}
