<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Channel;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $channels = Channel::all();
        return view('contacts.create', compact('categories', 'channels'));
    }
    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['first_name', 'last_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail',]);
        $contact['channel_id'] = $request->input('channel_id', []);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('temp', 'public');
            $contact['image_path'] = $path;
            session(['contact_image_path' => $path]);

        } else {
            $contact['image_path'] = session('contact_image_path', null );
        }

        $genderMap = [
            '1' => '男性',
            '2' => '女性',
            '3' => 'その他'
        ];
        $contact['gender_label'] = $genderMap[$contact['gender']] ?? '不明';

        $category = Category::find($contact['category_id']);
        $contact['category_label'] = $category ? $category->content : '未選択';

        $channel_ids = $contact['channel_id'];
        $channels = Channel::whereIn('id', $channel_ids)->pluck('content')->toArray();
        $contact['channel_label'] = !empty($channels) ? $channels : ['未選択'];
        

        return view('contacts.confirm', compact('contact'));
    }
    public function edit(Request $request) {
        return redirect('/')->withInput();
    }
    public function store(Request $request)
    {
        $tel = $request->input('tel1') . $request->input('tel2') . $request->input('tel3');

        $imagePath = $request->input('image_path');

        if(!empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
            $newPath = str_replace('temp/', 'contacts/', $imagePath);
            Storage::disk('public')->move($imagePath, $newPath);
            $imagePath = $newPath;
        }

        $contact = Contact::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'tel' => $tel,
            'address' => $request->input('address'),
            'building' => $request->input('building'),
            'category_id' => $request->input('category_id'),
            'detail' => $request->input('detail'),
            'image_path' => $imagePath,
        ]);
        $contact->channels()->attach($request->input('channel_id', []));

        return view('/contacts/thanks');
    }
}
