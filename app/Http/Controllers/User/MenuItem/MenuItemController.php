<?php

namespace App\Http\Controllers\User\MenuItem;

use App\Http\Controllers\Controller;
use App\Services\User\MenuItem\MenuItemService;
use App\Http\Requests\MenuItem\StoreMenuItemRequest;
use App\Http\Requests\MenuItem\UpdateMenuItemRequest;
use Illuminate\Support\Facades\Storage;


class MenuItemController extends Controller
{

    public function __construct(
        protected MenuItemService $menuItemService
    ) {}

    /**
     * GET
     * /menus/{menuUuid}/categories/{categoryId}/items
     */
    public function index(
        string $menuUuid,
        int $categoryId
    ) {
        $items = $this->menuItemService->index(
            $menuUuid,
            $categoryId
        );

        return $this->successResponse($items,statusCode:200);
    }

    /**
     * POST
     * /menus/{menuUuid}/categories/{categoryId}/items
     */
    public function store(
        StoreMenuItemRequest $request,
        string $menuUuid,
        int $categoryId
    ) {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('menu-items', 'public');
        }

        $item = $this->menuItemService->store(
            $menuUuid,
            $categoryId,
            $data
        );

        return $this->successResponse($item,statusCode:201);
    }

    /**
     * GET
     * /menus/{menuUuid}/categories/{categoryId}/items/{itemId}
     */
    public function show(
        string $menuUuid,
        int $categoryId,
        int $itemId
    ) {
        $item = $this->menuItemService->show(
            $menuUuid,
            $categoryId,
            $itemId
        );

        return $this->successResponse($item,statusCode:200);
    }

    /**
     * PUT / PATCH
     * /menus/{menuUuid}/categories/{categoryId}/items/{itemId}
     */
    public function update(
        UpdateMenuItemRequest $request,
        string $menuUuid,
        int $categoryId,
        int $itemId
    ) {
        $data = $request->validated();

        $item = $this->menuItemService->show(
            $menuUuid,
            $categoryId,
            $itemId
        );

        // Replace image if uploaded
        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $data['image'] = $request->file('image')
                ->store('menu-items', 'public');
        }

        $updatedItem = $this->menuItemService->update(
            $menuUuid,
            $categoryId,
            $itemId,
            $data
        );

        return $this->successResponse($updatedItem,statusCode:200);
    }

    /**
     * DELETE
     * /menus/{menuUuid}/categories/{categoryId}/items/{itemId}
     */
    public function destroy(
        string $menuUuid,
        int $categoryId,
        int $itemId
    ) {
        $item = $this->menuItemService->show(
            $menuUuid,
            $categoryId,
            $itemId
        );

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $this->menuItemService->destroy(
            $menuUuid,
            $categoryId,
            $itemId
        );

        return $this->successResponse(statusCode:204);
    }
}
