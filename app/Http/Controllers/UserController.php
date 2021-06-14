<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Utils\Bouncer;
use App\Utils\StatusCode;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function profile(): Factory|View|Application|RedirectResponse
    {
        return view('pages.users.show', ['user' => Auth::user()]);
    }

    public function index(): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('index', User::class)){
            abort(StatusCode::FORBIDDEN);
        }

        return view('pages.users.index', ['users' => User::all()]);
    }

    public function create(): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('create', User::class)){
            abort(StatusCode::FORBIDDEN);
        }

        return view('pages.users.form');
    }

    public function store(UserRequest $request): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('create', User::class)){
            abort(StatusCode::FORBIDDEN);
        }

        $user = User::create($request->validated());
        Toastr::success('New user created');
        return redirect(route('users.show', [$user]));
    }

    public function show(User $user): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('view', User::class)){
            abort(StatusCode::FORBIDDEN);
        }

        return view('pages.users.show', ['user' => $user]);
    }

    public function edit(User $user): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('edit', User::class)){
            abort(StatusCode::FORBIDDEN);
        }

        return view('pages.users.form', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('edit', User::class)){
            abort(StatusCode::FORBIDDEN);
        }

        $user->update($request->validated());
        $user->save();

        Toastr::success('User modified');
        return redirect(route('users.show', [$user]));
    }

    public function destroy(User $user): Factory|View|Application|RedirectResponse
    {
        if(!Bouncer::can('delete', User::class)){
            abort(StatusCode::FORBIDDEN);
        }

        Toastr::warning("User deleted: $user->name");
        $user->delete();
        return redirect(route('users.index'));
    }
}
