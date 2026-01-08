<?php

namespace App\Services\User\Category;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class CategoryService
{
    /**
     * Get paginated categories for a specific menu
     */
    public function index(string $menuUuid, int $perPage = 10): LengthAwarePaginator
    {
        $menu = Auth::user()
            ->menus()
            ->where('uuid', $menuUuid)
            ->firstOrFail();

        return $menu->categories()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create category under a menu
     */
    public function store(string $menuUuid, array $data): Category
    {
        $menu = Auth::user()
            ->menus()
            ->where('uuid', $menuUuid)
            ->firstOrFail();

        return $menu->categories()->create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Show single category
     */
    public function show(string $menuUuid, int $categoryId): Category
    {
        $menu = Auth::user()
            ->menus()
            ->where('uuid', $menuUuid)
            ->firstOrFail();

        return $menu->categories()
            ->where('id', $categoryId)
            ->firstOrFail();
    }

    /**
     * Update category
     */
    public function update(string $menuUuid, int $categoryId, array $data): Category
    {
        $category = $this->show($menuUuid, $categoryId);

        $category->update([
            'name' => $data['name'] ?? $category->name,
        ]);

        return $category;
    }

    /**
     * Delete category
     */
    public function destroy(string $menuUuid, int $categoryId): bool
    {
        return $this->show($menuUuid, $categoryId)->delete();
    }
}
