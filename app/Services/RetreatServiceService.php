<?php

namespace App\Services;

use App\Enums\ProgressStatusEnum;
use App\Enums\UserTypesEnum;
use App\Http\Resources\RetreatServiceResource;
use App\Models\OnboardingScreen;
use App\Models\RetreatService;
use App\Models\RetreatServiceCategory;
use App\Models\RetreatInstruction;
use App\Models\RetreatRequestServiceModel;
use App\Models\SupportService;
use Illuminate\Support\Facades\Auth;

class RetreatServiceService
{

    public function getRetreatServiceCategories($perPage = 10)
    {
        return RetreatServiceCategory::query()->filter()->paginate($perPage);
    }
    public function getRetreatServices($perPage = 10)
    {
        return RetreatService::query()->filter()->paginate($perPage);
    }
    public function getRetreatServicesGroupedByCategory($perPage = 10, $is_paginated = false)
    {
        $retreatServiceCategories = RetreatServiceCategory::query()->whereHas('retreatServices')->filter()->get();
        $groupedServices = [];
        foreach ($retreatServiceCategories as $retreatServiceCategory) {
            $groupedService = [];

            $services = RetreatService::query()->filter(['retreat_service_category_id' => $retreatServiceCategory->id]);

            if ($is_paginated === true) {
                $services = $services->paginate($perPage);
            } else {
                $services = $services->get();
            }

            $groupedService['category_name'] = getTransValue($retreatServiceCategory->name);
            $groupedService['services'] = RetreatServiceResource::collection($services);
            $groupedServices[] = $groupedService;
        }

        return $groupedServices;
    }



    public function getRetreatInstructions($perPage = 10)
    {
        return RetreatInstruction::query()->filter()->paginate($perPage);
    }
    public function getSupportServices($perPage = 10)
    {
        return SupportService::query()->supportServices()->filter()->paginate($perPage);
    }
    public function getInRetreatServices($perPage = 10)
    {
        return SupportService::query()->inRetreatServices()->filter()->paginate($perPage);
    }
    public function getOnboardingScreens($perPage = 10)
    {
        return OnboardingScreen::query()->filter()->paginate($perPage);
    }
    public function getRetreatRequestServices($perPage = 10, $status = null, $is_count, $api = false, $is_paginated = true)
    {
        $user = user();
        $query = RetreatRequestServiceModel::query()->eagerLoadData();

        if ($is_count) {
            return ($user->user_type == UserTypesEnum::EMPLOYEE->value && !$user->hasPermissionTo('retreat-service-requests'))
                ? 0
                : $query->filter(['status' => $status])->employeeRequests()->count();
        }

        // تحقق من صلاحيات الموظف
        $statusFilter = ($user->user_type == UserTypesEnum::EMPLOYEE->value && !$user->hasPermissionTo('retreat-service-requests'))
            ? 'none'
            : $status;

        $query->filter(['status' => $statusFilter])->employeeRequests();

        return $is_paginated ? $query->paginate($perPage) : $query->get();
    }
}
