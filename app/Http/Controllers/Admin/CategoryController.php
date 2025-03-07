<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\UserActivityService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $useractivityService;

    public function __construct(CategoryService $categoryService, UserActivityService $useractivityService)
    {
        $this->categoryService = $categoryService;
        $this->useractivityService = $useractivityService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.product.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.product.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->categoryService->createCategory($request->all());

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menambahkan kategori baru';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.product.category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('admin.product.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->categoryService->updateCategory($id, $request->all());

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Memperbarui data kategori';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.product.category.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menghapus sebuah kategori';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.product.category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}