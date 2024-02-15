<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use File;
use Image;
use Hash;
class ProfileController extends Controller
{
    public function index()
    {
        return view('back.profile');
    }
    public function update_info(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'img' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->img) {
            File::delete($user->img);
            $img = $request->img;
            $path = 'uploads/users/user_pp_' . $user->id . '_' . time() . '.webp';
            Image::make($img)->resize(70, 70)->encode('webp')->save($path);
            $user->img = $path;
        }
        if ($user->save()) {
            return redirect()->back()->with('success', 'Profil bilgileriniz güncellendi');
        } else {
            return redirect()->back()->with('error', 'Bilinmeyen Bir Hata Oluştu. Lütfen Tekrar Deneyiniz');
        }
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:20|confirmed',
            'new_password_confirmation' => 'required|min:8|max:20',
        ]);
        $user = Auth::user();
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $new_password_confirmation = $request->new_password_confirmation;

        if ($old_password && $new_password && $new_password_confirmation) {
            if (Hash::check($old_password, $user->password)) {
                $user->password = Hash::make($new_password);
                if ($user->save()) {
                    Auth::logout();
                    return redirect()->back()->with('success', 'Şifreniz Güncellendi. Lütfen Yeni Şifrenizi Kullanarak Giriş Yapınız');
                } else {
                    return redirect()->back()->with('error', 'Bilinmeyen Bir Hata Oluştu');
                }
            } else {
                return redirect()->back()->with('error', 'Eski Parola Yanlış !');
            }
        } else {
            return redirect()->back()->with('error', 'Parola Alanları Boş!');
        }
    }
}
