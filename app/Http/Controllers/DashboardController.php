<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Pages.Admin.Dashboard');
    }
    public function get_count()
    {
        $project_amount = Project::all()->count();
        $post_amount = Post::all()->count();
        $category_amount = Category::all()->count();
        return response()->json(['post' => $post_amount, 'category' => $category_amount,'project' => $project_amount]);
    }

    public function guest_index()
    {
        return view('Pages.User.Dashboard');
    }
}
