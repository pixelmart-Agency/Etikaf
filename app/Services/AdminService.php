<?php

namespace App\Services;

use App\Enums\ProgressStatusEnum;
use App\Models\RetreatService;
use App\Models\User;

class AdminService
{
    protected $retreatRequestService;
    public function __construct(RetreatRequestService $retreatRequestService)
    {
        $this->retreatRequestService = $retreatRequestService;
    }
    public function requestsStats()
    {
        $statuses = [
            ProgressStatusEnum::PENDING->value => 'newRequests',
            ProgressStatusEnum::APPROVED->value => 'approvedRequests',
            ProgressStatusEnum::COMPLETED->value => 'completedRequests',
            ProgressStatusEnum::CANCELLED->value => 'canceledRequests',
            ProgressStatusEnum::REJECTED->value => 'rejectedRequests',
        ];

        $requests = [];

        foreach ($statuses as $status => $variableName) {
            $requests[$variableName] = $this->retreatRequestService->getRetreatRequests(null, ['status' => $status], true);
        }
        $requests['usersCount'] = User::query()->users()->count();
        $requests['employeesCount'] = User::query()->employees()->count();
        $requests['servicesCount'] = RetreatService::query()->count();
        $requests['surveysCount'] = RetreatService::query()->count();
        return $requests;
    }
}
