<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Responses\SuccessResponse;

class CountryController extends Controller
{
    public function index()
    {
        $perPage = request()->get('per_page', 25);
        $countries = Country::filter()->orderBy('name->ar')->paginate($perPage);

        $groupedCountries = $countries->getCollection()->groupBy(function ($country) {
            return mb_substr($country->name['ar'], 0, 1);
        });

        $response = $groupedCountries->map(function ($group, $letter) {
            return [
                'letter' => $letter,
                'countries' => CountryResource::collection($group),
            ];
        })->values();
        $result = array(
            'countries' => $response,
            'pagination' => [
                'current_page' => $countries->currentPage(),
                'last_page' => $countries->lastPage(),
                'per_page' => $countries->perPage(),
                'total' => $countries->total(),
            ],
        );
        return SuccessResponse::send(
            $result,
            __('translation.countries_found'),
            200,
            false
        );
    }
}
