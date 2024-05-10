<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;
class CommonController extends Controller
{
    public static function enableDisable()
    {
        return $isActivestatus = [
            ''=>'Select Type',
            '1'=>'Enable',
            '0'=>'Disable'
        ];
    }
    public static function Active()
    {
        return $isActivestatus = [
            ''=>'Select Type',
            '1'=>'Open',
            '0'=>'Close'
        ];
    }
    public static function yesno()
    {
        return $isstatus = [
            ''=>'Select Type',
            '1'=>'Yes',
            '0'=>'No'
        ];
    }
    public static function incrementDecrement()
    {
        return $isActivestatus = [
            ''=>'Select Type',
            '1'=>'Increment',
            '2'=>'Decrement'
        ];
    }
    public static function StockInOut()
    {
        return $isActivestatus = [
            ''=>'Select Type',
            '1'=>'Stock In',
            '2'=>'Stock Out'
        ];
    }
    public static function IpoBoard()
    {
        return $ipoboard = [
            ''=>'Select Board',
            '1'=>'MAIN',
            '2'=>'+',
            '3'=>'ATB'
        ];
    }
    public static function Asset_Class()
    {
        return $asset_class = [
            ''=>'Select Class',
            '1'=>'Equity',
            '2'=>'Debt(Bond)',
            '3'=>'Sukuk'
        ];
    }
    public static function Listing_Method()
    {
        return $methods= [
            ''=>'Select Method',
            '1'=>'Direct listing',
            '2'=>'IPO'
        ];
    }
    public static function Ipo_Status()
    {
        return $status= [
            ''=>'Select Status',
            '1'=>'Applied',
            '2'=>'Approved',
            '3'=>'Listing',
            '4'=>'Subscription'
        ];
    }
    public static function Day()
    {
        return $day= [
            ''=>'Select Day',
            'sun'=>'Sunday',
            'mon'=>'Monday',
            'tue'=>'Tuesday',
            'wed'=>'Wednesday',
            'thu'=>'Thursday'
        ];
    }
    public static function NewsPortal()
    {
        return $portalstatus= [
            ''=>'Select',
            '1'=>'Published',
            '0'=>'Draft',
        ];
    }

    public static function gender(){
        return $gender= [
            ''=>'Select',
            '1'=>'Male',
            '2'=>'Female',
            '3'=>'common',
        ];
    }
    public static function isExchangeListedCompany (){
        return $isExchangeListedCompany= [
            ''=>'Select',
            '0'=>'No',
            '1'=>'Yes',
        ];
    }

    public static function authorizationType (){
        return $authorizationType= [
            ''=>'Select',
            '1'=>'Buy',
            '2'=>'Sell',
            '0'=>'Buy & Sell Both',
        ];
    }

    public static function OperationType (){
        return $operationType= [
            ''=>'Select',
            '0'=>'Individual',
            '1'=>'Joint Holder',
        ];
    }

    public static function AccountType (){
        return $accountType= [
            ''=>'Select',
            '0'=>'Direct Trading with no Margin',
            '1'=>'Margin Account',
        ];
    }

    public static function ClientType (){
        return $clientType= [
            ''=>'Select',
            '0'=>'Regular',
            '1'=>'Clearing',
        ];
    }
    public static function ifNomineeIsMinor (){
        return $ifNomineeIsMinor= [
            ''=>'Select',
            '0'=>'Same As Primary Account holder',
            '1'=>'Same As Secondary Account holder',
            '2'=>'Other',
        ];
    }

    public static function Charge(){
        return $charge= [
            ''=>'Select',
            'Laga'=>'Laga',
            'Hawla'=>'Hawla',
            'Annual Fees'=>'Annual Fees',
            'Commission'=>'Commission',
            'Tax'=>'Tax',
            'Other'=>'Other',
        ];
    }



    public static function occupation(){
        return $occupation= [
            ''=>'Select',
            '1'=>'Goverment Service Holder',
            '2'=>'Businessman',
            '3'=>'Housewife',
            '4'=>'Teacher',
            '5'=>'Doctor',
            '6'=>'Lower',
            '7'=>'Service Holder',
            '0'=>'Other',
        ];
    }

    public static function cdblOccupation($index){
        $occupation= [
            'service'=>'3',
            'businessman'=>'2',
        ];

        return $occupation[$index];
    }

    public static function nationality(){
        return $nationality= [
            ''=>'Select',
            '1'=>'Bangladesi',
            '0'=>'Others',
        ];
    }
    public static function isYesNo(){
        return $IsYesNo= [
            ''=>'Select',
            '1'=>'Yes',
            '0'=>'No',
        ];
    }

    public static function residency(){
        return $residency= [
            '1'=>'Resident',
            '0'=>'Non Resident',
        ];
    }

    public static function relation(){
        return $relation= [
            ''=>'Select',
            '1'=>'Father',
            '2'=>'Mother',
            '3'=>'Spouse',
            '4'=>'Brother',
            '5'=>'Sister',
            '6'=>'Aunty',
            '7'=>'Uncle',
            '8'=>'Son',
            '9'=>'Daugther',
            '10'=>'Cousin',
            '11'=>'Student',
            '12'=>'Friend',
            '13'=>'Grandfather',
            '14'=>'Grandmother',
        ];
    }
    public static function isActive(){
        return $is_active = [
            ''=>'Select',
            '1'=>'Active',
            '0'=>'Inactive',

        ];
    }
    public static function bookType()
    {
        return $bookType = [
            ''=>'Select Type',
            '1'=>'Cash Book',
            '0'=>'Bank Book',
        ];
    }
    public static function Type(){
        return $type = [
            ''=>'Select',
            '1'=>'Cash',
            '2'=>'Cheque',
            '3'=>'Online',

        ];
    }
    public static function status(){
        return $status = [
            ''=>'Select',
            '1'=>'Complete',
            '2'=>'Pending',
            '3'=>'Rejected',

        ];
    }
    public static function productOrdersType(){
        return $productOrdersType = [
            ''=>'Select',
            '1'=>'Buy',
            '0'=>'Sell'
        ];
    }
    public static function BuySellReport(){
        return $reportyType = [
            ''=>'Select',
            '1'=>'Buy',
            '0'=>'Sell',
            '2'=>'Both'
        ];
    }
     public static function modeOfOrder(){
        return $modeOfOrder = [
            ''=>'Select',
            '1'=>'Physical',
            '2'=>'Mobile',
            '2'=>'SMS',
            '2'=>'Email',

        ];
    }
    public static function isMarginAble(){
        return $is_active = [
            ''=>'Select',
            '1'=>'Yes',
            '0'=>'No',
        ];
    }

    public static function statementCycleCode(){
        return $statement_cycle_code = [
            ''=>'Select',
            '0'=>'Daily',
            '1'=>'Weekly',
            '2'=>'Fortnightly',
            '3'=>'Monthly',
            '4'=>'First Of Month',
        ];
    }

    public static function ExchangeCompany(){
        return $exchange_name = [
            ''=>'Select',
            '1'=>'DSEX',
            '2'=>'CSEX',
        ];
    }

    public static function OrderType(){
        return $order_type= [
            ''=>'Select',
            '1'=>'Buy',
            '0'=>'Sale',
        ];
    }
    public static function Transaction(){
        return $transaction_type = [
            ''=>'Select',
            '1'=>'Cash',
            '2'=>'Bank Transfer',

        ];
    }
    public static function transactionType(){
        return $transactionType = [
            ''=>'Select',
            '1'=>'Deposit',
            '2'=>'Withdraw',

        ];
    }
    public static function depositType (){
        return $depositType = [
            ''=>'Select',
            '1'=>'Cash Deposit',
            '2'=>'Check Deposit',
            '3'=>'Credit Adjustment',
            '4'=>'Other Fees',
            '5'=>'Referral Pay-out',
            '6'=>'Trade Slippage Profit',
            '7'=>'Margin Deposit',
            '8'=>'Wire In',
        ];
    }
    public static function chargeCommission (){

            $lastCommission = Charge::where('title', 'Commission')
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->first();

          return  $commission = floatval($lastCommission->value);
    }
    public static function chargeLaga (){

        $lastLaga = Charge::where('title', 'Laga')
        ->where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->first();

       return $laga = floatval($lastLaga->value);
    }





    public static function withdrawalType (){
        return $withdrawalType = [
            ''=>'Select',
            '0'=>'Cash Payment',
            '1'=>'Check Payment',
            '2'=>'Debit Adjustment',
            '3'=>'Letter of Transfer',
            '4'=>'Prepaid Card Payment',
            '5'=>'Margin Withdraw',
            '6'=>'Wire Out',
        ];
    }

    public static function getCurrentUserId() {
        return auth()->user()->id;
    }
    public static function getYear($preyear = 50,$nexyear= 50) {

        $year = [];
        $year[''] = 'Select Year';
        $preyear = date("Y",strtotime("-".$preyear." year"));
        $nexyear = date("Y",strtotime("+".$nexyear." year"));

        for($i = $preyear;$i<=$nexyear;$i++){
            $year[$i] = $i;
        }


        krsort($year);
        return $year;

    }
    public static function getMonth() {

        return $month = array(
            ''=>'Select Month',
            '1'=>'January',
            '2'=>'February',
            '3'=>'March',
            '4'=>'April',
            '5'=>'May',
            '6'=>'June',
            '7'=>'July',
            '8'=>'August',
            '9'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December',
        );
    }

    public function getMonthName($digit = ''){

        if(($digit) && $digit > 0 && $digit < 13) {
            $getmonth = $this->getMonth();
            dd($digit);
        }
        else {
            return '';
        }
    }
    public function uploadImage(Request $request)
    {
        $funcNum = $request->input('CKEditorFuncNum');
        $message = $url = '';
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            if ($file->isValid()) {
                $filename = rand(1000, 9999) . $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/ckeditor/', $filename);
                $url = url('uploads/ckeditor/' . $filename);
            } else {
                $message = 'An error occurred while uploading the file.';
            }
        } else {
            $message = 'No file uploaded.';
        }
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url');</script>";
    }

}
