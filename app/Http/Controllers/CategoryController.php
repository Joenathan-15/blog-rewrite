<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        return view("Pages.Admin.Category.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        try
        {
            DB::beginTransaction();
            $category = new Category();
            $category->title = $request->title;
            $category->attachment_link = $request->attachment_link;
            $category->uuid = uniqid();
            $category->created_by = Auth::user()->id;
            $category->save();
            DB::commit();
        }catch(\Exception $err)
        {
            DB::rollBack();
        }
    }

    public function edit(string $uuid)
    {
        $category = Category::where('uuid',$uuid)->first();
        return view('Pages.Admin.Category.edit',[
            'category' => $category
        ]);
    }

    public function save(string $uuid , Request $request)
    {
        $category = Category::where('uuid',$uuid)->first();
        try
        {
            DB::beginTransaction();
            $category->attachment_link = $request->attachment_link;
            $category->title = $request->title;
            $category->description = $request->description;
            $category->visibility = $request->visibility;
            $category->save();
            DB::commit();
        }catch(\Exception $err)
        {
            DB::rollBack();
        }
    }

    public function delete_category(string $uuid)
    {
        $category = Category::where('uuid', $uuid)->first();
        if ($category) {
            $posts = Post::where('parent_uuid', $category->uuid)->get();
            foreach ($posts as $post) {
                $post->delete();
            }
            $category->delete();
        } else {
            abort(404);
        }
    }


    public function list()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}
