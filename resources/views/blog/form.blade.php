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
        <select class="form-control" id="category" name="category_id">
            <option value="">Sélectionner une catégorie</option>
            @foreach ($categories as $category)
            {
                <option @selected(old('category', $post->category_id) == $category->id) value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            }
            @endforeach
        </select>
        @error('category_id')
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
