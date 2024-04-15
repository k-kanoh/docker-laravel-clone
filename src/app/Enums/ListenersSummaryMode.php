<?php declare(strict_types=1);

namespace App\Enums;

enum ListenersSummaryMode : string
{
    case SummaryRecentHourly = 'recentHourly';
    case SummaryRecentDaily = 'recentDaily';
    case SummaryRecentMonthly = 'recentMonthly';
    case SummaryOverallHourly = 'overallHourly';
    case SummaryOverallWeekly = 'overallWeekly';
}
