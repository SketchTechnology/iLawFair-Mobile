<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\PublishingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(20);

        return view('dashboard.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $publishingHouses = PublishingHouse::all();
        $authors = Author::all();

        return view('dashboard.books.create', compact('categories', 'publishingHouses', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Assuming max size is 20MB
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'publishing_house_id' => 'nullable|exists:publishing_houses,id',
            'published_year' => 'required|integer|min:1900|max:' . date('Y'),
            'file' => 'required|file|mimes:pdf,docx,epub|max:20480', // Assuming max size is 20MB

        ]);

        $image = $this->uploadImage($request);
        $file = $this->uploadFile($request);

        

        // Create new book
        $book = new Book();
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->image = $image;
        $book->author_id = $request->input('author_id');
        $book->category_id = $request->input('category_id');
        $book->price = $request->input('price');
        $book->sale_price = $request->input('sale_price');
        $book->publishing_house_id = $request->input('publishing_house_id');
        $book->published_year = $request->input('published_year');
        $book->file_path = $file;
        $book->save();

        Alert::success('Success', "Book created successfully");

        return redirect()->route('books.index');
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
    public function edit(Book $book)
    {
        $categories = Category::all();
        $publishingHouses = PublishingHouse::all();
        $authors = Author::all();

        return view('dashboard.books.edit', compact('book', 'categories', 'publishingHouses', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Assuming max size is 20MB
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'publishing_house_id' => 'nullable|exists:publishing_houses,id',
            'published_year' => 'required|integer|min:1900|max:' . date('Y'),
            'file' => 'nullable|file|mimes:pdf,docx,epub|max:20480', // Assuming max size is 20MB

        ]);



        $old_image = $book->image;

        $data = $request->except(['image','file']);
        $data['image'] = $this->uploadImage($request);


        if ($old_image && $data['image'] == null) {
            $data['image'] = $old_image;

        }

        if ($old_image && $old_image != $data['image']) {
            Storage::disk('uploads')->delete($old_image);
        }

 


        $old_file = $book->file_path;

         
      
        $data['file'] = $this->uploadFile($request);

        if ($old_file && $data['file'] == null) {
            $data['file'] = $old_file;
        }

        if ($old_file && $old_file != $data['file']) {
            Storage::disk('uploads')->delete($old_file);
        }

        

        
        // Update book information
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->image = $data['image'];
        $book->file_path = $data['file'];
        $book->author_id = $request->input('author_id');
        $book->category_id = $request->input('category_id');
        $book->price = $request->input('price');
        $book->sale_price = $request->input('sale_price');
        $book->publishing_house_id = $request->input('publishing_house_id');
        $book->published_year = $request->input('published_year');
        $book->save();

        Alert::success('Success', "Book updated successfully");

        return redirect()->route('books.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::disk('uploads')->delete($book->image);
        }
        $book->delete();

        Alert::success('Success', "Book Deleted Successfully");

        return redirect()->route('books.index');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');

        $path = $file->store('books', 'uploads');

        return $path;
    }


    protected function uploadFile(Request $request)
    {
        if (!$request->hasFile('file')) {
            return null;
        }

        $file = $request->file('file');

        $path = $file->store('booksFiles', 'uploads');

        return $path;
    }
}
