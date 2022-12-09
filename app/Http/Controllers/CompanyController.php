<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = \App\Models\Company::all();
        return [
            'count' => count($data),
            'rows' => $data
        ];
    }

    public function search(Request $request)
    {

        $collection =  \App\Models\Company::orderBy('created_at', 'desc');
        $dateRange = trim(urldecode($_GET['dateRange'] ?? ''));
        $searchQuery = trim(urldecode($_GET['searchValue'] ?? ''));
        if (!empty($searchQuery)) {
            $collection = $collection->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('email', 'like', '%' . $searchQuery . '%');
            });
        }

        if (!empty($dateRange)) {
            $dateRange = explode(',', $dateRange);

            $collection = $collection->where(function ($query) use ($dateRange) {
                $query->whereBetween('established_on',  $dateRange);
            });
        }

        $data = $collection->get();
        return [
            'count' => count($data),
            'rows' => $data,
        ];
    }
}
