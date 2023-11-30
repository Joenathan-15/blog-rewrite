<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $post = Post::where('visibility',true)->latest()->limit(5)->get();
        $projects = Project::where('visibility',true)->latest()->limit(3)->get();
        $categories = Category::where('visibility',true)->latest()->limit(3)->get();

        return view('components.sidebar',[
            'posts' => $post,
            'projects' => $projects,
            'categories' => $categories,
        ]);
    }
}
