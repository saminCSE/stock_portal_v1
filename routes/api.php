<?php

use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\TradingViewController;
use App\Http\Controllers\Api\AnalyticalController;
use App\Http\Controllers\Api\BlockTransactionsApi;
use App\Http\Controllers\Api\CompanyApiController;
use App\Http\Controllers\Api\PortalUserController;
use App\Http\Controllers\Api\ScreenerApiController;
use App\Http\Controllers\Api\SearchingApiController;
use App\Http\Controllers\BlockTransactionController;
use App\Http\Controllers\Api\MarketInfoApiController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\TopGainerLoserController;
use App\Http\Controllers\Api\BreakingNewsApiController;
use App\Http\Controllers\Api\NewsCategoryApiController;
use App\Http\Controllers\Api\NewsHighlightApiController;
use App\Http\Controllers\Api\MarketBulletingApiController;
use App\Http\Controllers\Api\BlockTransactionsApiController;
use App\Http\Controllers\Cron\BlockTransactionCronController;
use App\Http\Controllers\Api\NewsletterSubscriptionController;
use App\Http\Controllers\Cron\ScreenerScheduleSettingCronController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('basic.auth')->prefix('v1')->group(function () {
    /*========================= TradingView API ===================================== */
    Route::get('config', [TradingViewController::class, 'config'])->name('config');
    Route::get('symbol_info', [TradingViewController::class, 'symbol_info'])->name('symbol_info');
    Route::get('search', [TradingViewController::class, 'search']);
    Route::get('history', [TradingViewController::class, 'history']);
    // Route::get('history',[TradingViewController::class,'history'])->withoutMiddleware('throttle:api');
    Route::get('marks', [TradingViewController::class, 'marks']);
    Route::get('timescale_marks', [TradingViewController::class, 'timescale_marks']);
    Route::get('quotes', [TradingViewController::class, 'quotes']);
    Route::get('symbols', [TradingViewController::class, 'symbols']);
    Route::get('time', [TradingViewController::class, 'time']);
    Route::post('indexchart', [TradingViewController::class, 'indexChart']);
    Route::post('indexchart-range', [TradingViewController::class, 'prevIndexChart']);
    Route::post('symbol-indexchart', [TradingViewController::class, 'symbolIndexChart']);
    Route::get('todaytradestatistics', [TradingViewController::class, 'todayTradeStatistics']);
    Route::get('tendaystradestatistics', [TradingViewController::class, 'tenDaysTradeStatistics']);
    // Route::get('announcement/details/{id}', [AnnouncementControlller::class,'announceDetails'])->name('announceDetails');
    Route::get('index-movers-pullers', [TradingViewController::class, 'indexMoversPullers']);
    Route::get('index-movers-draggers', [TradingViewController::class, 'indexMoversDraggers']);
    Route::get('sector-total-values', [TradingViewController::class, 'sectorTotalValues']);
    Route::get('sector-up-down', [TradingViewController::class, 'sectorUpDown']);


    /*========================= Market Info API ===================================== */
    Route::get('market_info', [MarketInfoApiController::class, 'ShowMarketInfo']);
    Route::get('get/market_bulleting', [MarketBulletingApiController::class, 'MarketBulleting']);
    Route::get('get/all_news', [BreakingNewsApiController::class, 'AllNews']);
    Route::get('get/news', [BreakingNewsApiController::class, 'News']);
    Route::get('get/breaking_news', [BreakingNewsApiController::class, 'BreakingNews']);
    Route::get('get/highlight_news', [BreakingNewsApiController::class, 'NewsHighlight']);
    Route::get('get/highlight_news_category', [BreakingNewsApiController::class, 'newsHighlightCategory']);
    Route::get('get/news_category_name', [BreakingNewsApiController::class, 'newsCategoryName']);
    Route::post('get/news_category', [BreakingNewsApiController::class, 'newsCategory']);
    Route::get('get/corporate_news', [BreakingNewsApiController::class, 'CorporateNews']);
    Route::get('get/financial_news', [BreakingNewsApiController::class, 'FinancialNews']);
    Route::get('corporate_news_search', [BreakingNewsApiController::class, 'CorporateNewsSearch']);
    Route::get('financial_news_search', [BreakingNewsApiController::class, 'FinancialNewsSearch']);


    /*========================= News API ===================================== */
    Route::post('newsSubscribe', [NewsletterSubscriptionController::class, 'subscribe']);

    /*========================= Searching API ===================================== */
    Route::post('main_search', [SearchingApiController::class, 'mainSearching']);
    // Route::get('main_search',[SearchingApiController::class,'mainSearching']);


    /*========================= Top Gainer API ===================================== */
    Route::post('top_gainer_op_ltp', [TopGainerLoserController::class, 'topTenGainerConsideringOPAndLTP']);

    /*========================= Top Losers API ===================================== */
    Route::post('top_loser_op_ltp', [TopGainerLoserController::class, 'topTenLoserConsideringOPAndLTP']);

    /*========================= Trading Tickers API ===================================== */
    Route::post('trading_ticker', [TopGainerLoserController::class, 'tradingTickers']);

    /*========================= Recent View Symbol API ===================================== */
    Route::post('recent_view', [TopGainerLoserController::class, 'recentViewSymbol']);

    /*========================= Most Active Symbol API ===================================== */
    Route::get('most_active', [TopGainerLoserController::class, 'mostActive']);

    /*========================= Trade Value API ===================================== */
    Route::get('trade_value', [TopGainerLoserController::class, 'tradeValue']);

    /*========================= Watchlist API ===================================== */
    Route::resource('watchlist', WatchlistController::class);

    Route::get('strength_meter', [TopGainerLoserController::class, 'StrengthMeter']);
    Route::get('top_trade', [TradingViewController::class, 'TopTrade']);

    /*========================= Company API ===================================== */
    Route::get('company_market_summary', [CompanyApiController::class, 'companyMarketSummary']);
    Route::get('company_details_header', [CompanyApiController::class, 'companyDetailsHeader']);
    Route::get('historical_data', [CompanyApiController::class, 'historicalData']);
    Route::post('block_transaction', [BlockTransactionsApiController::class, 'index']);
    Route::get('block_transaction_list', [BlockTransactionsApiController::class, 'BlockTransactionList']);
    Route::get('block_transaction_search', [BlockTransactionsApiController::class, 'BlockTransactionSearchList']);
    Route::get('company_profile', [CompanyApiController::class, 'companyProfile']);
    Route::get('company/list', [CompanyApiController::class, 'companyList']);
    Route::get('company_search', [CompanyApiController::class, 'CompanySearchList']);
    Route::post('potal_user/register', [PortalUserController::class, 'RegisterPortalUser']);
    Route::post('portal_user/login', [PortalUserController::class, 'login']);
    Route::post('/logout', [PortalUserController::class, 'logout']);
    Route::post('/forgot-password',  [ForgetPasswordController::class, 'sendResetLinkEmail']);
    Route::get('password/reset',  [ForgetPasswordController::class, 'showResetForm']);
    Route::post('reset_password', [ForgetPasswordController::class, 'resetPassword']);
    Route::post('/watchlist', [CompanyApiController::class, 'addToWatchlist']);
    Route::post('/watchlistIndex', [CompanyApiController::class, 'WatchlistIndex']);
    Route::post('/block_transactionAdd', [BlockTransactionCronController::class, 'AddBlockTransactionByUrl']);
    Route::post('/gainer-sparkline', [AnalyticalController::class, 'gainerSparkline']);
    Route::post('/looser-sparkline', [AnalyticalController::class, 'losserSparkline']);
    Route::post('/topvolume-sparkline', [AnalyticalController::class, 'topVolumeSparkline']);
    Route::post('/topvalue-sparkline', [AnalyticalController::class, 'topValueSparkline']);
    Route::post('/toptrade-sparkline', [AnalyticalController::class, 'topTradeSparkline']);
    Route::get('company_statistics', [CompanyApiController::class, 'companyStatistics']);
    Route::get('company_share_holding', [CompanyApiController::class, 'companyShareHolding']);
    Route::get('company_financial_statement', [CompanyApiController::class, 'companyFinancialStatement']);
    Route::get('minute_chart', [CompanyApiController::class, 'minuteChart']);
    Route::get('screener-board', [ScreenerApiController::class, 'screenerBoard']);
    Route::get('screener-board-generate', [ScreenerApiController::class, 'screenerGenerate']);
    Route::get('announcement', [NewsApiController::class, 'index']);
    // Route::middleware('basic.auth')->get('announcement', [NewsApiController::class, 'index']);
    Route::get('/cron/update-rsi-previous-date', [ScreenerScheduleSettingCronController::class, 'updateOrInsertRsiForPreviousDate']);
    // Route::get('/cron/insert-rsi-today', [ScreenerScheduleSettingCronController::class, 'insertRsiForToday']);
});
