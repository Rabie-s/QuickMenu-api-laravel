<?php

namespace App\Http\Controllers\User\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\Menu\MenuService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;

class MenuController extends Controller
{

    public function __construct(
        private MenuService $menuService
    ) {}

    /**
     * GET /menus
     * Paginated menus
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $menus = $this->menuService->index($perPage);

        return $this->successResponse($menus, statusCode: 200);
    }

    /**
     * POST /menus
     * Create a new menu with optional cover image
     */
    public function store(StoreMenuRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('menus', 'public');
        }

        $menu = $this->menuService->store($data);

        return $this->successResponse($menu, statusCode: 201);
    }

    /**
     * GET /menus/{uuid}
     * Show a single menu
     */
    public function show(string $uuid)
    {
        $menu = $this->menuService->show($uuid);

        return $this->successResponse($menu, statusCode: 200);
    }

    /**
     * PUT/PATCH /menus/{uuid}
     * Update menu with optional new cover image
     */
    public function update(UpdateMenuRequest $request, string $uuid)
    {
        $data = $request->validated();

        $menu = $this->menuService->show($uuid);

        // Replace cover image if uploaded
        if ($request->hasFile('cover_image')) {
            if ($menu->cover_image) {
                Storage::disk('public')->delete($menu->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('menus', 'public');
        }

        $updatedMenu = $this->menuService->update($uuid, $data);

        return $this->successResponse($updatedMenu, statusCode: 200);
    }

    /**
     * DELETE /menus/{uuid}
     * Delete a menu and its cover image
     */
    public function destroy(string $uuid)
    {
        $menu = $this->menuService->show($uuid);

        if ($menu->cover_image) {
            Storage::disk('public')->delete($menu->cover_image);
        }

        $this->menuService->destroy($uuid);

        return $this->successResponse(statusCode: 204);
    }
}
