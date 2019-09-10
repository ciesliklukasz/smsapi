<?php

namespace App\Core\Presenter;

use App\Core\Model\Report;

class ReportPresenter
{
    public function pushContent(Report $report): void
    {
        echo $this->table($report);
    }

    private function table(Report $report): string
    {
        $response = '';
        $response.= 'File path: ' . $report->getFile()->getFilePath() . PHP_EOL;
        $response.= 'File size: ' . $report->getFile()->getSize() . PHP_EOL;

        foreach ($report->getDiff()->getAll() as $key => $diffs)
        {
            $response .= 'Compared file: ' . $key . PHP_EOL;
            foreach ($diffs as $diff)
            {
                $response .= $diff;
            }

            $response .= PHP_EOL;
        }

        return $response;
    }
}
