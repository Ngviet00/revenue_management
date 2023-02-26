<?php

namespace App\Domains\Role\Controllers;

use App\Domains\Role\Services\RoleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected RoleService $roleService;

    const CREATE_SUCCESS = 'Thêm thành công!';
    const CREATE_FAILED = 'Thêm thất bại!';

    const DELETE_SUCCESS = 'Xoá thành công!';
    const DELETE_FAILED = 'Xoá thất bại!';

    const UPDATE_SUCCESS = 'Cập nhật thành công!';
    const UPDATE_FAILED = 'Cập nhật thất bại!';

    /**
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('backend.role.index')
                ->withUser(auth()->user())
                ->withRoles($this->roleService->getListRole());
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $maxId = $this->roleService->getMaxId();
        return view('backend.role.create', compact('maxId'));
    }

    /**
     * @param RoleRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(RoleRequest $request): Redirector|RedirectResponse|Application
    {
        if ( $this->roleService->updateOrCreate($request->all())) {
            session()->flash('success', self::CREATE_SUCCESS);
            return redirect(route('admin.role.index'));
        }
        session()->flash('error', self::CREATE_FAILED);
        return redirect(route('admin.role.index'));
    }

    /**
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role): View|Factory|Application
    {
        return view('backend.role.edit', compact('role'));
    }

    /**
     * @param Role $role
     * @return Application|RedirectResponse|Redirector
     * @throws \Exception
     */
    public function delete(Role $role): Redirector|RedirectResponse|Application
    {
        if ($this->roleService->deleteById($role['id'])) {
            session()->flash('success', self::DELETE_SUCCESS);
            return redirect(route('admin.role.index'));
        }
        session()->flash('error', self::DELETE_FAILED);
        return redirect(route('admin.role.index'));
    }

    /**
     * @param RoleRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(RoleRequest $request): Redirector|RedirectResponse|Application
    {
        if ($this->roleService->updateOrCreate($request->all())) {
            session()->flash('success', self::UPDATE_SUCCESS);
            return redirect(route('admin.role.index'));
        }
        session()->flash('error', self::UPDATE_FAILED);
        return redirect(route('admin.role.index'));
    }
}
