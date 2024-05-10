<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Instrument;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\CompanyFinancialStatement;
use App\Http\Requests\CompanyFinancialStatementRequest;

class CompanyFinancialStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_financial_statements = CompanyFinancialStatement::leftJoin('instruments', 'company_financial_statements.instrument_id', 'instruments.id')
            ->select('company_financial_statements.*', 'instruments.name AS instrument_name')
            ->get();
        // dd($company_financial_statements);
        return view('admin.company_financial_statement.index', compact('company_financial_statements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active = CommonController::IsActive();
        $instruments = Instrument::select('id', 'instrument_code', 'name')->where('active', '=', 1)
            ->orderBy('instrument_code', 'ASC')->get()->pluck('instrument_code', 'id')->prepend('Select Instrument', '0');
        return view('admin.company_financial_statement.form', compact('instruments', 'is_active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyFinancialStatementRequest $request)
    {
        $formData = $request->validated();

        $exist = DB::table('company_financial_statements')
            ->where('instrument_id', '=', $formData['instrument_id'])
            ->where('date_time', '=', $formData['date_time'])
            ->first();

        if ($exist) {
            Session::flash('message', 'Data already exists');
            return redirect()->back();
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension(); // Generate a unique name
            $filePath = 'uploads/financial_statement/' . $fileName; // Concatenate path with file name

            $file->move(public_path('uploads/financial_statement'), $fileName);

            // Add watermark to the PDF file
            // $watermarkedFileName = $this->addWatermarkToPdf(public_path('uploads/financial_statement/') . $fileName);

            $formData['file'] = $filePath; // Store file path in database
        }

        $companyFinancialStatement = CompanyFinancialStatement::create($formData);

        Session::flash('message', 'New Financial Statement Created Successfully');
        return redirect()->route('company_financial_statement.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyFinancialStatement  $companyFinancialStatement
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyFinancialStatement $companyFinancialStatement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyFinancialStatement  $companyFinancialStatement
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyFinancialStatement $companyFinancialStatement)
    {
        $is_active = CommonController::IsActive();
        $instruments = Instrument::select('id', 'instrument_code', 'name')->where('active', '=', 1)
            ->orderBy('instrument_code', 'ASC')->get()->pluck('instrument_code', 'id')->prepend('Select Instrument', '0');
        return view('admin.company_financial_statement.form')->with(['item' => $companyFinancialStatement, 'is_active' => $is_active, 'instruments' => $instruments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyFinancialStatement  $companyFinancialStatement
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyFinancialStatementRequest $request, CompanyFinancialStatement $companyFinancialStatement)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            // Delete the existing file if it exists
            if ($companyFinancialStatement->file) {
                $filePath = public_path('uploads/financial_statement/' . $companyFinancialStatement->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Upload the new file
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/financial_statement/' . $fileName; // Concatenate path with file name

            $file->move(public_path('uploads/financial_statement'), $fileName);

            // Add watermark to the PDF file
            // $watermarkedFileName = $this->addWatermarkToPdf(public_path('uploads/financial_statement/') . $fileName);
            $validatedData['file'] = $filePath; // Store file path in database
        }

        $companyFinancialStatement->update($validatedData);
        Session::flash('success', 'Company financial statement has been successfully updated.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyFinancialStatement  $companyFinancialStatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyFinancialStatement $companyFinancialStatement)
    {
        $companyFinancialStatement->delete();
        return redirect()->back()->with('status', 'Company Financial Statement Deleted Successfully');
    }

    // last commit for atik 28-02-2024

    private function addWatermarkToPdf($filePath)
    {
        dd($filePath);
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        $pdfContent = file_get_contents($filePath);

        // Explicitly specify the character encoding (if known)
        $pdfContent = mb_convert_encoding($pdfContent, 'HTML-ENTITIES', 'UTF-8');

        $dompdf->loadHtml($pdfContent);
        $dompdf->render();

        // Get the canvas object
        $canvas = $dompdf->getCanvas();

        // Get watermark image path
        $watermarkImage = public_path('assets/images/watermark_logo.jpg');

        // Load watermark image
        $watermark = file_get_contents($watermarkImage);

        // Get watermark image dimensions
        $imageInfo = getimagesize($watermarkImage);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];

        // Calculate watermark position
        $x = 50; // Adjust as needed
        $y = 50; // Adjust as needed

        // Iterate through each page to add watermark
        $pageCount = $dompdf->getCanvas()->get_page_count();
        for ($pageNumber = 0; $pageNumber < $pageCount; $pageNumber++) {
            $dompdf->getCanvas()->page_script('
        $pdf = $canvas->get_dompdf()->get_canvas();
        $image = "' . $watermarkImage . '";
        $x = ' . $x . ';
        $y = ' . $y . ';
        $size = getimagesize($image);
        $pdf->image(@$image, $x, $y, $size[0], $size[1]);
    ', $pageNumber);
        }

        // Output the watermarked PDF content
        $outputFilePath = public_path('uploads/financial_statement/watermarked_' . basename($filePath));
        file_put_contents($outputFilePath, $dompdf->output());

        return 'watermarked_' . basename($filePath);
    }
}
