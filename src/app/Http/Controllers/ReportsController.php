<?php

namespace App\Http\Controllers;

use App\Models\MonitoringData;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function showReportsPage(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $date = $request->query('date');

        $query = Report::query();

        $searchQuery = $date
            ? $query->where('date', $date)
            : $query;

        $result = $searchQuery->orderBy('id', 'desc')->paginate(5);

        return view('reports', ['reports' => $result]);
    }

    public function showReport(int $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $report = Report::query()->findOrFail($id);
        return view('report', ['report' => $report]);
    }
}
