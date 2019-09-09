<?php

namespace App\Core\Presenter;

use App\Core\Model\Report;

class ReportPresenter
{
    public function pushContent(Report $report): void
    {
        echo $this->table($report->getDiff()->getAll());
    }

    private function table($data): string
    {
        $response = '';

        foreach ($data as $key => $diffs)
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
