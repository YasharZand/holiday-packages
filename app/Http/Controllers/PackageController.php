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
    public function index(Request $request)
    {
        return PackageResource::collection(
            Package::simplePaginate($request->input('paginate') ?? 15)
            )->additional([
                'meta' => [
                  'success' => true,
                 'message' => "packages loaded",
            ]
        ]);
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
            'hotel_name' => 'required|string',
            'hotel_url' => 'required|url',
            'duration' => 'required|numeric',
            'package_start_date' => 'required|Date',
            'validity' => 'required|numeric',
            'hotel_star' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }
 
        try {
            $package = PackageTransformer::toInstance($validator->validate());
            if ($package->save()) {
                return (new PackageResource($package))
                    ->additional([
                        'meta' => [
                          'success' => true,
                          'message' => "package created"
                     ]
            ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'package not added'
                ], 500);
            }
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
        return (new PackageResource($package))
            ->additional([
                'meta' => [
                    'success' => true,
                    'message' => "package found"
                ]
            ]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'hotel_name' => 'required|string',
            'hotel_url' => 'required|url',
            'duration' => 'required|numeric',
            'package_start_date' => 'required|Date',
            'validity' => 'required|numeric',
            'hotel_star' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {  
            return response()->json($validator->errors()->toArray(), 422);  
        }  

        try {  
            $updated_package = PackageTransformer::toInstance($validator->validate(), $package);  
            if ($updated_package->save()) {
                return (new PackageResource($package))
                    ->additional([
                        'meta' => [
                          'success' => true,
                          'message' => "package updated"
                     ]
            ]);
            } 
 
        } catch (Exception $ex) {  
            Log::info($ex->getMessage());   
            return response()->json($ex->getMessage(), 409);  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        try {  
            $package->delete();  
            // $package->save();  
        } catch (Exception $ex) {  
            Log::info($ex->getMessage());  
            return response()->json($ex->getMessage(), 409);  
        }  
    
        return response()->json('package has been deleted', 200);
    }
}
