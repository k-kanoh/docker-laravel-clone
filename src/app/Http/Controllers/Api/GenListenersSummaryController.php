<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\ListenersSummaryMode;
use App\Http\Controllers\Controller;
use App\Services\GenListenersSummaryService;
use InvalidArgumentException;

class GenListenersSummaryController extends Controller
{
    private $service;

    public function __construct(GenListenersSummaryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $ymd = $this->getYmdFromRequest();
            $mode = $this->getModeFromRequest();
            $data = $this->service->getSummaryData($mode, $ymd);

            return response()->json($data);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    private function getYmdFromRequest() : string
    {
        $ymd = request()->input('ymd', date('Ymd'));

        if (!preg_match('/^(\d{4})(\d{2})?(\d{2})?$/', $ymd ?? '', $matches)) {
            throw new InvalidArgumentException('Invalid ymd format.');
        }

        $year = (int)$matches[1];
        $month = (int)($matches[2] ?? 1);
        $day = (int)($matches[3] ?? 1);

        if (!checkdate($month, $day, $year)) {
            throw new InvalidArgumentException('Invalid date.');
        }

        return $ymd;
    }

    private function getModeFromRequest() : ListenersSummaryMode
    {
        $mode = request()->input('mode', ListenersSummaryMode::SummaryRecentHourly->value);

        return match ($mode) {
            ListenersSummaryMode::SummaryRecentHourly->value => ListenersSummaryMode::SummaryRecentHourly,
            ListenersSummaryMode::SummaryRecentDaily->value => ListenersSummaryMode::SummaryRecentDaily,
            ListenersSummaryMode::SummaryRecentMonthly->value => ListenersSummaryMode::SummaryRecentMonthly,
            ListenersSummaryMode::SummaryOverallHourly->value => ListenersSummaryMode::SummaryOverallHourly,
            ListenersSummaryMode::SummaryOverallWeekly->value => ListenersSummaryMode::SummaryOverallWeekly,
            default => throw new InvalidArgumentException('Invalid mode.'),
        };
    }
}
