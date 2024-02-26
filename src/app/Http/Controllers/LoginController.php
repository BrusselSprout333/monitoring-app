<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginPage(): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return view('login');
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return view('login');
    }

    public function login(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'loginEmail' => 'required|email|max:255',
            'loginPassword' => 'required|min:6|max:255',
        ]);

        $user = User::where('email', $request->input('loginEmail'))->first();

        if(!$user || !Hash::check($request->input('loginPassword'), $user->password)) {
            return redirect()->back()->withErrors(['authError' => 'Пользователь с такой почтой или паролем не найден']);
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function register(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'registerName' => 'required|string|max:255',
            'registerEmail' => 'unique:App\Models\User,email|required|email|max:255',
            'registerPassword' => 'required|min:6|max:255',
            'registerSurname' => 'nullable|string|max:255',
            'registerGender' => 'nullable|in:male,female',
            'registerAge' => 'nullable|numeric|min:1|max:150'
        ]);

        $user = new User();
        $user->first_name = $request->input('registerName');
        $user->email = $request->input('registerEmail');
        $user->password = Hash::make($request->input('registerPassword'));
        if($request->input('registerSurname')) {
            $user->last_name = $request->input('registerSurname');
        }
        if($request->input('registerGender')) {
            $user->gender = $request->input('registerGender');
        }
        if($request->input('registerAge')) {
            $user->age = $request->input('registerAge');
        }
        $user->save();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
