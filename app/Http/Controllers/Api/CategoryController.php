<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Category", description="Kategori pembelajaran")
 */
class CategoryController extends Controller
{
    public function __construct(private CategoryRepositoryInterface $categories) {}

    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->categories->paginate((int) $request->query('per_page', 10)),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create', Category::class), 403);

        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dibuat.',
            'data' => $this->categories->create($data),
        ], 201);
    }

    public function show(int $id)
    {
        $category = $this->categories->find($id);

        return $category
            ? response()->json(['success' => true, 'data' => $category->load('articles')])
            : response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
    }

    public function update(Request $request, int $id)
    {
        $category = $this->categories->find($id);

        if (!$category || auth()->user()->cannot('update', $category)) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
        }

        $data = $this->validated($request, false);
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
            'data' => $this->categories->update($category, $data),
        ]);
    }

    public function destroy(int $id)
    {
        $category = $this->categories->find($id);

        if (!$category || auth()->user()->cannot('delete', $category)) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan.'], 404);
        }

        $this->categories->delete($category);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
    }

    private function validated(Request $request, bool $required = true): array
    {
        $rule = $required ? 'required' : 'sometimes';

        return $request->validate([
            'name' => "{$rule}|string|max:255",
            'description' => 'nullable|string',
            'sdg_focus' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);
    }
}
