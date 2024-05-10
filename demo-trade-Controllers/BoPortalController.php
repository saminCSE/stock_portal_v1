<?php

namespace App\Http\Controllers;

use File;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BeneficiaryOwners;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BoPortalController extends Controller
{
    public function loginform()
    {
        if (auth('boportal')->user()) {
            return redirect()->route('boportal.dashboard');
        }
        return view('boportal.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('boportal')->attempt($credentials)) {
            // Authentication successful
            return redirect()->route('boportal.dashboard');
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function dashboard(Request $request)
    {
        $query = DB::table('beneficiary_owners')->orderBy('created_at', 'desc');

        $reg_id = $request->reg_id;
        $reg_id = str_replace("SCL-", "", $reg_id);
        $q = $request->q;
        $from_date = $request->from_date;
        if ($from_date) {
            $from_date = Carbon::parse($from_date)->format('y-m-d');
        }
        $to_date = $request->to_date;
        if ($to_date) {
            $to_date = Carbon::parse($to_date)->format('y-m-d');
        }


        // dd($from_date , $to_date);

        if ($reg_id) {
            $query->where('id', $reg_id);
        }

        if ($q) {
            $query->where(function ($subquery) use ($q) {
                $subquery->where('name', 'like', '%' . $q . '%')
                    ->orWhere('mobile', 'like', '%' . $q . '%')
                    ->orWhere('nid', 'like', '%' . $q . '%');
            });
        }
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $bos = $query->paginate(10);

        return view('boportal.dashboard', compact('bos'));
    }

    public function logout()
    {
        auth('boportal')->logout();
        return redirect()->back();
    }


    public function changepassword()
    {
        return view('boportal.changepassword');
    }
    public function changePasswordsubmit(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'retype_password' => 'required|same:new_password',
        ]);

        $user = Auth::guard('boportal')->user();


        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->back()->with('message', 'Password updated successfully');
        } else {
            return redirect()->back()->with('error', 'Old password is incorrect');
        }

    }


    public function boGenerateimages($id)
    {
        $beneficiaryOwner = DB::table('beneficiary_owners')
            ->where('beneficiary_owners.id', '=', $id)
            ->select('name', 'applicants_image', 'applicants_sign', 'applicants_nid', 'applicants_bank_check')
            ->first();

        $bo_nominees = DB::table('bo_account_nominees')
            ->where('bo_account_nominees.benificiary_owners_id', '=', $id)
            ->select('nominees_image', 'nominees_sign', 'nominees_nid')
            ->get();

        $imagesDirectory = public_path('uploads/BO');
        $zipFileName = 'SCL-' . $beneficiaryOwner->name . $id . '-images.zip';
        $zipFilePath = public_path($zipFileName);

        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $this->addImagesToZip($zip, $imagesDirectory, [
                'applicants_image' => $beneficiaryOwner->applicants_image,
                'applicants_sign' => $beneficiaryOwner->applicants_sign,
                'applicants_nid' => $beneficiaryOwner->applicants_nid,
                'applicants_bank_check' => $beneficiaryOwner->applicants_bank_check,
            ]);

            $nomineeIndex = 1;
            foreach ($bo_nominees as $nominee) {
                $this->addImagesToZip($zip, $imagesDirectory, [
                    'nominees_image' => $nominee->nominees_image,
                    'nominees_sign' => $nominee->nominees_sign,
                    'nominees_nid' => $nominee->nominees_nid,
                ], $nomineeIndex);
                $nomineeIndex++;
            }

            $zip->close();

            if (file_exists($zipFilePath)) {
                return response()->download($zipFilePath)->deleteFileAfterSend();
            } else {
                return redirect()->back()->with('error', 'No Image Found');
            }
        }
    }

    private function addImagesToZip($zip, $imagesDirectory, $imagePaths, $nomineeIndex = null)
    {
        foreach ($imagePaths as $imageName => $imagePath) {
            if ($imagePath !== null && trim($imagePath) !== '') {
                $fullImagePath = $imagesDirectory . DIRECTORY_SEPARATOR . $imagePath;

                $fileNameInZip = $imageName;
                if ($nomineeIndex !== null) {
                    $fileNameInZip .= '_' . $nomineeIndex;
                }

                if (File::exists($fullImagePath)) {
                    $zip->addFile($fullImagePath, $fileNameInZip . '.' . pathinfo($imagePath, PATHINFO_EXTENSION));
                }
            }
        }
    }



    public function boactivetoggle($id)
    {
        $beneficiaryOwner = BeneficiaryOwners::where('beneficiary_owners.id', '=', $id)
            ->first();
        if ($beneficiaryOwner->is_active == 1) {
            $beneficiaryOwner->is_active = 0;
        } else {
            $beneficiaryOwner->is_active = 1;
        }
        $beneficiaryOwner->save();
        return redirect()->back();
    }


}
