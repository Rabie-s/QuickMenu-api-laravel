<?php

namespace App\Http\Controllers\User\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\User\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Display a listing of the categories.
     */
    public function index(Request $request, string $menuUuid): JsonResponse
    {
        $perPage = $request->get('per_page', 10);

        $categories = $this->categoryService->index($menuUuid, $perPage);

        return $this->successResponse($categories,statusCode:200);
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request, string $menuUuid): JsonResponse
    {
        $data = $request->validated();

        $category = $this->categoryService->store($menuUuid, $data);

        return $this->successResponse($category,statusCode:201);
    }

    /**
     * Display the specified category.
     */
    public function show(string $menuUuid, string $id): JsonResponse
    {
        $category = $this->categoryService->show($menuUuid, (int) $id);

        return $this->successResponse($category,statusCode:200);
    }

    /**
     * Update the specified category.
     */
    public function update(UpdateCategoryRequest $request, string $menuUuid, string $id): JsonResponse
    {
        $data = $request->validated();

        $category = $this->categoryService->update(
            $menuUuid,
            (int) $id,
            $data
        );

        return $this->successResponse($category,statusCode:200);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(string $menuUuid, string $id): JsonResponse
    {
        $this->categoryService->destroy($menuUuid, (int) $id);

        return $this->successResponse(statusCode:204);
    }
}
