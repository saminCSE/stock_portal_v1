<?php

namespace App\Http\Controllers\Cron;

use App\Models\DataBanksEod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ScreenerScheduleSettingCronController extends Controller
{
    public function updateOrInsertRsiForPreviousDate(Request $request)
    {
        // Parse request parameters
        $startDate = $request->startDate;
        $previousDate = $request->previousDate;

        // $startDate = '2022-01-24';
        // $previousDate = '2022-01-22'; // Set the start date for updating or inserting RSI values
        $endDate = $previousDate;
        // $previousDate = '2021-12-01'; // Set the start date for updating or inserting RSI values

        // Loop until the previous date
        while ($previousDate < $startDate) {
            // Assuming today is 2022-01-24
            $this->updateOrInsertRsiForDate($previousDate);
            $previousDate = date('Y-m-d', strtotime($previousDate . ' +1 day'));
        }

        // return 'RSI update or insert for previous dates completed successfully';
        return "screener update or insert From $endDate to $startDate completed successfully";
    }

    public function insertRsiForToday()
    {
        $today = now()->toDateString(); // Get the current date
        // $today = '2022-01-24'; // Today's date for testing

        // Check if today's date exists in the table
        $recordExists = DataBanksEod::whereDate('date', '=', $today)->exists();

        // If today's date does not exist in the table, return a failure message
        if (!$recordExists) {
            return "RSI insert for $today not successful. $today does not exist in EOD table";
        } else {
            // Calculate and insert RSI for today
            $this->updateOrInsertRsiForDate($today);

            return 'RSI insert for ' . $today . ' completed successfully';
        }
    }

    public function updateOrInsertRsiForDate($date)
    {
        // Logic to calculate RSI for the given date
        $instrumentIds = DataBanksEod::pluck('instrument_id')->unique()->toArray();
        $chunkSize = 20; // Define the batch size

        // Split the instrument IDs into smaller batches
        $instrumentIdChunks = array_chunk($instrumentIds, $chunkSize);

        // Process each batch of instrument IDs
        foreach ($instrumentIdChunks as $chunk) {
            foreach ($chunk as $instrumentId) {
                $rsi = $this->calculateRSI($instrumentId, $date);

                // Update or insert RSI for the date if $rsi is not null
                if ($rsi !== null) {
                    DataBanksEod::updateOrCreate(['date' => $date, 'instrument_id' => $instrumentId], ['rsi' => $rsi]);
                }
            }
        }
    }

    private function calculateRSI($instrumentId, $date)
    {
        $priceData = DataBanksEod::select('close')
            ->where('instrument_id', $instrumentId)
            ->where('date', '<=', $date)
            // ->whereNotNull('close') // Ensures 'close' field is not null
            // ->whereDate('date', '=', $date) // Ensures the specified date exists in the table
            ->orderBy('date', 'desc')
            ->limit(360)
            ->get();

        if ($priceData->count() < 360) {
            return null; // Not enough data points for RSI calculation
        }

        $closePrices = array_reverse($priceData->pluck('close')->toArray());
        $rsiValues = [];

        for ($i = 1; $i < count($closePrices); $i++) {
            $change = $closePrices[$i] - $closePrices[$i - 1];
            $gain = $change > 0 ? $change : 0;
            $loss = $change < 0 ? abs($change) : 0;

            $rsiValues[] = ['gain' => $gain, 'loss' => $loss];
        }

        $firstAvgGain = array_sum(array_column(array_slice($rsiValues, 0, 14), 'gain')) / 14;
        $firstAvgLoss = array_sum(array_column(array_slice($rsiValues, 0, 14), 'loss')) / 14;

        $prevAvgGain = $firstAvgGain;
        $prevAvgLoss = $firstAvgLoss;

        for ($j = 15; $j < count($rsiValues); $j++) {
            $avgGain = ($prevAvgGain * 13 + $rsiValues[$j]['gain']) / 14;
            $avgLoss = ($prevAvgLoss * 13 + $rsiValues[$j]['loss']) / 14;

            $rs = $avgLoss != 0 ? $avgGain / $avgLoss : INF;
            $rsi = 100 - 100 / (1 + $rs);

            $prevAvgGain = $avgGain;
            $prevAvgLoss = $avgLoss;
        }

        return $rsi;
    }
}
