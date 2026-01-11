<?php

namespace App\Services\User\MenuItem;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuItem;

class MenuItemService
{
    /**
     * Get paginated menu items for a category
     */
    public function index(
        string $menuUuid,
        int $categoryId,
        int $perPage = 10
    ): LengthAwarePaginator {
        $category = Auth::user()
            ->menus()
            ->where('uuid', $menuUuid)
            ->firstOrFail()
            ->categories()
            ->where('id', $categoryId)
            ->firstOrFail();

        return $category->menuItems()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create menu item under category
     */
    public function store(
        string $menuUuid,
        int $categoryId,
        array $data
    ): MenuItem {
        $category = Auth::user()
            ->menus()
            ->where('uuid', $menuUuid)
            ->firstOrFail()
            ->categories()
            ->where('id', $categoryId)
            ->firstOrFail();

        return $category->menuItems()->create([
            'name'         => $data['name'],
            'price'        => $data['price'],
            'description'  => $data['description'] ?? null,
            'image'        => $data['image'] ?? null,
            'is_available' => $data['is_available'] ?? true,
        ]);
    }

    /**
     * Show single menu item
     */
    public function show(
        string $menuUuid,
        int $categoryId,
        int $itemId
    ): MenuItem {
        return Auth::user()
            ->menus()
            ->where('uuid', $menuUuid)
            ->firstOrFail()
            ->categories()
            ->where('id', $categoryId)
            ->firstOrFail()
            ->menuItems()
            ->where('id', $itemId)
            ->firstOrFail();
    }

    /**
     * Update menu item
     */
    public function update(
        string $menuUuid,
        int $categoryId,
        int $itemId,
        array $data
    ): MenuItem {
        $item = $this->show($menuUuid, $categoryId, $itemId);

        $item->update([
            'name'         => $data['name'] ?? $item->name,
            'price'        => $data['price'] ?? $item->price,
            'description'  => $data['description'] ?? $item->description,
            'image'        => $data['image'] ?? $item->image,
            'is_available' => $data['is_available'] ?? $item->is_available,
        ]);

        return $item;
    }

    /**
     * Delete menu item
     */
    public function destroy(
        string $menuUuid,
        int $categoryId,
        int $itemId
    ): bool {
        return $this->show($menuUuid, $categoryId, $itemId)->delete();
    }
}
