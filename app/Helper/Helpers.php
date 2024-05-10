<?php 
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



function changeDateFormate($date,$date_format = 'Y-m-d'){
    return Carbon::parse($date)->format($date_format);    
}
function cdateFormate($dformat){
    return Carbon::now()->format($dformat);    
}
   
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function dayAddWithDate($date = '',$days = 0){
        
    if($date) {
        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d", $date);
    }
    else {
        return '';
    }
}
function changeDate($date = '',$days = 0){
        
    if($date) {
        $date = strtotime($days." days", strtotime($date));
        return  date("Y-m-d", $date);
    }
    else {
        return '';
    }
}
function existedDayName($day){
    $fullweek =  [
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu'
    ];

    if (in_array($day, $fullweek))
    {
        return true;
    }
    else
    {
        return false;
    }
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

function pr($data) {
    echo '<pre>';
        print_r($data);
    echo '</pre>';
    
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
function getAllotmentGrade($key){
   
    $allotment_grade = array(
        '1' => 1,
        '2' => 1,
        '3' => 2,
        '4' => 2,
        '5' => 3,
        '6' => 4,
        '7' => 4,
        '8' => 4,
        '9' => 4,
        '10' => 5,
        '11' => 5,
        '12' => 5,
        '13' => 5,
        '14' => 5,
    );

    return $allotment_grade[$key];

    
}

function getQuarterly($key){
    $quarterly = array(
        '01'=>3,
        '02'=>3,
        '03'=>3,
        '04'=>4,
        '05'=>4,
        '06'=>4,
        '07'=>1,
        '08'=>1,
        '09'=>1,
        '10'=>2,
        '11'=>2,
        '12'=>2
    );
    return $quarterly[$key];
}



function sidebarhtml() {

    $role_id = Auth()->user()->role_id;
    $token = Session::get('LoggedUser')->token;

    if(!$role_id) {
        return '';
    }
// DB::enableQueryLog();
    $menu = Menu::select('menus.*','role_menus.id as roleid','role_menus.role_id','role_menus.menu_id')
    ->from('role_menus')
    ->leftJoin('menus','role_menus.menu_id','=','menus.id')
    ->where('menus.is_active',1)
    ->where('menus.parent_id',0)
    ->where('role_menus.role_id',$role_id)
    ->orderBy('menus.orderno','ASC')
    ->get();
// $abc = DB::getQueryLog();
//  return $abc;
    $htmlsidebar = '<ul class="metismenu list-unstyled" id="side-menu">';

    foreach($menu as $key=>$val) {

        $submenu = Menu::select('menus.*','role_menus.id as roleid','role_menus.role_id','role_menus.menu_id')
        ->from('role_menus')
        ->leftJoin('menus','role_menus.menu_id','=','menus.id')
        ->where('menus.is_active',1)
        ->where('menus.parent_id',$val->id)
        ->where('role_menus.role_id',$role_id)
        ->orderBy('menus.orderno','ASC')
        ->get();

        if(count($submenu)) {

            $submenu_parent = '';
            if($val->project_no ==1) {
                if($val->slug) {
                    $submenu_parent =' 
                    <a href="javascript: void(0);" class="has-arrow waves-effect submenu">
                        <i class="'.$val->icon_id.'"></i>
                        <span>'.$val->menu_name.'</span>
                    </a>
               ';
                }
                else {
                    $submenu_parent =' 
                    <a href="javascript: void(0);" class="has-arrow waves-effect submenu">
                        <i class="'.$val->icon_id.'"></i>
                        <span>'.$val->menu_name.'</span>
                    </a>
               ';
                }
                
            }
            else {
                $submenu_parent ='
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="'.$val->icon_id.'"></i>
                        <span>'.$val->menu_name.'</span>
                    </a>
                ';
            }

            $htmlsidebar .= '<li>'.$submenu_parent;
            
            $htmlsidebar .= '<ul class="sub-menu" aria-expanded="false">';

                foreach($submenu as $skey =>$sval) {
                    if($sval->project_no ==1) {
                         if($sval->slug) {
                            $htmlsidebar .='<li><a href="'.config('siteconfig.server_1').''. $sval->slug.'">'.$sval->menu_name.'</a></li> ';
                         }
                        
                    }
                    else {
                        $htmlsidebar .='<li><a href="'.config('siteconfig.server_2').''.$sval->slug.'?token='.$token.'">'.$sval->menu_name.'</a></li> ';
                    }
                }
               
              
                
            $htmlsidebar .='</ul>';
        $htmlsidebar .='</li>';
        }
        else {
            if($val->project_no ==1) {

                if($val->slug) {
                    $htmlsidebar .=' <li>
                    <a href="'.config('siteconfig.server_1').''. $val->slug.'" class="waves-effect">
                        <i class="'.$val->icon_id.'"></i>
                        <span>'.$val->menu_name.'</span>
                    </a>
                    </li>';
                }

                else {
                    $htmlsidebar .=' <li>
                    <a href="'.config('siteconfig.server_1_base').'" class="waves-effect">
                        <i class="'.$val->icon_id.'"></i>
                        <span>'.$val->menu_name.'</span>
                    </a>
                    </li>';
                }
               
            }
            else {
                $htmlsidebar .=' <li>
                    <a href="'.config('siteconfig.server_2').''.$val->slug.'?token='.$token.'" class="waves-effect">
                        <i class="'.$val->icon_id.'"></i>
                        <span>'.$val->menu_name.'</span>
                    </a>
                </li>';
            }
           
        }

       
    }

        // $htmlsidebar .='<li>
        //         <a href="javascript: void(0);" class="has-arrow waves-effect">
        //             <i class="fas fa-tools"></i>
        //             <span>Menu</span>
        //         </a>
        //         <ul class="sub-menu" aria-expanded="false">
        //             <li><a href='.route("menu.create").'>Menu Add</a></li> 
        //             <li><a href='.route("menu.index").'>Menu List</a></li> 
        //             <li><a href='.route("rolemenu.create").'>Role Menu Add</a></li> 
        //             <li><a href='.route("rolemenu.index").'>Role Menu List</a></li> 
        //         </ul>
        //     </li>';
        // $htmlsidebar .='<li>
        //         <a href="javascript: void(0);" class="has-arrow waves-effect">
        //             <i class="fas fa-tools"></i>
        //             <span>aaaa</span>
        //         </a>
        //         <ul class="sub-menu" aria-expanded="false">
        //             <li><a href="'.config('siteconfig.server_1').'inventory/currentinventory">Menu Add</a></li> 
                  
        //         </ul>
        //     </li>';
        // $htmlsidebar .='<li>
        //         <a href="javascript: void(0);" class="has-arrow waves-effect">
        //             <i class="fas fa-tools"></i>
        //             <span>Permission</span>
        //         </a>
        //         <ul class="sub-menu" aria-expanded="false">
        //             <li><a href="'.config('siteconfig.server_1').'permissionlabel   ">Permission Label </a></li> 
        //             <li><a href="'.config('siteconfig.server_1').'permissionrole">Role Permission</a></li> 
                  
        //         </ul>
        //     </li>';
    $htmlsidebar .='</ul>';
   

    return $htmlsidebar;

}
function pageLimit(){
    return config('siteconfig.pageLimit');
 }
 function expiredAt(){
    return config('siteconfig.expiredAt');
 }
?>