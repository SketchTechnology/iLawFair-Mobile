<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PublishingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PublishingHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishingHouses = PublishingHouse::paginate(8);

        return view('dashboard.publishing_houses.index', compact('publishingHouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.publishing_houses.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Assuming max size is 2MB
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $image = $this->uploadImage($request);

        // Create new publishing house
        $publishingHouse = new PublishingHouse();
        $publishingHouse->name = $request->input('name');
        $publishingHouse->image = $image;
        $publishingHouse->address = $request->input('address');
        $publishingHouse->email = $request->input('email');
        $publishingHouse->phone = $request->input('phone');
        $publishingHouse->save();

        Alert::success('Success', "Publishing House created successfully");

        return redirect()->route('publishing-houses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublishingHouse $publishingHouse)
    {
        return view('dashboard.publishing_houses.edit', compact('publishingHouse'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublishingHouse $publishingHouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Assuming max size is 2MB
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $old_image = $publishingHouse->image;

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        if ($old_image && $data['image'] == null) {
            $data['image'] = $old_image;
        }

        if ($old_image && $old_image != $data['image']) {
            Storage::disk('uploads')->delete($old_image);
        }

        // Update publishing house information
        $publishingHouse->name = $request->input('name');
        $publishingHouse->image = $data['image'];
        $publishingHouse->address = $request->input('address');
        $publishingHouse->email = $request->input('email');
        $publishingHouse->phone = $request->input('phone');
        $publishingHouse->save();

        Alert::success('Success', "Publishing House updated successfully");

        return redirect()->route('publishing-houses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublishingHouse $publishingHouse)
    {
        if ($publishingHouse->image) {
            Storage::disk('uploads')->delete($publishingHouse->image);
        }
        $publishingHouse->delete();

        Alert::success('Success', "Publishing House Deleted Successfully");

        return redirect()->route('publishing-houses.index');
    }


    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');

        $path = $file->store('publishing_houses', 'uploads');

        return $path;
    }

    public function showBooks(PublishingHouse $publishingHouse)
    {
        $books = $publishingHouse->books()->paginate(10); // Assuming each publishing house has many books and you want to paginate them
        return view('dashboard.publishing_houses.books', compact('publishingHouse', 'books'));
    }
}
