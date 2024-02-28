<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFilterRequest;
use App\Http\Requests\FormPostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function create(): View
    {
        $post = new Post();
        return View('blog.create', [
            'post' => $post
        ]);
    }

    public function store(FormPostRequest $request)
    {
        $post = Post::create($request->validated());

        return redirect()->route('blog.show', ['slug' => $post->slug, 'id' => $post->id])
                ->with('success', "L'article a bien été sauvegardé");
    }

    public function edit(Post $post): View
    {
        return View('blog.edit', [
            'post' => $post,
        ]);
    }

    public function update(Post $post, FormPostRequest $request)
    {
        $post->update($request->validated());

        return redirect()->route('blog.show', ['slug' => $post->slug, 'id' => $post->id])
                ->with('success', "L'article a bien été modifié");
    }

    public function index(): View
    {
        $cat = Category::find(1);
        return view('blog.index', [
            'posts' => Post::paginate(1),
        ]);
    }

    public function show(string $slug, string $id): RedirectResponse | View
    {
        $post = Post::findOrFail($id);
        if ($post->slug !== $slug) {
            return to_route('blog.show', ['slug' => $post->slug, 'id' => $post->id]);
        }
        
        return View('blog.show', [
            'post' => $post,
        ]);
    }

}
