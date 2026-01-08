<?php

namespace App\Services\User\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MenuService
{
    /**
     * Get paginated menus for logged-in user
     */
    public function index(int $perPage = 10): LengthAwarePaginator
    {
        return Auth::user()
            ->menus()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create new menu
     */
    public function store(array $data): Menu
    {
        return Auth::user()
            ->menus()
            ->create([
                'name'         => $data['name'],
                'cover_image'  => $data['cover_image'] ?? null,
                'is_available' => $data['is_available'] ?? true,
            ]);
    }

    /**
     * Show menu by UUID (only user's menus)
     */
    public function show(string $uuid): Menu
    {
       
        return Auth::user()
            ->menus()
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    /**
     * Update menu
     */
    public function update(string $uuid, array $data): Menu
    {
        $menu = $this->show($uuid);

        $menu->update([
            'name'         => $data['name'] ?? $menu->name,
            'cover_image'  => $data['cover_image'] ?? $menu->cover_image,
            'is_available' => $data['is_available'] ?? $menu->is_available,
        ]);

        return $menu;
    }

    /**
     * Delete menu
     */
    public function destroy(string $uuid): bool
    {
        return $this->show($uuid)->delete();
    }
}
