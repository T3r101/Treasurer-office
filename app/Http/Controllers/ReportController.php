<?php

namespace App\Http\Controllers;

use App\Services\SummaryReportService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(SummaryReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        return view('reports.index');
    }

    /**
     * Export the summary report as a CSV.
     */
    public function export(Request $request)
    {
        $reportType = $request->input('report_type');
        $filters = [
            'start_date' => $request->start_date ?? $request->from_date,
            'end_date' => $request->end_date ?? $request->to_date,
            'specific_fund' => $request->specific_fund,
            'check_no' => $request->input('check_no_filter')
        ];

        return match ($reportType) {
            'soe' => redirect()->route('reports.soe', $filters),
            'cdr' => redirect()->route('reports.cdr', array_merge($filters, ['cheque_number' => $request->input('check_no_filter')])),
            default => redirect()->route('reports.index')->with('error', 'Invalid report type selected.'),
        };
    }

    public function generateSOE(Request $request)
    {
        $filters = [
            'start_date' => $request->start_date ?? $request->from_date,
            'end_date' => $request->end_date ?? $request->to_date,
            'specific_fund' => $request->specific_fund
        ];
        $signatories = $request->only([
            'prepared_by_name', 'prepared_by_position', 
            'approved_by_name', 'approved_by_position'
        ]);
        $data = $this->reportService->getSOEData($filters);
        return view('reports.soe', compact('data', 'signatories'));
    }

    public function generateCDR(Request $request)
    {
        $filters = [
            'start_date' => $request->start_date ?? $request->from_date,
            'end_date' => $request->end_date ?? $request->to_date,
            'specific_fund' => $request->specific_fund
        ];
        $signatories = $request->only([
            'prepared_by_name', 'prepared_by_position', 
            'approved_by_name', 'approved_by_position'
        ]);
        $data = $this->reportService->getCDRData($filters);
        return view('reports.cdr', compact('data', 'signatories'));
    }

    /**
     * Download SOE as PDF.
     */
    public function downloadSOE(Request $request)
    {
        $filters = [
            'start_date' => $request->start_date ?? $request->from_date,
            'end_date' => $request->end_date ?? $request->to_date,
            'specific_fund' => $request->specific_fund,
            'check_no' => $request->check_no
        ];
        $signatories = $request->only([
            'prepared_by_name', 'prepared_by_position', 
            'approved_by_name', 'approved_by_position'
        ]);
        
        // Persist signatories in session
        session()->put($signatories);

        $data = $this->reportService->getSOEData($filters);
        $format = $request->input('format', 'pdf');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.export_pdf', [
                'transactions' => $data, 
                'filters' => $filters, 
                'signatories' => $signatories
            ]);
            return $pdf->stream('SOE_Report_' . now()->format('Ymd') . '.pdf');
        }

        // CSV export
        return new StreamedResponse(function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Check No', 'Payee', 'Nature of Payment', 'Account Code', 'Specific Fund', 'Amount']);
            foreach ($data as $item) {
                $date = $item->transaction_date instanceof \Carbon\Carbon ? $item->transaction_date : \Carbon\Carbon::parse($item->transaction_date);
                fputcsv($file, [
                    $date->format('Y-m-d'),
                    $item->check_no,
                    $item->payee,
                    $item->nature_of_payment,
                    $item->account_code,
                    $item->specific_fund,
                    $item->amount_issued ?? $item->amount,
                ]);
            }
            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="SOE_Report_' . now()->format('Ymd') . '.csv"',
        ]);
    }

    /**
     * Download CDR as PDF.
     */
    public function downloadCDR(Request $request)
    {
        $filters = [
            'start_date' => $request->start_date ?? $request->from_date,
            'end_date' => $request->end_date ?? $request->to_date,
            'specific_fund' => $request->specific_fund,
            'cheque_number' => $request->cheque_number
        ];
        $signatories = $request->only([
            'prepared_by_name', 'prepared_by_position', 
            'approved_by_name', 'approved_by_position'
        ]);
        
        // Persist signatories in session
        session()->put($signatories);

        $data = $this->reportService->getCDRData($filters);
        $format = $request->input('format', 'pdf');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.export_pdf_cdr', [
                'data' => $data, 
                'filters' => $filters, 
                'signatories' => $signatories
            ]);
            return $pdf->stream('CDR_Report_' . now()->format('Ymd') . '.pdf');
        }

        // CSV export
        return new StreamedResponse(function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Check No', 'Payee', 'Nature of Payment', 'Specific Fund', 'Amount']);
            foreach ($data as $item) {
                $date = $item->deposit_date instanceof \Carbon\Carbon ? $item->deposit_date : \Carbon\Carbon::parse($item->deposit_date);
                fputcsv($file, [
                    $date->format('Y-m-d'),
                    $item->cheque_number,
                    $item->payee,
                    $item->nature_of_payment,
                    $item->specific_fund,
                    $item->amount,
                ]);
            }
            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="CDR_Report_' . now()->format('Ymd') . '.csv"',
        ]);
    }
}
