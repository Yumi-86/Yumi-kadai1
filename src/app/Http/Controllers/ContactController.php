<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Channel;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        $contact = new Contact($request->validated());

        $channel_ids = (array) $request->input('channel_id');

        $channel_ids = array_map('trim', $channel_ids);

        $channel_labels = Channel::whereIn('id', $channel_ids)->pluck('content')->toArray() ?: ['未選択'];


        // $contact['channel_label'] = $contact->getChannelLabels();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('temp', 'public');
            $contact['image_path'] = $path;
            session(['contact_image_path' => $path]);
        } else {
            $contact['image_path'] = session('contact_image_path', null);
        }
        return view('contacts.confirm', compact('contact', 'channel_ids', 'channel_labels'));
    }
    public function edit(Request $request)
    {
        return redirect()->route('contact.create')->withInput($request->all());
    }

    public function store(Request $request)
    {
        $request->merge([
            'full_tel' => $request->input('tel1') . $request->input('tel2') . $request->input('tel3'),
        ]);

        $imagePath = $request->input('image_path');

        if (!empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
            $newPath = str_replace('temp/', 'contacts/', $imagePath);
            Storage::disk('public')->move($imagePath, $newPath);
            $imagePath = $newPath;
        }

        $contact = Contact::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'tel' => $request->get('full_tel'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
            'category_id' => $request->input('category_id'),
            'detail' => $request->input('detail'),
            'image_path' => $imagePath,
        ]);
        $contact->channels()->attach($request->input('channel_id', []));

        return view('contacts.thanks');
    }
}
