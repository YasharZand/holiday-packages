<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Resources\PackageResource;
use App\Http\Transformers\PackageTransformer;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $packages->toArray()
        ]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'hotel_name' => 'required',
            'hotel_url' => 'required|url',
            'duration' => 'required',
            'package_start_date' => 'required|Date',
            'validity' => 'required',
            'hotel_star' => 'required',
            'price' => 'required|Numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }
 
        try{
            $package = PackageTransformer::toInstance($validator->validate());
            if ($package->save()) {
                return response()->json([
                    'success' => true,
                    'data' => $package->toArray()
                ]);
            }else
                return response()->json([
                    'success' => false,
                    'message' => 'package not added'
                ], 500);

        } catch (Exception $ex) {
            Log::info($ex->getMessage());
            return response()->json($ex->getMessage(), 409);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        
 
       # $package = Package::find($id);

        if ($package->save()) {
            return response()->json([
                'success' => true,
                'data' => $package->toArray()
            ]);
        }else
            return response()->json([
                'success' => false,
                'message' => 'package not modified'
            ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {

        $this->validate($request, [
            'name' => 'required',
            'hotel_name' => 'required',
            'hotel_url' => 'required|url',
            'duration' => 'required',
            'package_start_date' => 'required|Date',
            'validity' => 'required',
            'hotel_star' => 'required',
            'price' => 'required|Numeric'
        ]);

        $package->name = $request->name;
        $package->hotel_name = $request->hotel_name;
        $package->hotel_url = $request->hotel_url;
        $package->duration = $request->duration;
        $package->package_start_date = $request->package_start_date;
        $package->validity = $request->validity;
        $package->hotel_star = $request->hotel_star;
        $package->price = $request->price;
        $package->quantity = $request->quantity;
        return $this->edit($package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
