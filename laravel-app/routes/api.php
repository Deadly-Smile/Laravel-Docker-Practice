<?php

use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::PUT('/p1', function (Request $request) {
    $p = Point::Create([
        'X' => $request['x'],
        'Y' => $request['y'],
    ]);
    return response()->json(['added' => ['x' => (int)$p->X, 'y' => (int)$p->Y]], 201);
});

Route::GET('/p2', function (Request $request) {
    $points = Point::all();
    // dd($points)
    $x = 0.00;
    $y = 0.00;
    foreach ($points as $point) {
        $x += $point->X;
        $y += $point->Y;
    }
    if (count($points) == 0) {
        return response()->json(['avg' => ['x' => (int)0, 'y' => (int)0]], 200);
    }

    return response()->json(['avg' => ['x' => (int)round($x / count($points)), 'y' => (int)round($y / count($points))]], 200);
});
