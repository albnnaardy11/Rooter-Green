<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AiIntelligenceRepositoryInterface;
use Illuminate\Http\Request;

class AiIntelligenceController extends Controller
{
    protected $repo;

    public function __construct(AiIntelligenceRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $heatmapData = $this->repo->getHeatmapData();
        $materials = $this->repo->getMaterialDistribution();
        $contextStats = $this->repo->getContextualStats();
        $conversion = $this->repo->getConversionStats();
        $trends = $this->repo->getSeasonalTrends();

        return view('admin.ai-intelligence.index', compact(
            'heatmapData', 'materials', 'contextStats', 'conversion', 'trends'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'csv');
        $data = $this->repo->getExportData();

        if ($type === 'csv') {
            $filename = "rooterin_priority_leads_" . date('Y-m-d') . ".csv";
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $columns = ['Diagnose ID', 'Label', 'Score', 'Material', 'Context', 'City', 'Date'];

            $callback = function() use($data, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($data as $lead) {
                    fputcsv($file, [
                        $lead->diagnose_id,
                        $lead->result_label,
                        $lead->final_deep_score,
                        $lead->material_type,
                        $lead->location_context,
                        $lead->city_location,
                        $lead->created_at
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Format not supported yet.');
    }
}
