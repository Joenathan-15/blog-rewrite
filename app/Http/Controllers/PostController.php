<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        if (request('parent_uuid')) {
            return view(
                'Pages.Admin.Post.index',
                [
                    "parent_uuid" => request('parent_uuid')
                ]
            );
        } else {
            return to_route("admin.dashboard");
        }
    }

    public function edit(string $uuid)
    {
        $post = Post::where("uuid",$uuid)->first();
        return view('Pages.Admin.Post.edit',
        [
            "post" => $post
        ]);
    }

    public function save(string $uuid,Request $request)
    {
        $request->validate([
            'title' => "required"
        ]);
        try
        {
            DB::beginTransaction();
            $post = Post::where('uuid',$uuid)->first();
            $post->attachment_link = $request->attachment_link;
            $post->title = $request->title;
            $post->content = $request->content;
            $post->visibility = $request->visibility;
            $post->save();
            DB::commit();
        }catch(\Exception $err)
        {
            DB::rollBack();
        }
    }

    public function find_by_uuid(string $uuid)
    {
        $posts = Post::where("parent_uuid", $uuid)->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => "required",
            "parent_uuid" => "required"
        ]);
        try
        {
            DB::beginTransaction();
            $post = new Post();
            $post->attachment_link = $request->attachment_link;
            $post->title = $request->title;
            $post->content = $request->content;
            $post->parent_uuid = $request->parent_uuid;
            $post->uuid = uniqid();
            $post->save();
            DB::commit();
        }catch(\Exception $err)
        {
            DB::rollBack();
        }
    }

    public function delete(string $uuid)
    {
        $post = Post::where('uuid',$uuid)->first();
        if($post)
        {
            $post->delete();
        }else
        {
            abort(404);
        }
    }
}
