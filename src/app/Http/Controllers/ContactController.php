<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('contacts.create', compact('categories'));
    }
    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail']);

        $genderMap = [
            '1' => '男性',
            '2' => '女性',
            '3' => 'その他'
        ];
        $contact['gender_label'] = $genderMap[$contact['gender']] ?? '不明';

        $category = Category::find($contact['category_id']);
        $contact['category_label'] = $category ? $category->content : '未選択';


        return view('contacts.confirm', compact('contact'));
    }
    public function edit(Request $request)
    {
        return redirect('/')->withInput();
    }
    public function store(Request $request)
    {
        $tel = $request->input('tel1') . $request->input('tel2') . $request->input('tel3');

        Contact::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'tel' => $tel,
            'address' => $request->input('address'),
            'building' => $request->input('building'),
            'category_id' => $request->input('category_id'),
            'detail' => $request->input('detail'),
        ]);

        return view('/contacts/thanks');
    }
}
