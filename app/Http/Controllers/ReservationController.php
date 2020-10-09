<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Resources\ReservationResource;
use App\Http\Transformers\ReservationTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ReservationResource::collection(
            Reservation::simplePaginate($request->input('paginate') ?? 15)
            )->additional([
                'meta' => [
                    'success' => true,
                    'message' => "reservations loaded",
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
            'reserve_date' => 'required|Date',
            'guests' => 'required|numeric',
            'package_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }
 
        try {
            $reservation = ReservationTransformer::toInstance($validator->validate());
            if (auth()->user()->reservations()->save($reservation)) {
                return (new ReservationResource($reservation))
                    ->additional([
                        'meta' => [
                          'success' => true,
                          'message' => "reservation created"
                     ]
            ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'reservation not added'
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
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        return (new ReservationResource($reservation))
        ->additional([
            'meta' => [
                'success' => true,
                'message' => "Reservation found"
            ]
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validator = Validator::make($request->all(), [
            'reserve_date' => 'required|Date',
            'guests' => 'required|numeric',
            'package_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {  
            return response()->json($validator->errors()->toArray(), 422);  
        }  

        try {  
            $updated_reservation = ReservationTransformer::toInstance($validator->validate(), $reservation);  
            if ($updated_reservation->save()) {
                return (new ReservationResource($reservation))
                    ->additional([
                        'meta' => [
                          'success' => true,
                          'message' => "reservation updated"
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
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        try {  
            $reservation->delete();   
        } catch (Exception $ex) {  
            Log::info($ex->getMessage());  
            return response()->json($ex->getMessage(), 409);  
        }  
    
        return response()->json('reservation has been deleted', 200);
    }
}
