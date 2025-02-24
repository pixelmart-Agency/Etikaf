<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

class DataTableService
{
    public $hasEdit = true;
    public $hasDelete = true;
    public $hasActivities = true;
    public $route = true;
    public $columns = [];
    public $query;
    public $resource;
    public function __construct() {}
    public function setHasEdit(bool $hasEdit = true)
    {
        $this->hasEdit = $hasEdit;
    }
    public function setHasDelete(bool $hasDelete = true)
    {
        $this->hasDelete = $hasDelete;
    }
    public function setHasActivities(bool $hasActivities = true)
    {
        $this->hasActivities = $hasActivities;
    }
    public function setRoute($route)
    {
        $this->route = $route;
    }
    public function setResource($resource)
    {
        $this->resource = $resource;
    }
    public function setQuery($query)
    {
        $this->query = $query;
    }
    public function createDataTable()
    {
        $user = user();
        $model = routeConfig();
        $query = $this->query;
        $resource = $this->resource;
        $resourceData = $resource::collection($query);
        return DataTables::of($resourceData->toArray(request()))
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($model, $user) {
                $actionButtons = '';
                if ($this->hasEdit && $user->hasPermissionTo($model->module_name . '.list')) {
                    $actionButtons .= '<a href="' . route($this->route . '.add', $row['id']) . '" class="btn btn-sm btn-success">' . __('translation.Edit') . '</a> ';
                }
                if ($this->hasDelete  && $user->hasPermissionTo($model->module_name . '.delete')) {
                    $actionButtons .= '<a hrefurl="' . route($this->route . '.delete', $row['id']) . '" onclick="return confirmDelete(this)" class="btn btn-sm btn-danger">' . __('translation.Delete') . '</a>';
                }
                if ($this->hasActivities && $user->hasPermissionTo($model->module_name . '.activities')) {
                    $actionButtons .= ' <a href="' . route($this->route . '.activities', $row['id']) . '" class="btn btn-sm btn-info">' . __('translation.Activities') . '</a>';
                }
                return $actionButtons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
