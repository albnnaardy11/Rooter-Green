<?php

namespace App\Repositories\Contracts;

interface AiIntelligenceRepositoryInterface
{
    public function getHeatmapData();
    public function getMaterialDistribution();
    public function getContextualStats();
    public function getConversionStats();
    public function getSeasonalTrends();
    public function getExportData($severity = ['A', 'B']);
}
