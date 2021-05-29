<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use App\Utils\Bouncer;
use App\Utils\StatusCode;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{

    public function index(): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('index', Car::class)){
                    abort(StatusCode::FORBIDDEN);
        }

        return view('car.index', ['cars' => Car::all()]);
    }

    public function create(): Factory|View|Application|RedirectResponse
    {
         if(!Bouncer::can('create', Car::class)){
            abort(StatusCode::FORBIDDEN);
         }

        return view('cars.form');
    }

    public function store(CarRequest $request): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('create', Car::class)){
           abort(StatusCode::FORBIDDEN);
        }

       $car = Car::create($request->validated());
        Toastr::success('New car created');
        return redirect(route('cars.show', [$car]));
    }

    public function show(Car $car): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('view', Car::class)){
            abort(StatusCode::FORBIDDEN);
        }
        return view('cars.show', ['car' => $car]);
    }

    public function edit(Car $car): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('edit', Car::class)){
            abort(StatusCode::FORBIDDEN);
        }

        return view('cars.form', ['car' => $car]);
    }

    public function update(CarRequest $request, Car $car): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('edit', Car::class)){
            abort(StatusCode::FORBIDDEN);
        }

        $car->update($request->validated());
        $car->save();

        Toastr::success('Car modified');
        return redirect(route('cars.show', [$car]));
    }

    public function destroy(Car $car): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('delete', Car::class)){
           abort(StatusCode::FORBIDDEN);
        }

        Toastr::warning("Car deleted: $car->id");
        $car->delete();
        return redirect(route('cars.index'));
    }
}
