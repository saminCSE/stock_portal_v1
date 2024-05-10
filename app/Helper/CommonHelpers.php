<?php 

function changeDateFormate($date,$date_format = 'Y-m-d'){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
}
   
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function getMonth() {
        
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

function getMonthName($digit = ''){
   
    if(is_int($digit) && $digit > 0 && $digit < 13) {
        $getmonth = getMonth();
        return $getmonth["$digit"];
        // $length = strlen($digit);
        // $getmonth = getMonth();
        // if($length == 1) {
        //     return $getmonth["0"."$digit"];
        // }
        // else {
        //     return $getmonth["$digit"];
        // }
       
    }
    else {
        return '';
    }

    
}


function sidebarhtml() {
    return '
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="fas fa-tools"></i>
            <span>Global Setting</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href='.route("office.index").'>Office</a></li> 
            <li><a href='.route("storesetup.index").'>Store</a></li> 
            <li><a href='.route("vendor.index").'>Vendor</a></li> 
            <li><a href='.route("measurmentunit.index").'>Measurment Unit</a></li> 
          
            
        </ul>
    </li>
    ';
}


function dateFormateParse(){
    return \Carbon\Carbon::parse('11/06/1990')->format('d/m/Y');

}

?>