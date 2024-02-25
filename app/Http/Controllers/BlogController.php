<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFilterRequest;
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

    public function index(): View
    {
        // Créer et sauvegarder un article
        /*$post1 = new Post();
        $post1->title = "Article sur les voitures";
        $post1->slug = Str::slug($post1->title, '-');
        $post1->content = "Lorem ipsum";
        $post1->category = "Voiture";
        $post1->save();*/

        return view('blog.index', [
            'posts' => Post::paginate(1),
        ]);
    }

    public function showCategory(string $category): RedirectResponse | View
    {
        $posts = Post::where('category', $category)->paginate(1);
        return view('blog.index', [
            'posts' => $posts,
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
