<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class TranslationController extends Controller
{
    public function edit($lang = 'ar')
    {
        try {
            if (request()->has('words')) {
                $words = request('words');
                $trans = request('trans');

                // Path to the translation file
                $filePath = base_path() . '/lang/' . $lang . '/translation.php';

                // Check if the file exists and load its current contents
                if (file_exists($filePath)) {
                    $currentTranslations = include($filePath);
                } else {
                    // If the file doesn't exist, initialize as an empty array
                    $currentTranslations = [];
                }

                // Update only the requested translations
                for ($i = 0; $i < count($words); $i++) {
                    $currentTranslations[$words[$i]] = $trans[$i];
                }

                // Generate the updated PHP content
                $content = "<?php return " . var_export($currentTranslations, true) . " ; ?>";

                // Write the updated content back to the file
                file_put_contents($filePath, $content);

                // Prepare and return a success message
                $message = __('translation.Updated successfully');
                return redirect()->route('translations.edit', $lang)->with('success', $message);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        // $words = file_get_contents(base_path().'/lang/'.$lang.'/translation.php');
        $data = require_once(base_path() . '/lang/' . $lang . '/translation.php');
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

        // Apply filter to the data array if a filter keyword is provided
        if ($filter) {
            $filteredData = array_filter($data, function ($item) use ($filter) {
                return stripos($item, $filter) !== false; // Case-insensitive search
            });
        } else {
            $filteredData = $data;
        }
        // Get the current page from the query string, default to 1
        $page = request()->get('page', 1);
        $perPage = 50; // Number of items per page
        $currentPageData = array_slice($filteredData, ($page - 1) * $perPage, $perPage);
        $paginator = new LengthAwarePaginator(
            $currentPageData,
            count($data),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return view('admin.translations.add', ['words' => $paginator, 'lang' => $lang]);
    }
}
