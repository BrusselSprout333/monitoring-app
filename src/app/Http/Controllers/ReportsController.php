<?php

namespace App\Http\Controllers;

use App\Models\MonitoringData;
use App\Models\Report;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function showReportsPage(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $date = $request->query('date');

        $query = Report::query()->where('userId', Auth::user()->id);

        $searchQuery = $date
            ? $query->where('date', $date)
            : $query;

        $result = $searchQuery->orderBy('id', 'desc')->paginate(5);

        return view('reports', ['reports' => $result, 'date' => $date]);
    }

    public function showReport(int $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $report = Report::query()->findOrFail($id);
        return view('report', ['report' => $report]);
    }
}
