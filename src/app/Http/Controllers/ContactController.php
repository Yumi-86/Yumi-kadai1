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
        $contact = new Contact($request->validated());

        $contact['channel_label'] = $contact->getChannelLabels();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('temp', 'public');
            $contact['image_path'] = $path;
            session(['contact_image_path' => $path]);

        } else {
            $contact['image_path'] = session('contact_image_path', null );
        }
        return view('contacts.confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        if( $request->input('action') == 'back')
        {
            return redirect('/')->withInput();
        }
        
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
            'tel' => $request->input('full_tel'),
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
