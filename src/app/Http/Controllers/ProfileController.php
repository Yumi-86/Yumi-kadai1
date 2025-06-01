<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function create()
    {
        return view('auth.profile');
    }
    public function store(Request $request){
        $imagepath = null;
        if($request->hasfile('image')) {
            $imagepath = $request->file('image')->store('profile_images', 'public');
        }

        $validator = Validator::make($request->all(), [
            'gender' => 'required|in:1,2,3',
            'birthday' => 'required|date',
            'tel' => 'nullable|regex:/^0\d{9,10}$/',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'gender.required' => '性別を選択してください。',
            'gender.in' => '性別の値が不正です。',
            'birthday.required' => '誕生日を入力してください。',
            'birthday.date' => '誕生日は正しい日付で入力してください。',
            'tel.regex' => '電話番号は0から始まる10桁または11桁の数字で入力してください。',
            'image.image' => 'アップロードされたファイルは画像である必要があります。',
            'image.mimes' => '画像は jpeg、png、jpg、gif のいずれかである必要があります。',
            'image.max' => '画像サイズは2MB以下にしてください。',
        ]);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('image') + ['image_path' => $imagepath]);
        }
        
        $user = Auth::user();
        $user->profile()->create([
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'tel' => $request->input('tel'),
            'address' => $request->input('address'),
            'image_path' => $imagepath,
        ]);

        return redirect('/admin');

    }
    
}
