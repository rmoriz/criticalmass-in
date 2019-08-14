<?php declare(strict_types=1);

namespace App\Criticalmass\Heatmap\Generator;

use App\Criticalmass\Heatmap\HeatmapInterface;

interface HeatmapGeneratorInterface
{
    public function generate(): HeatmapGeneratorInterface;
    public function setHeatmap(HeatmapInterface $heatmap): HeatmapGeneratorInterface;
    public function setPaintedTracks(int $paintedTracks): HeatmapGeneratorInterface;
    public function setMaxPaintedTracks(int $maxPaintedTracks): HeatmapGeneratorInterface;
    public function setCallback(callable $callback): HeatmapGeneratorInterface;
}
