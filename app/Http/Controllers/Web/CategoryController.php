<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(private CategoryRepositoryInterface $categories) {}

    public function index()
    {
        abort_unless(auth()->user()->can('manage-categories'), 403);

        return view('admin.categories.index', [
            'categories' => $this->categories->paginate(12),
        ]);
    }

    public function create()
    {
        abort_unless(auth()->user()->can('manage-categories'), 403);

        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('manage-categories'), 403);

        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

        $this->categories->create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori pembelajaran berhasil dibuat.');
    }

    public function edit(Category $category)
    {
        abort_unless(auth()->user()->can('manage-categories'), 403);

        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        abort_unless(auth()->user()->can('manage-categories'), 403);

        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $this->categories->update($category, $data);

        return redirect()->route('categories.index')->with('success', 'Kategori pembelajaran berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        abort_unless(auth()->user()->can('manage-categories'), 403);
        $this->categories->delete($category);

        return redirect()->route('categories.index')->with('success', 'Kategori pembelajaran berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sdg_focus' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);
    }
}
