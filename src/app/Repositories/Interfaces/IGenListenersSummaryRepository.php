<?php declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface IGenListenersSummaryRepository
{
    public function getSummaryRecentHourly($ymd);

    public function getSummaryRecentDaily($ymd);

    public function getSummaryRecentMonthly($ymd);

    public function getSummaryOverallHourly();

    public function getSummaryOverallWeekly();
}
