<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        return view("Pages.Admin.Project.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => "required",
        ]);
        try {
            DB::beginTransaction();
            $project = new Project();
            $project->title = $request->title;
            $project->attachment_link = $request->attachment_link;
            $project->repository = $request->repository;
            $project->uuid = uniqid();
            $project->created_by = Auth::user()->id;
            $project->save();
            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
        }
    }

    public function edit(string $uuid)
    {
        $project = Project::where('uuid', $uuid)->first();
        return view('Pages.Admin.Project.edit', [
            'project' => $project
        ]);
    }

    public function save_edit(string $uuid, Request $request)
    {
        $request->validate([
            'title' => "required"
        ]);
        try {
            DB::beginTransaction();
            $project = Project::where("uuid", $uuid)->first();
            $project->title = $request->title;
            $project->attachment_link = $request->attachment_link;
            $project->repository = $request->repository;
            $project->description = $request->description;
            $project->visibility = $request->visibility;
            $project->save();
            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
        }
    }

    public function delete_project(string $uuid)
    {
        $project = Project::where('uuid', $uuid)->first();
        if ($project) {
            $posts = Post::where('parent_uuid', $project->uuid)->get();
            foreach ($posts as $post) {
                $post->delete();
            }
            $project->delete();
        } else {
            abort(404);
        }
    }

    public function get_list()
    {
        $projects = Project::all();
        return response()->json($projects);
    }
}
