<?php


use App\Models\DataBanksEod;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpoController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\UpdateScheduler;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\MenuRoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\AbroadTourController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CompanyAgmController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\ContestTypeController;
use App\Http\Controllers\DataBankEODController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\TradingViewController;
use App\Http\Controllers\ContestVideoController;
use App\Http\Controllers\AnnouncementControlller;
use App\Http\Controllers\ApiAccessController;
use App\Http\Controllers\DseStatisticeController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\ContestUserTypeController;
use App\Http\Controllers\DirectorProfileController;
use App\Http\Controllers\MarketSchedulerController;
use App\Http\Controllers\PermissionLabelController;
use App\Http\Controllers\BenificiaryOwnerController;
use App\Http\Controllers\BlockTransactionController;
use App\Http\Controllers\ContestOrganizerController;
use App\Http\Controllers\DataBankIntradayController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\CompanyBoardOfDirectorsController;
use App\Http\Controllers\CompanyInterimFinancialPerformance;
use App\Http\Controllers\CompanyFinancialStatementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.master');
// });

Route::get('/',[HomeController::class,'index'])->middleware('isLogged');
Route::get('login',[UserAuthController::class,'login'])->name('login')->middleware('AlreadyLoggedIn');


//Route::get('/',[HomeController::class,'index']);

Route::get('/autoMarketScheduler',[CronController::class,'marketDateScheduler'])->name('autoMarketScheduler');
Route::get('/market',[HomeController::class,'Market']);
Route::post('market_schedule', [HomeController::class, 'MarketSchedule'])->name('market_schedule');

Route::post('create',[UserAuthController::class,'create'])->name('auth.create');
Route::post('check',[UserAuthController::class,'check'])->name('auth.check');




Route::match(array('GET','POST'),'logout', [UserAuthController::class,'logout'])->name('logout');



Route::get('admin/profile',[HomeController::class,'profile'])->name('admin.profile')->middleware('isLogged');

Route::group(['prefix' => 'admin',  'middleware' =>['isLogged', 'Permissioncheck']], function()
// Route::group(['prefix' => 'admin',  'middleware' =>['isLogged']], function()
{

    // ----------------------------- Benificiary Owner list ------------------------
    Route::get('benificiary_owners', [BenificiaryOwnerController::class, 'list'])->name('bolist');
    Route::get('generate_pdf/{id}', [BenificiaryOwnerController::class, 'generatepdf'])->name('generatepdf');

    // ----------------------------- Benificiary Owner list end ------------------------
    Route::resource('marketscheduler', MarketSchedulerController::class);

    Route::get('edit/marketscheduler', [UpdateScheduler::class, 'Edit'])->name('ChangeMarketScheduler.edit');
    Route::put('update_marketscheduler', [UpdateScheduler::class,'Update'])->name('ChangeMarketScheduler.update_marketscheduler');
    Route::get('edit/marketschedulerdata/{id}', [UpdateScheduler::class, 'EditData'])->name('ChangeMarketSchedulerdata.edit');
    Route::put('marketschedulerdata_update/{id}', [UpdateScheduler::class, 'Updatedata'])->name('ChangeMarketSchedulerdata_update');
    // Route::resource('menu', MenuController::class);
    // Route::resource('rolemenu', MenuRoleController::class);
    // Route::resource('permissionlabel', PermissionLabelController::class);
    // Route::resource('permissionrole', PermissionRoleController::class);

    Route::get('/eoduploadform',[CsvImportController::class,'eodupload'])->name('csvFileImport.eodupload');
    Route::post('/eodupload',[CsvImportController::class,'ImportEod'])->name('csvFileImport.ImportEod');

    Route::get('/blockTrasactionuploadform',[CsvImportController::class,'blockTrasactionupload'])->name('csvFileImport.blockTrasactionupload');
    Route::post('/blockTrasactionupload',[CsvImportController::class,'ImportBlockTransaction'])->name('csvFileImport.ImportBlockTransaction');

    Route::match(array('GET','POST'),'dse/mkistat',[DseStatisticeController::class,'getMkistat'])->name('dsedData.mkistat');
    Route::match(array('GET','POST'),'dse/intraData',[DseStatisticeController::class,'intraData'])->name('dsedData.intradata');
    Route::match(array('GET','POST'),'dse/intradataeod',[DseStatisticeController::class,'intraDataEod'])->name('dsedData.intradataeod');
    Route::match(array('GET','POST'),'dse/index_data',[DseStatisticeController::class,'indexData'])->name('dsedData.indexData');
    Route::match(array('GET','POST'),'list/markets',[DseStatisticeController::class,'MarketData'])->name('market.list');


    // Daily data/Data Bank Intraday
    Route::get('dailyData/create',[DataBankIntradayController::class,'CreateDailyData'])->name('dailyData.create');
    Route::post('dailyData/store',[DataBankIntradayController::class,'DailyDataStore'])->name('dailyData.store');
    Route::get('dailyData/edit_dailyData/{id}', [DataBankIntradayController::class, 'DailyDataShow'])->name('dailyData.edit_dailyData');
    Route::put('dailyData/update_dailyData/{id}', [DataBankIntradayController::class, 'DailyDataUpdate'])->name('   .update_dailyData');
    Route::get('dailyData/dailyData_delete/{id}', [DataBankIntradayController::class, 'destroy'])->name('dailyData.dailyData_delete');
    // Data Bank EOD
    Route::get('dataEod/create',[DataBankEODController::class,'CreateDataEod'])->name('DataEod.create');
    Route::post('DataEod/store',[DataBankEODController::class,'DataEodStore'])->name('DataEod.store');
    Route::get('DataEod/edit_DataEod/{id}', [DataBankEODController::class, 'DataEodShow'])->name('DataEod.edit_DataEod');
    Route::put('DataEod/update_DataEod/{id}', [DataBankEODController::class, 'DataEodUpdate'])->name('DataEod.update_DataEod');
    Route::get('DataEod/DataEod_delete/{id}', [DataBankEODController::class, 'destroy'])->name('DataEod.DataEod_delete');

    Route::get('instrument/list', [InstrumentController::class, 'Index'])->name('instrument.list');
    Route::get('instrument/create', [InstrumentController::class, 'CreateInstrument'])->name('instrument.create');
    Route::post('instrument/create_instrument', [InstrumentController::class, 'Instrumentregister'])->name('instrument.create_instrument');
    Route::get('instrument/edit_instrument/{id}', [InstrumentController::class, 'show'])->name('instrument.edit_instrument');
    Route::put('instrument/update_instrument/{id}', [InstrumentController::class, 'update_Instrument'])->name('instrument.update_instrument');
    Route::get('instrument/instrument_delete/{id}', [InstrumentController::class, 'deleteInstrument'])->name('instrument.instrument_delete');

    Route::match(array('GET','POST'),'ipo/list',[IpoController::class,'Index'])->name('ipo.list');
    Route::get('ipo/create', [IpoController::class, 'CreateIpo'])->name('ipo.create');
    Route::post('ipo/create_ipo', [IpoController::class, 'Iporegister'])->name('ipo.create_ipo');
    Route::get('ipo/edit_ipo/{id}', [IpoController::class, 'show'])->name('ipo.edit_ipo');
    Route::put('ipo/update_ipo/{id}', [IpoController::class, 'update_Ipo'])->name('ipo.update_ipo');
    Route::get('ipo/ipo_delete/{id}', [IpoController::class, 'deleteIpo'])->name('ipo.ipo_delete');
    Route::get('ipo/summarydownload/{id}', [IpoController::class, 'DownloadSummary'])->name('ipo.summarydownload');
    Route::get('ipo/prospectorsdownload/{id}', [IpoController::class, 'DownloadProspectors'])->name('ipo.prospectorsdownload');
    Route::get('ipo/resultsdownload/{id}', [IpoController::class, 'DownloadResults'])->name('ipo.resultsdownload');

    Route::resource('newsportal', NewsController::class);


    Route::resource('announcement', AnnouncementControlller::class);
    Route::get('announcement/details/{id}', [AnnouncementControlller::class,'announceDetails'])->name('announceDetails');
    Route::match(array('GET','POST'),'list/announcement',[AnnouncementControlller::class,'Index_Announcement'])->name('announce_list');


    Route::get('newscategory/newsCategory', [NewsController::class, 'NewsCategory'])->name('newscategory.category_create');
    Route::post('create/news/category', [NewsController::class, 'CreateCategory'])->name('newscategory.create_newscategory');
    Route::get('edit_newscategory/{id}', [NewsController::class, 'CategoryShow'])->name('newscategory.edit_category');
    Route::put('update_newscategory/{id}', [NewsController::class, 'UpdateCategory'])->name('newscategory.update_category');
    Route::get('newscategory_delete/{id}', [NewsController::class, 'DeleteCategory'])->name('newscategory.category_delete');
    Route::resource('newsletter', NewsletterSubscriptionController::class);


    /*========================= Common Controller===================================== */
    Route::post('upload_image', [CommonController::class, 'uploadImage'])->name('upload');


    /*========================= Block Transaction ===================================== */
    Route::resource('blocktransaction', BlockTransactionController::class);

    /*========================= Designation ===================================== */
    Route::resource('designation', DesignationController::class);

    /*========================= Designation ===================================== */
    Route::resource('director_profile', DirectorProfileController::class);

    /*========================= company_board_of_director ===================================== */
    Route::resource('company_director', CompanyBoardOfDirectorsController::class);



    /*_________________________________________ Demo Trade Route Start ______________________________________*/


     /*========================= ContestUserType ===================================== */
     Route::Resource('contest_user_type',ContestUserTypeController::class);

     /*========================= ContestType ===================================== */
     Route::Resource('contest_type',ContestTypeController::class);

     /*========================= Contest ===================================== */
     Route::Resource('contest',ContestController::class);
      /*========================= ContestOrganizer ===================================== */
      Route::Resource('contest_organizer',ContestOrganizerController::class);

       /*========================= Contest Prize ===================================== */
       Route::Resource('prize',PrizeController::class);

      /*========================= Contest Video ===================================== */
      Route::Resource('contest_video',ContestVideoController::class);
      /*========================= Commission ===================================== */
      Route::Resource('commission',CommissionController::class);

     /*_________________________ Demo Trade Route End ______________________________________________________ */

    // ------------------------------------ Settings Route --------------------------------
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::POST('/settings/update', [SettingsController::class, 'update'])->name('settings.update');




    Route::get('changeStatus', [NewsController::class,'ChangeStatus']);


    Route::match(array('GET','POST'),'company/list',[CompanyController::class,'Index'])->name('company_list');
    Route::get('create/company_basic_info', [CompanyController::class, 'CreateCompanyBasicInfo'])->name('create_company_basic_info');
    Route::post('add/company_basic_info', [CompanyController::class, 'AddCompanyBasicInfo'])->name('add_company_basic_info');
    Route::get('edit_company_basic_info/{id}', [CompanyController::class, 'CompanyBasicInfoShow'])->name('edit_company_basic_info');
    Route::put('update_company_basic_info/{id}', [CompanyController::class, 'UpdateCompanyBasicInfoShow'])->name('update_company_basic_info');
    Route::match(array('GET','POST'),'company_basic_info/list',[CompanyController::class,'CompanyBasicInfo'])->name('company_basic_info');
    Route::get('company_basic_info/details/{id}', [CompanyController::class,'CompanyBasicInfoDetails'])->name('company_basic-info_details');
    Route::resource('company_agm', CompanyAgmController::class);
    Route::match(array('GET','POST'),'company_agm',[CompanyAgmController::class,'Index'])->name('company_agm');
    Route::resource('company_interim', CompanyInterimFinancialPerformance::class);
    Route::get('company_interim/details/{id}', [CompanyInterimFinancialPerformance::class,'CompanyInterimDetails'])->name('company_interim_details');


    // ========================== Company Financial Statement =========================

    Route::Resource('company_financial_statement',CompanyFinancialStatementController::class);

    //=========================== Books =============================
    Route::get('book/list', [BookController::class, 'Index'])->name('book.list');
    Route::get('book/create', [BookController::class, 'Create_book'])->name('book.create');
    Route::post('book/store', [BookController::class, 'store'])->name('book.store');
    Route::get('book/edit_book/{id}', [BookController::class, 'edit_book'])->name('book.edit_book');
    Route::put('book/update_book/{id}', [BookController::class, 'update_book'])->name('book.update');
    Route::get('book/delete_book/{id}', [BookController::class, 'deletebook'])->name('book.book_delete');

    //=========================== Reviews =============================

    Route::get('review/list', [ReviewController::class, 'Index'])->name('review.list');
    Route::get('review/create', [ReviewController::class, 'Create_review'])->name('review.create');
    Route::post('review/store', [ReviewController::class, 'store'])->name('review.store');
    Route::get('review/edit_review/{id}', [ReviewController::class, 'edit_review'])->name('review.edit_review');
    Route::put('review/update_review/{id}', [ReviewController::class, 'update_review'])->name('review.update');
    Route::get('review/delete_review/{id}', [ReviewController::class, 'deletereview'])->name('review.review_delete');
    Route::get('review/approve/{id}', [ReviewController::class, 'approve'])->name('review.approve');
    Route::get('review/unapprove/{id}', [ReviewController::class, 'unapprove'])->name('review.unapprove');
    Route::get('access/api/list', [ApiAccessController::class, 'index'])->name('apiAccess_list');
    Route::get('access/api/create', [ApiAccessController::class, 'create'])->name('apiAccess_create');
    Route::post('access/api/store', [ApiAccessController::class, 'store'])->name('api_access.store');
    Route::post('/update-status/{id}', [ApiAccessController::class, 'updateStatus'])->name('update-status');
    Route::delete('/apiaccess/{id}',[ApiAccessController::class, 'destroy'])->name('apiaccess.destroy');

});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});
