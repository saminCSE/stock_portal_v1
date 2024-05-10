<?php

namespace App\Http\Controllers\Api;

use App\Models\Market;
use App\Models\Instrument;
use App\Models\DataBanksEod;
use Illuminate\Http\Request;
use App\Models\DataBanksIntraday;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ScreenerApiController extends Controller
{
    public function screenerGenerate(Request $request)
    {
        // Parse request parameters
        $today = $request->tdate;
        $trade_batch = $request->trade_batch;

        // // Parse request parameters
        // $day = $request->day;
        // // Get the trade dates from the markets table in descending order
        // $tradeDates = Market::orderBy('trade_date', 'desc')->offset($day)->limit(1)->pluck('trade_date');
        // // dd($tradeDates);

        // // Check if there are any trade dates
        // if ($tradeDates->isEmpty()) {
        //     // No trade dates found in the markets table
        //     $response = [
        //         'data' => (object) [],
        //         'status' => 'success',
        //     ];
        //     return response()->json($response);
        // }

        // // Select the trade date based on the $day index
        // $todayIndex = min($day, $tradeDates->count() - 1); // Ensure $todayIndex does not exceed available trade dates
        // $today = $tradeDates[$todayIndex];
        // // dd($today);
        // // Ensure that $today is a trading day
        // $today = Market::where('trade_date', '<=', $today)->where('is_trading_day', 1)->orderBy('trade_date', 'desc')->value('trade_date');
        // dd($today);

        if (!$today) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('date', $today)->exists();
        // dd($dateCheck);

        if (!$dateCheck) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        // $operation = 'less than';
        $id = '2';

        // Fetch filter options from the database
        $filterOptions = DB::table('stock_screeners')
            ->where('status', 1) // Only active screeners
            ->where('user_status', 1) // Only active user screeners
            // ->whereJsonContains('filter_option', [['operation' => $operation]]) // Filter by operation
            ->whereJsonContains('filter_option', [['id' => $id]]) // Filter by operation
            ->get(['filter_option']);
        // dd($filterOptions);

        $screenedData = [];

        // Mapping of operations
        $operations = [
            'equals' => '=',
            'not equals' => '!=',
            'greater than' => '>',
            'greater than equal to' => '>=',
            'less than' => '<',
            'less than equal to' => '<=',
            'cross above' => 'cross above',
            'crossed below' => 'crossed below',
            'same date of' => 'same date of',
            'same month of' => 'same month of',
            'same year of' => 'same year of',
            'before' => 'before',
            'after' => 'after',
        ];

        foreach ($filterOptions as $option) {
            $filter = json_decode($option->filter_option, true)[0];
            $indicator1 = $filter['indicator_1'];
            $operation = $filter['operation'];
            $indicator2 = $filter['indicator_2'];

            // Check if operation is valid
            if (!array_key_exists($operation, $operations)) {
                continue; // Skip if operation is invalid
            }

            // Query instruments
            // $instruments = Instrument::all();
            $instruments = Instrument::select('id', 'instrument_code as name')
                // ->offset($offset)
                // ->limit($limit)
                ->get();
            // $instruments = collect([
            //     ['id' => 12, 'instrument_code' => 'ABBANK'],
            //     // ['id' => 30024, 'instrument_code' => 'ACMELAB'],
            //     // ['id' => 2, 'instrument_code' => 'PTL']
            // ]);

            foreach ($instruments as $instrument) {
                // Calculate indicator value based on indicator name
                // $indicatorValue = $this->calculateIndicatorValue($instrument['id'], $today, $trade_batch, $indicator1);
                $indicator1Value = is_numeric($indicator1) ? $indicator1 : $this->calculateIndicatorValue($instrument['id'], $today, $trade_batch, $indicator1);
                $indicator2Value = is_numeric($indicator2) ? $indicator2 : $this->calculateIndicatorValue($instrument['id'], $today, $trade_batch, $indicator2);

                // Apply operation based on the operation type
                if ($this->applyOperation($indicator1Value, $operation, $indicator2Value)) {
                    // Additional screening criteria and calculations here

                    // Add instrument data to the screened data array
                    $screenedData[] = [
                        'instrument' => $instrument,
                        'date' => $today,
                        'indicator1' => $indicator1,
                        'indicator1Value' => $indicator1Value,
                        'operation' => $operation,
                        'indicator2Value' => $indicator2Value,
                        // Add other calculated values as needed
                    ];
                }
            }
        }

        // Return the screened data as JSON response
        return response()->json(['data' => $screenedData, 'status' => 'success']);
    }

    // Function to calculate indicator value based on indicator name
    private function calculateIndicatorValue($instrumentId, $today, $trade_batch, $indicator)
    {
        switch ($indicator) {
            case 'RSI':
                return $this->calculateRSI($instrumentId, $today, $trade_batch);
                // Add cases for other indicators
            default:
                return null; // Return null for unknown indicators
        }
    }

    // Function to apply operation based on operation type
    private function applyOperation($value1, $operation, $value2)
    {
        switch ($operation) {
            case 'equals':
                return $value1 == $value2;
            case 'not equals':
                return $value1 != $value2;
            case 'greater than':
                return $value1 > $value2;
            case 'greater than equal to':
                return $value1 >= $value2;
            case 'less than':
                return $value1 < $value2;
            case 'less than equal to':
                return $value1 <= $value2;
                // Add cases for other operations
            default:
                return false; // Return false for invalid operations
        }
    }

    public function screenerBoard(Request $request)
    {
        // Parse request parameters
        $today = $request->tdate;
        $trade_batch = $request->trade_batch;

        // // Parse request parameters
        // $day = $request->day;
        // // Get the trade dates from the markets table in descending order
        // $tradeDates = Market::orderBy('trade_date', 'desc')->offset($day)->limit(1)->pluck('trade_date');
        // // dd($tradeDates);

        // // Check if there are any trade dates
        // if ($tradeDates->isEmpty()) {
        //     // No trade dates found in the markets table
        //     $response = [
        //         'data' => (object) [],
        //         'status' => 'success',
        //     ];
        //     return response()->json($response);
        // }

        // // Select the trade date based on the $day index
        // $todayIndex = min($day, $tradeDates->count() - 1); // Ensure $todayIndex does not exceed available trade dates
        // $today = $tradeDates[$todayIndex];
        // // dd($today);
        // // Ensure that $today is a trading day
        // $today = Market::where('trade_date', '<=', $today)->where('is_trading_day', 1)->orderBy('trade_date', 'desc')->value('trade_date');
        // dd($today);

        if (!$today) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('date', $today)->exists();
        // dd($dateCheck);

        if (!$dateCheck) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        // $page = $request->page;
        // $limit = 30;
        // $offset = ($page - 1) * $limit;

        // Query instruments
        // $instruments = Instrument::all();
        $instruments = Instrument::select('id', 'instrument_code as name')
            // ->offset($offset)
            // ->limit($limit)
            ->get();
        // $instruments = collect([
        //     ['id' => 12, 'instrument_code' => 'ABBANK'],
        //     // ['id' => 30024, 'instrument_code' => 'ACMELAB'],
        //     // ['id' => 2, 'instrument_code' => 'PTL']
        // ]);

        $screenedData = [];

        foreach ($instruments as $instrument) {
            // Calculate RSI
            // $rsi = $this->calculateRSI($instrument->id, $today, $trade_batch);
            $rsi = $this->calculateRSI($instrument['id'], $today, $trade_batch);
            $mfi = $this->calculateMFI($instrument['id'], $today, $trade_batch);
            $ma = $this->calculateMA($instrument['id'], $today, $trade_batch);
            $macd = $this->calculateMACD($instrument['id'], $today, $trade_batch);
            $ema = $this->calculateEMA($instrument['id'], $today, $trade_batch);
            $sma = $this->calculateSMA($instrument['id'], $today, $trade_batch);

            // additional screening criteria and calculations here

            // Add instrument data to the screened data array
            $screenedData[] = [
                'instrument' => $instrument,
                'date' => $today,
                'rsi' => $rsi,
                'mfi' => $mfi,
                'ma' => $ma,
                'macd' => $macd,
                'ema' => $ema,
                'sma' => $sma,
            ];
        }

        // Return the screened data as JSON response
        return response()->json(['data' => $screenedData, 'status' => 'success']);
    }

    private function fetchLastTradedPrice($closePrices, $numDays, $instrumentId, $today)
    {
        // Check if today's close price is zero or less
        if ($closePrices[$numDays - 1] <= 0) {
            // Fetch last traded price from intraday data for today
            $lastTradedPrice = DataBanksIntraday::where('instrument_id', $instrumentId)->where('trade_date', '=', $today)->orderBy('id', 'desc')->value('pub_last_traded_price');

            // If last traded price is available, use it as today's close price
            if ($lastTradedPrice > 0) {
                $closePrices[$numDays - 1] = $lastTradedPrice; // Replace the zero close price with the last traded price
                return $closePrices;
            } else {
                // No last traded price available for today, return null
                return null;
            }
        }
        return $closePrices;
    }

    private function calculateRSI($instrumentId, $today, $trade_batch)
    {
        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('instrument_id', $instrumentId)->where('date', $today)->exists();

        // Query the database to fetch necessary data for RSI calculation
        $priceData = DataBanksEod::select('close', 'date')->where('instrument_id', $instrumentId)->where('date', '<=', $today)->orderBy('date', 'desc')->limit(360)->get();
        // dd($priceData);

        if ($priceData->count() < 360 || !$dateCheck) {
            // Not enough data points for RSI calculation
            return null;
        } else {
            // Extract close prices from price data
            // $closePrices = $priceData->pluck('close')->toArray();
            $closePrices = array_reverse($priceData->pluck('close')->toArray());
            // dd($closePrices);

            $numDays = count($closePrices);
            $rsiValues = [];

            // dd($closePrices[$numDays - 1]);

            // Fetch last traded price and replace zero close price with it
            $closePrices = $this->fetchLastTradedPrice($closePrices, $numDays, $instrumentId, $today);

            if ($closePrices === null) {
                // No last traded price available for today, cannot calculate RSI
                return null;
            }
            // dd($closePrices[$numDays - 1]);

            // Calculate gains and losses
            for ($i = 1; $i < $numDays; $i++) {
                $change = $closePrices[$i] - $closePrices[$i - 1];
                if ($change > 0) {
                    $gain = $change;
                    $loss = 0;
                } else {
                    $gain = 0;
                    $loss = abs($change);
                }

                $rsiValues[] = ['gain' => $gain, 'loss' => $loss];
            }

            // Calculate first average gain and loss
            $firstAvgGain = array_sum(array_column(array_slice($rsiValues, 0, 14), 'gain')) / 14;
            $firstAvgLoss = array_sum(array_column(array_slice($rsiValues, 0, 14), 'loss')) / 14;

            // Initialize previous average gain and loss
            $prevAvgGain = $firstAvgGain;
            $prevAvgLoss = $firstAvgLoss;

            // Calculate RSI with subsequent iterations
            for ($j = 15; $j <= $numDays - 1; $j++) {
                // Check if the keys exist before accessing them
                $gain = isset($rsiValues[$j - 1]['gain']) ? $rsiValues[$j - 1]['gain'] : 0;
                $loss = isset($rsiValues[$j - 1]['loss']) ? $rsiValues[$j - 1]['loss'] : 0;

                // Calculate average gain and loss
                $avgGain = ($prevAvgGain * 13 + $gain) / 14;
                $avgLoss = ($prevAvgLoss * 13 + $loss) / 14;

                // Calculate RS and RSI
                $rs = $avgLoss != 0 ? $avgGain / $avgLoss : INF;
                $rsi = 100 - 100 / (1 + $rs);

                // Update previous average gain and loss for the next iteration
                $prevAvgGain = $avgGain;
                $prevAvgLoss = $avgLoss;
            }

            return $rsi;
        }
    }

    private function calculateMFI($instrumentId, $today, $trade_batch)
    {
        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('instrument_id', $instrumentId)->where('date', $today)->exists();

        // Query the database to fetch necessary data for MFI calculation
        $priceData = DataBanksEod::select('close', 'high', 'low', 'volume', 'date')
            ->where('instrument_id', $instrumentId)
            ->where('date', '<=', $today)
            ->whereNotNull('close')
            ->orderBy('date', 'desc')
            ->limit(38) // Consider the last 38 days for MFI calculation
            ->get()
            ->reverse();

        if ($priceData->count() < 38 || !$dateCheck) {
            // Not enough data points for MFI calculation
            return null;
        } else {
            // Reverse the $priceData array
            // $reversedPriceData = $priceData->reverse();
            $reversedPriceData = $priceData;

            // Initialize an array to store close, high, and low values by date
            $priceByDate = [];

            // Extract close, high, and low values by date
            foreach ($reversedPriceData as $data) {
                $date = $data->date;
                $close = $data->close;
                $high = $data->high;
                $low = $data->low;

                // Store the data in the array with date as key
                $priceByDate[$date] = [
                    'high' => $high,
                    'low' => $low,
                    'close' => $close,
                ];
            }

            // Dump the array to view close, high, and low values by date
            // dd($priceByDate);

            $typicalPriceValues = [];
            $moneyFlowValues = [];

            // Calculate typical price and money flow for each day
            foreach ($priceData as $index => $day) {
                $typicalPrice = ($day->high + $day->low + $day->close) / 3;
                $moneyFlow = $typicalPrice * $day->volume;

                $typicalPriceValues[] = $typicalPrice;
                $moneyFlowValues[] = $moneyFlow;
            }
            // dd($typicalPriceValues);
            // dd($moneyFlowValues);

            // Calculate positive and negative money flow
            $positiveMoneyFlow = [];
            $negativeMoneyFlow = [];

            // Calculate positive and negative money flow for the first 14 days
            for ($i = 1; $i <= 14; $i++) {
                $typicalPriceDifference = $typicalPriceValues[$i] - $typicalPriceValues[$i - 1];
                if ($typicalPriceDifference > 0) {
                    $positiveMoneyFlow[] = $moneyFlowValues[$i];
                    $negativeMoneyFlow[] = 0;
                } elseif ($typicalPriceDifference < 0) {
                    $positiveMoneyFlow[] = 0;
                    $negativeMoneyFlow[] = $moneyFlowValues[$i];
                } else {
                    $positiveMoneyFlow[] = 0;
                    $negativeMoneyFlow[] = 0;
                }
            }
            // dd($positiveMoneyFlow, $negativeMoneyFlow);

            $mfi_values = [];
            $moneyFlowRatio_values = [];
            $sumPositiveMoneyFlowValues = [];
            $sumNegativeMoneyFlowValues = [];
            // Calculate positive and negative money flow for the subsequent days
            for ($i = 15; $i < count($typicalPriceValues); $i++) {
                $typicalPriceDifference = $typicalPriceValues[$i] - $typicalPriceValues[$i - 1];

                if ($typicalPriceDifference > 0) {
                    $positiveMoneyFlow[] = $moneyFlowValues[$i];
                    $negativeMoneyFlow[] = 0;
                } elseif ($typicalPriceDifference < 0) {
                    $positiveMoneyFlow[] = 0;
                    $negativeMoneyFlow[] = $moneyFlowValues[$i];
                } else {
                    $positiveMoneyFlow[] = 0;
                    $negativeMoneyFlow[] = 0;
                }

                // dd($positiveMoneyFlow, $negativeMoneyFlow);

                // If positive money flow array length exceeds 14, remove the oldest value
                if (count($positiveMoneyFlow) > 14) {
                    array_shift($positiveMoneyFlow);
                }

                // If negative money flow array length exceeds 14, remove the oldest value
                if (count($negativeMoneyFlow) > 14) {
                    array_shift($negativeMoneyFlow);
                }

                // dd($positiveMoneyFlow, $negativeMoneyFlow);

                // Sum up the positive and negative money flow arrays for the last 14 days
                $sumPositiveMoneyFlow = array_sum($positiveMoneyFlow);
                $sumNegativeMoneyFlow = array_sum($negativeMoneyFlow);
                $sumPositiveMoneyFlowValues[] = $sumPositiveMoneyFlow;
                $sumNegativeMoneyFlowValues[] = $sumNegativeMoneyFlow;

                // dd($sumPositiveMoneyFlow, $sumNegativeMoneyFlow);

                // Calculate money flow ratio
                $moneyFlowRatio = $sumNegativeMoneyFlow != 0 ? $sumPositiveMoneyFlow / $sumNegativeMoneyFlow : INF;
                $moneyFlowRatio_values[] = $moneyFlowRatio;

                // Calculate MFI
                $mfi = 100 - 100 / (1 + $moneyFlowRatio);
                $mfi_values[] = $mfi;
            }
            // dd($sumPositiveMoneyFlowValues, $sumNegativeMoneyFlowValues);
            // dd($moneyFlowRatio_values, $mfi_values);

            return $mfi;
        }
    }

    private function calculateMACD($instrumentId, $today, $trade_batch)
    {
        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('instrument_id', $instrumentId)->where('date', $today)->exists();

        // Query the database to fetch necessary data for MACD calculation
        $priceData = DataBanksEod::select('close', 'date')
            ->where('instrument_id', $instrumentId)
            ->where('date', '<=', $today)
            ->whereNotNull('close')
            ->orderBy('date', 'desc')
            ->limit(360) // Consider the last 26 days for MACD calculation
            ->get();

        // Check if there's any data available
        if ($priceData->isEmpty() || $priceData->count() < 360 || !$dateCheck) {
            // No data available for calculation
            return null;
        } else {
            // Extract close prices from price data
            $closePrices = array_reverse($priceData->pluck('close')->toArray());
            // dd($closePrices);

            $numDays = count($closePrices);

            // dd($closePrices[$numDays - 1]);

            // Fetch last traded price and replace zero close price with it
            $closePrices = $this->fetchLastTradedPrice($closePrices, $numDays, $instrumentId, $today);

            if ($closePrices === null) {
                // No last traded price available for today, cannot calculate RSI
                return null;
            }
            // dd($closePrices[$numDays - 1]);

            // Calculate the 12-day EMA
            $ema12 = $this->calculation_EMA($closePrices, 12);

            // Calculate the 26-day EMA
            $ema26 = $this->calculation_EMA($closePrices, 26);

            // Calculate the MACD line
            $macdLine = [];
            for ($i = 0; $i < count($ema12); $i++) {
                $macdLine[] = $ema12[$i] - $ema26[$i];
            }
            // Return only the last value of the MACD line
            return end($macdLine);

            // Calculate the 9-day EMA of the MACD line (Signal line)
            $signalLine = $this->calculation_EMA($macdLine, 9);

            // Calculate the Histogram
            $histogram = [];
            for ($i = 0; $i < count($macdLine); $i++) {
                $histogram[] = $macdLine[$i] - $signalLine[$i];
            }

            // // Return the MACD line, Signal line, and Histogram
            // return [
            //     'macdLine' => $macdLine,
            //     'signalLine' => $signalLine,
            //     'histogram' => $histogram,
            // ];
        }
    }

    private function calculateEMA($instrumentId, $today, $trade_batch)
    {
        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('instrument_id', $instrumentId)->where('date', $today)->exists();

        // Query the database to fetch necessary data for MACD calculation
        $priceData = DataBanksEod::select('close', 'date')
            ->where('instrument_id', $instrumentId)
            ->where('date', '<=', $today)
            ->whereNotNull('close')
            ->orderBy('date', 'desc')
            ->limit(360) // Consider the last 26 days for MACD calculation
            ->get();

        // if ($priceData->count() < 360) {
        //     // Not enough data points for MACD calculation
        //     return null;
        // }
        // Check if there's any data available
        if ($priceData->isEmpty() || $priceData->count() < 360 || !$dateCheck) {
            // No data available for calculation
            return null;
        } else {
            // Extract close prices from price data
            $closePrices = array_reverse($priceData->pluck('close')->toArray());
            // dd($closePrices);

            $numDays = count($closePrices);

            // dd($closePrices[$numDays - 1]);

            // Fetch last traded price and replace zero close price with it
            $closePrices = $this->fetchLastTradedPrice($closePrices, $numDays, $instrumentId, $today);

            if ($closePrices === null) {
                // No last traded price available for today, cannot calculate RSI
                return null;
            }
            // dd($closePrices[$numDays - 1]);

            // Calculate the 12-day EMA
            $ema = $this->calculation_EMA($closePrices, 30);

            // return $ema;
            return end($ema);
        }
    }

    private function calculation_EMA($data, $period)
    {
        $multiplier = 2 / ($period + 1);
        $ema = [];
        $ema[0] = $data[0]; // Initial value is the same as the first data point

        for ($i = 1; $i < count($data); $i++) {
            $ema[$i] = ($data[$i] - $ema[$i - 1]) * $multiplier + $ema[$i - 1];
        }

        return $ema;
    }

    private function calculation_SMA($data, $period)
    {
        $sma = [];
        $numDataPoints = count($data);

        // Calculate SMA for each data point using the specified period
        for ($i = $period - 1; $i < $numDataPoints; $i++) {
            $sum = 0;
            // Calculate the sum of prices for the specified period
            for ($j = $i - $period + 1; $j <= $i; $j++) {
                $sum += $data[$j];
            }
            // Calculate SMA for the current data point
            $sma[] = $sum / $period;
        }

        return $sma;
    }

    private function calculateSMA($instrumentId, $today, $trade_batch)
    {
        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('instrument_id', $instrumentId)->where('date', $today)->exists();

        // Query the database to fetch necessary data for SMA calculation
        $priceData = DataBanksEod::select('close', 'date')
            ->where('instrument_id', $instrumentId)
            ->where('date', '<=', $today)
            ->whereNotNull('close')
            ->orderBy('date', 'desc')
            ->limit(360) // Consider the last 360 days for SMA calculation
            ->get();

        if ($priceData->count() < 360 || !$dateCheck) {
            // Not enough data points for RSI calculation
            return null;
        } else {
            // Extract close prices from price data
            $closePrices = array_reverse($priceData->pluck('close')->toArray());
            // dd($closePrices);

            $numDays = count($closePrices);

            // dd($closePrices[$numDays - 1]);

            // Fetch last traded price and replace zero close price with it
            $closePrices = $this->fetchLastTradedPrice($closePrices, $numDays, $instrumentId, $today);

            if ($closePrices === null) {
                // No last traded price available for today, cannot calculate RSI
                return null;
            }
            // dd($closePrices[$numDays - 1]);

            // Calculate the SMA using the provided period
            $sma = $this->calculation_SMA($closePrices, 30); // Assuming a period of 30 days

            // Return the last SMA value
            return end($sma);
        }
    }

    private function calculation_MA($data, $period)
    {
        $ma = [];
        $numDataPoints = count($data);

        // Calculate MA for each data point using the specified period
        for ($i = $period - 1; $i < $numDataPoints; $i++) {
            $sum = 0;
            // Calculate the sum of prices for the specified period
            for ($j = $i - $period + 1; $j <= $i; $j++) {
                $sum += $data[$j];
            }
            // Calculate MA for the current data point
            $ma[] = $sum / $period;
        }

        return $ma;
    }

    private function calculateMA($instrumentId, $today, $trade_batch)
    {
        // Check if the date exists for today
        $dateCheck = DataBanksEod::where('instrument_id', $instrumentId)->where('date', $today)->exists();

        // Query the database to fetch necessary data for MA calculation
        $priceData = DataBanksEod::select('close', 'date')
            ->where('instrument_id', $instrumentId)
            ->where('date', '<=', $today)
            ->whereNotNull('close')
            ->orderBy('date', 'desc')
            ->limit(360) // Consider the last 360 days for MA calculation
            ->get();

        if ($priceData->count() < 360 || !$dateCheck) {
            // Not enough data points for RSI calculation
            return null;
        } else {
            // Extract close prices from price data
            $closePrices = array_reverse($priceData->pluck('close')->toArray());
            // dd($closePrices);

            $numDays = count($closePrices);

            // dd($closePrices[$numDays - 1]);

            // Fetch last traded price and replace zero close price with it
            $closePrices = $this->fetchLastTradedPrice($closePrices, $numDays, $instrumentId, $today);

            if ($closePrices === null) {
                // No last traded price available for today, cannot calculate RSI
                return null;
            }
            // dd($closePrices[$numDays - 1]);

            // Calculate the MA using the provided period
            $ma = $this->calculation_MA($closePrices, 30);

            // Return the calculated MA values
            return end($ma);
        }
    }
}
