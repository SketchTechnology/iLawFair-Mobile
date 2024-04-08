<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::paginate(8);

        return view('dashboard.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.authors.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Assuming max size is 2MB
        ]);

        $image = $this->uploadImage($request);

        // Create new author
        $author = new Author();
        $author->name = $request->input('name');
        $author->image = $image;
        $author->save();

        Alert::success('Success', "Author created successfully");

        return redirect()->route('authors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('dashboard.authors.edit', compact('author'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max size is 2MB
        ]);

        $old_image = $author->image;

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        if ($old_image && $data['image'] == null) {
            $data['image'] = $old_image;
        }

        if ($old_image && $old_image != $data['image']) {
             Storage::disk('uploads')->delete($old_image);
        }

        // Update author information
        $author->name = $request->input('name');
        $author->image =  $data['image'];
        $author->save();

        Alert::success('Success', "Author updated successfully");

        return redirect()->route('authors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author  $author)
    {
        // dd($author) ;
        if ($author->image) {
            Storage::disk('uploads')->delete($author->image);
        }
        $author->delete();

        Alert::success('Success', "Author Deleted Successfully");

        return redirect()->route('authors.index');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');

        $path = $file->store('authors', 'uploads');

        return $path;
    }


    public function showBooks(Author $author)
    {
        $books = $author->books()->paginate(10); // Assuming each author has many books and you want to paginate them
        return view('dashboard.authors.books', compact('author', 'books'));
    }
}
