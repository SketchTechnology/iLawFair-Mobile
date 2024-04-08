<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(8);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Assuming max size is 2MB
        ]);

        $image = $this->uploadImage($request);

 
        // Create new category
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->parent_id = $request->input('parent_id');
        $category->image = $image;
        $category->save();

        // Redirect back with success message
 
        Alert::success('Success', "Category created successfully");


        return redirect()->route('categories.index');
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
    public function edit(Category $category)
    {
        $categories = Category::all();

        return view('dashboard.categories.edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
              // Validate the request data
              $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Assuming max size is 2MB
            ]);
    
            // Find the category by ID
            $category = Category::findOrFail($id);
    
            $old_image = $category->image;
            // dd($old_image) ;
    
            $data = $request->except('image');
            $data['image'] = $this->uploadImage($request);
    // dd($data['image']) ;
    
            if ($old_image && $data['image'] == null) {
                $data['image'] = $old_image;
            }
    
     
            if ($old_image && $old_image != $data['image']) {
                 Storage::disk('uploads')->delete($old_image);
            }
            // Update category information
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->parent_id = $request->input('parent_id');
            $category->image =  $data['image'];
            $category->save();
    
           

            
        Alert::success('Success', "Category updated successfully");


        return redirect()->route('categories.index');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('uploads')->delete($category->image);
        }
        // dd($category)  ;
        $category->delete() ;
 
        Alert::success('Success', "Category Deleted Successfully");

        return redirect()->route('categories.index');
    }

    protected function uploadImage(Request $request)
    {
 
        if (!$request->hasfile('image')) {

            return;
        }
        
        $file = $request->file('image');
 
        $path = $file->store('categories', 'uploads');

        return $path;
    }
}
