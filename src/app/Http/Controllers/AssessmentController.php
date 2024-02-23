<?php

namespace App\Http\Controllers;

use App\Services\AssessmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function __construct(
        private readonly AssessmentService $assessmentService
    ) {
    }

    public function showMonitorPage(Request $request)
    {
        $now = Carbon::now('Europe/Minsk');

        $request->validate([
            'temperature' => 'nullable|numeric|min:-40|max:40',
            'ventilation-time' => 'nullable|before_or_equal:' . $now,
            'break-time' => 'nullable|before_or_equal:' . $now,
            'water-time' => 'nullable|before_or_equal:' . $now,
        ]);

        $request->session()->put('assessment_form_data', $request->all());

        return view('camera-access');
    }

    public function processCameraAccess(Request $request)
    {
        $access = $request->input("webcamPermission");

        if($access === 'allow') {
            $pythonScriptPath = public_path('python/fast-monitor.py');
            exec("python3 $pythonScriptPath");
        }

        $request->session()->put('camera_data', $access === 'allow');

        return redirect()->route('monitorResults');
    }

    public function monitorResults()
    {
        $recommends = [];

        $cameraData = session('camera_data');
        $formData = session('assessment_form_data');

        if($formData) {
            $recommends = array_merge($recommends, $this->assessmentService->calculateRecommends($formData, $cameraData));
        }
        if($cameraData) {
            $recommends = array_merge($recommends, $this->assessmentService->calculateCameraRecommends(isset($formData)));
        }

        return view('monitor-results', ['recommends' => $recommends, 'comfortLevel' => round($this->assessmentService->comfortLevel)]);
    }
}
