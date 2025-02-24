<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\Export\CountryResource as CountryExportResource;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::query()->filter()->get();
        $countries = CountryResource::collection($countries);
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        $country = new Country();

        return view('admin.countries.edit', compact('country'));
    }

    public function store(CountryRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $country = Country::create($request->validated());
            return redirect()->route('countries.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('countries.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(Country $country)
    {
        $country = CountryResource::make($country);
        return view('admin.countries.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $country) {
                return $this->update($request, $country, false);
            });
        }
        try {
            $country->update($request->validated());
            return redirect()->route('countries.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('countries.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $countries = Country::query()->filter()->get();
        $countries = CountryExportResource::collection($countries);
        return $countries->toArray(request());
    }
}
