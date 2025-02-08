<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->get('tag');

        $posts = Post::query()
            ->when($tag, function ($query, $tag) {
                $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('slug', $tag);
                });
            })
            ->with('tags')
            ->active()
            ->paginate(10);
        return themeView('posts.index', compact('posts'));
    }

    public function show(Request $request, string $slug)
    {
        $post = Post::query()->where('slug', $slug)->with('tags')->active()->first();

        if (!$post) {
            return redirect()->route('posts.index');
        }

        return themeView('posts.show', compact('post'));
    }
}
