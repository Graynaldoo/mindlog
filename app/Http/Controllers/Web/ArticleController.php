<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\StatisticsRepositoryInterface;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepositoryInterface $articles,
        private CategoryRepositoryInterface $categories,
        private StatisticsRepositoryInterface $statistics,
    ) {}

    public function index(Request $request)
    {
        $categorySlug    = $request->query('category');
        $allCategories   = $this->categories->allActive();
        $activeCategory  = $categorySlug
            ? $allCategories->firstWhere('slug', $categorySlug)
            : null;

        if ($activeCategory) {
            $articles = $this->articles->publishedByCategory($activeCategory->id, 9);
            $featured = $articles->first();
        } else {
            $articles = $this->articles->published(9);
            $featured = $articles->first();
        }

        return view('articles.index', [
            'articles'       => $articles,
            'featured'       => $featured,
            'categories'     => $allCategories,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(string $slug)
    {
        $article = $this->articles->findBySlug($slug);
        abort_if(!$article || ($article->status !== 'published' && auth()->user()->cannot('update', $article)), 404);

        if ($article->status === 'published') {
            $this->articles->incrementReadCount($article);
            $this->statistics->recordArticleRead(auth()->id(), $article->estimated_minutes);
        }

        return view('articles.show', ['article' => $article->fresh('category', 'author')]);
    }

    public function manage()
    {
        abort_unless(auth()->user()->can('write-articles'), 403);

        return view('admin.articles.index', [
            'articles' => $this->articles->paginate(null, 12),
        ]);
    }

    public function create()
    {
        abort_unless(auth()->user()->can('write-articles'), 403);

        return view('admin.articles.form', [
            'article' => new Article(),
            'categories' => $this->categories->allActive(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create', Article::class), 403);

        $data = $this->validated($request);
        $data['author_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        $this->articles->create($data);

        return redirect()->route('articles.manage')->with('success', 'Artikel edukasi berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        return view('admin.articles.form', [
            'article' => $article,
            'categories' => $this->categories->allActive(),
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));
        $data['published_at'] = $data['status'] === 'published'
            ? ($article->published_at ?? now())
            : null;

        $this->articles->update($article, $data);

        return redirect()->route('articles.manage')->with('success', 'Artikel edukasi berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $this->articles->delete($article);

        return redirect()->route('articles.manage')->with('success', 'Artikel edukasi berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'estimated_minutes' => 'required|integer|min:1|max:180',
        ]);
    }
}
