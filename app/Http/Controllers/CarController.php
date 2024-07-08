<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with('photos')->get();
        return response()->json($cars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'price' => 'required|numeric',
            'color' => 'required|string|max:255',
            'mileage' => 'required|numeric',
            'city' => 'required|string|max:255',
            'created' => 'required|string|max:255',
            'plate' => 'required|string|max:255|unique:cars',
        ]);

        $car = Car::create($request->all());
        return response()->json($car, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return response()->json($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'brand' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'color' => 'sometimes|required|string|max:255',
            'mileage' => 'sometimes|required|numeric',
            'city' => 'sometimes|required|string|max:255',
            'created' => 'sometimes|required|string|max:255',
            'update_photos' => 'sometimes|boolean',
            'view' => 'sometimes|required|integer',
            'plate' => 'sometimes|required|string|max:255|unique:cars,plate,' . $id,
        ]);

        $car = Car::findOrFail($id);

        if($request->has('view')){
            $car->view = $car->view + $request->view;
            $car->save();
        }

        if ($request->has('update_photos')) {
            $car->photos()->delete();
        }

        $car->update($request->except('view'));
        

        return response()->json($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->photos()->delete();
        $car->delete();
        return response()->json(null, 204);
    }
}
