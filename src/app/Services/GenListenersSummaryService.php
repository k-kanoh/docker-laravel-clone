<?php declare(strict_types=1);

namespace App\Services;

use App\Enums\ListenersSummaryMode;
use App\Exceptions\RecordNotFoundException;
use App\Repositories\Interfaces\IGenListenersSummaryRepository;
use InvalidArgumentException;

class GenListenersSummaryService
{
    private $repository;

    public function __construct(IGenListenersSummaryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getSummaryData(ListenersSummaryMode $mode, $ymd)
    {
        return match ($mode) {
            ListenersSummaryMode::SummaryRecentHourly => $this->getSummaryRecentHourly($ymd),
            ListenersSummaryMode::SummaryRecentDaily => $this->getSummaryRecentDaily($ymd),
            ListenersSummaryMode::SummaryRecentMonthly => $this->getSummaryRecentMonthly($ymd),
            ListenersSummaryMode::SummaryOverallHourly => $this->getSummaryOverallHourly(),
            ListenersSummaryMode::SummaryOverallWeekly => $this->getSummaryOverallWeekly(),
        };
    }

    private function getSummaryRecentHourly($ymd)
    {
        if (strlen($ymd) < 8) {
            throw new InvalidArgumentException('Invalid ymd format.');
        }

        $dbRes = $this->repository->getSummaryRecentHourly($ymd);

        if ($dbRes->isEmpty()) {
            throw new RecordNotFoundException();
        }

        $summary = array_fill_keys(range(0, 23), '0');

        foreach ($dbRes as $item) {
            $summary[$item->h] = $item->listeners;
        }

        return $summary;
    }

    private function getSummaryRecentDaily($ymd)
    {
        if (strlen($ymd) < 6) {
            throw new InvalidArgumentException('Invalid ymd format.');
        }

        $dbRes = $this->repository->getSummaryRecentDaily($ymd);

        if ($dbRes->isEmpty()) {
            throw new RecordNotFoundException();
        }

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)substr($ymd, 4, 2), (int)substr($ymd, 0, 4));

        $summary = array_fill_keys(range(0, $daysInMonth), '0');

        foreach ($dbRes as $item) {
            $summary[$item->d] = $item->listeners;
        }

        return $summary;
    }

    private function getSummaryRecentMonthly($ymd)
    {
        $dbRes = $this->repository->getSummaryRecentMonthly($ymd);

        if ($dbRes->isEmpty()) {
            throw new RecordNotFoundException();
        }

        $summary = array_fill_keys(range(0, 12), '0');

        foreach ($dbRes as $item) {
            $summary[$item->m] = $item->listeners;
        }

        return $summary;
    }

    private function getSummaryOverallHourly()
    {
        return $this->repository->getSummaryOverallHourly();
    }

    private function getSummaryOverallWeekly()
    {
        return $this->repository->getSummaryOverallWeekly();
    }
}
