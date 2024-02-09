<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //index
    public function index()
    {
        $categories = Category::paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    //create
    public function create()
    {
        return view('pages.categories.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //store the request
        $categories = new Category;
        $categories->name = $request->name;
        $categories->description = $request->description;
        $categories->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/categories', $categories->id . '.' . $image->getClientOriginalExtension());
            $categories->image = 'storage/categories' . $categories->id . '.' . $image->getClientOriginalExtension();
            $categories->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    //show
    public function show()
    {
        return view('pages.categories.show');
    }

    //edit
    public function edit($id)
    {
        $categories = Category::find($id);
        return view('pages.categories.edit', compact('categories'));
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        // update the request..
        $categories = Category::find($id);
        $categories->name = $request->name;
        $categories->description = $request->description;
        $categories->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/categories', $categories->id . '.' . $image->getClientOriginalExtension());
            $categories->image = 'storage/categories' . $categories->id . '.' . $image->getClientOriginalExtension();
            $categories->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $categories = Category::find($id);
        $categories->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
