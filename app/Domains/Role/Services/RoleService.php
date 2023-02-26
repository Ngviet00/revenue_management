<?php

namespace App\Domains\Role\Services;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleService extends BaseService
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @return array|Collection|Role[]
     */
    public function getListRole(): Collection|array
    {
        return $this->model::all() ?? [];
    }

    public function getMaxId()
    {
        return $this->model->query()->max('id') + 1;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateOrCreate($data): bool
    {
        try {
            DB::beginTransaction();
            $this->model->updateOrCreate(['id' => $data['id']], $data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

}
