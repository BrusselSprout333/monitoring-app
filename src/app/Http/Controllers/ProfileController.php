<?php

namespace App\Http\Controllers;

use App\Models\MonitoringData;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showProfilePage(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (!Auth::check()) {
            return redirect()->back();
        }

        /** @var User $user */
        $user = Auth::user();

        $monitoringData = MonitoringData::where('userId', $user->id)->get();

        return view('profile', ['user' => $user, 'monitoringData' => $monitoringData]);
    }

    public function showProfileEditPage()
    {
        if (!Auth::check()) {
            return redirect()->back();
        }

        /** @var User $user */
        $user = Auth::user();

        return view('profile-edit', ['user' => $user]);
    }

    public function editProfile(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'surname' => 'nullable|string|max:255',
            'gender'  => 'nullable|in:male,female',
            'age'     => 'nullable|numeric|min:1|max:150',
            'new_password' => 'nullable|min:6|max:255'
        ]);

        $deleteAvatar = $request->input('delete_avatar');
        $deleteAvatar = (bool)$deleteAvatar;

        $user = User::find($request->input('id'));

        if ($request->file('avatar')) {
            $avatarName = 'avatar_' . $user->id . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->storeAs('public/avatars', $avatarName);

            $user->avatar = $avatarName;
        }

        if($deleteAvatar === true) {
            $user->avatar = null;
        }

        if(
            $request->input('change_password') == 'on'
            && $request->input('old_password')
            && $request->input('new_password')
        ) {
            if (Hash::check($request->input('old_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withErrors(['old_password' => 'Введен неправильный текущий пароль']);
            }
        }

        $user->first_name = $request->input('name');
        $user->email = $request->input('email');
        $user->last_name = $request->input('surname');
        $user->gender = $request->input('gender');
        $user->age = $request->input('age');

        $user->save();

        Auth::login($user);

        return redirect()->route('profilePage');
    }

    public function deleteAccount(int $id)
    {
        if (Auth::check()) {
            $user = User::find($id);
            $user->delete();
            Auth::logout();
        }

        return redirect()->route('home');
    }

    public function deleteAvatar(Request $request): JsonResponse
    {
        $avatar = $request->avatar;

        if (Storage::disk('public')->exists('avatars/' . $avatar)) {
            Storage::disk('public')->delete('avatars/' . $avatar);
        }

        return response()->json(['success' => true]);
    }
}
