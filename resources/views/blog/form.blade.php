<form action="" method="post" class="vstack gap-2">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}">
        @error('title')
            {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" class="form-control"name="slug" value="{{ old('slug', $post->slug) }}">
        @error('slug')
            {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="content">Contenu</label>
        <textarea class="form-control"name="content">{{ old('content', $post->content) }}</textarea>
        @error('content')
            {{ $message }}
        @enderror
    </div>
    <div class="form-group">
        <label for="category">Catégorie</label>
        <select class="form-control" name="category">
            @if (old('category'))
                <option value="voiture" {{ old('category') == 'voiture' ? 'selected' : '' }}>Voiture</option>
                <option value="blog" {{ old('category') == 'blog' ? 'selected' : '' }}>Blog</option>
            @else
                <option value="voiture" {{ $post->category == 'voiture' ? 'selected' : '' }}>Voiture</option>
                <option value="blog" {{ $post->category == 'blog' ? 'selected' : '' }}>Blog</option>
            @endif
        </select>
        @error('category')
            {{ $message }}
        @enderror
    </div>
    <button class="btn btn-primary">
        @if ($post->id)
            Modifier
        @else
            Créer
        @endif
    </button>
</form>
