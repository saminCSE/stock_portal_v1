<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public static function enableDisable()
    {
        return $isActivestatus = [
            '' => 'Select Type',
            '1' => 'Enable',
            '0' => 'Disable'
        ];
    }
    public static function Active()
    {
        return $isActivestatus = [
            '' => 'Select Type',
            '1' => 'Open',
            '0' => 'Close'
        ];
    }
    public static function yesno()
    {
        return $isstatus = [
            '' => 'Select Type',
            '1' => 'Yes',
            '0' => 'No'
        ];
    }
    public static function IsPromotion()
    {
        return $ispromoted = [
            '' => 'Select Type',
            '1' => 'Yes',
            '0' => 'No'
        ];
    }
    public static function incrementDecrement()
    {
        return $isActivestatus = [
            '' => 'Select Type',
            '1' => 'Increment',
            '2' => 'Decrement'
        ];
    }
    public static function StockInOut()
    {
        return $isActivestatus = [
            '' => 'Select Type',
            '1' => 'Stock In',
            '2' => 'Stock Out'
        ];
    }
    public static function IpoBoard()
    {
        return $ipoboard = [
            '' => 'Select Board',
            '1' => 'MAIN',
            '2' => 'SME',
            '3' => 'ATB'
        ];
    }
    public static function Asset_Class()
    {
        return $asset_class = [
            '' => 'Select Class',
            '1' => 'Equity',
            '2' => 'Debt(Bond)',
            '3' => 'Sukuk'
        ];
    }
    public static function Listing_Method()
    {
        return $methods = [
            '' => 'Select Method',
            '1' => 'Direct listing',
            '2' => 'IPO'
        ];
    }
    public static function Ipo_Status()
    {
        return $status = [
            '' => 'Select Status',
            '1' => 'Applied',
            '2' => 'Approved',
            '3' => 'Listing',
            '4' => 'Subscription'
        ];
    }
    public static function Day()
    {
        return $day = [
            '' => 'Select Day',
            'sun' => 'Sunday',
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday'
        ];
    }

    // Demo Trade Section

    public static function ContestUserType(){
        return $contestUserType = [
            ''                  => 'Select',
            'College Student'   => 'College Student',
            'School Student'    => 'School Student',
            'Professional'      => 'Professional',
            'Fresher'           => 'Fresher',
            'Other'             => 'Other',
        ];
    }
    public static function ContestStatus(){
        return $contestStatus = [
            ''                      => 'Select',
            'Registration Open'     => 'Registration Open',
            'Registration Close'    => 'Registration Close',
            'Contest Ongoing'       => 'Contest Ongoing',
            'Contest End'           => 'Contest End',
            'Other'                 => 'Other',
        ];
    }

    public static function isActive(){
        return $is_active = [
            ''=>'Select',
            '1'=>'Active',
            '0'=>'Inactive',

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


    public static function NewsPortal()
    {
        return $portalstatus = [
            '' => 'Select',
            '1' => 'Published',
            '0' => 'Draft',
        ];
    }
    public static function getCurrentUserId()
    {
        return auth()->user()->id;
    }
    public static function getYear($preyear = 50, $nexyear = 50)
    {

        $year = [];
        $year[''] = 'Select Year';
        $preyear = date("Y", strtotime("-" . $preyear . " year"));
        $nexyear = date("Y", strtotime("+" . $nexyear . " year"));

        for ($i = $preyear; $i <= $nexyear; $i++) {
            $year[$i] = $i;
        }


        krsort($year);
        return $year;
    }
    public static function getMonth()
    {

        return $month = array(
            '' => 'Select Month',
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
    }

    public function getMonthName($digit = '')
    {

        if (int($digit) && $digit > 0 && $digit < 13) {
            $getmonth = $this->getMonth();
            dd($digit);
        } else {
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
