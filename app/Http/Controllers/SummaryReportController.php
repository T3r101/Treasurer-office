<?php

namespace App\Http\Controllers;

use App\Services\SummaryReportService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class SummaryReportController extends Controller
{
    protected const SIGNATORY_KEYS = [
        'prepared_by_name', 'prepared_by_position', 
        'approved_by_name', 'approved_by_position'
    ];

    public function __construct(
        protected SummaryReportService $reportService
    ) {}

    /**
     * Display the report selection page.
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Display the Summary Report.
     */
    public function generate(Request $request): View
    {
        $filters = $request->only(['start_date', 'end_date', 'specific_fund']);
        $reportData = $this->reportService->getSummaryReport($filters);

        return view('reports.summary', compact('reportData'));
    }

    /**
     * Handle the export request for different report types.
     */
    public function export(Request $request)
    {
        $reportType = $request->input('report_type');
        $filters = $request->only(array_merge(['start_date', 'end_date', 'specific_fund'], self::SIGNATORY_KEYS));

        // Persist signatories
        session()->put($request->only(self::SIGNATORY_KEYS));

        return match ($reportType) {
            'soe' => redirect()->route('reports.soe', $filters),
            'cdr' => redirect()->route('reports.cdr', $filters),
            default => redirect()->route('reports.index')->with('error', 'Invalid report type selected.'),
        };
    }

    /**
     * Generate the SOE Preview page.
     */
    public function generateSOE(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'specific_fund', 'check_no']);
        $signatories = $request->only(self::SIGNATORY_KEYS);
        
        $data = $this->reportService->getSOEData($filters);
        return view('reports.soe', compact('data', 'signatories'));
    }

    /**
     * Generate the CDR Preview page.
     */
    public function generateCDR(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'specific_fund', 'cheque_number']);
        $signatories = $request->only(self::SIGNATORY_KEYS);

        $data = $this->reportService->getCDRData($filters);
        return view('reports.cdr', compact('data', 'signatories'));
    }

    public function downloadSOE(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'specific_fund', 'check_no']);
        $reportSignatories = $request->only(self::SIGNATORY_KEYS);

        // Persist signatories in session
        session()->put($reportSignatories);

        $data = $this->reportService->getSOEData($filters);
        $format = $request->input('format', 'pdf');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.export_pdf', ['transactions' => $data, 'filters' => $filters, 'signatories' => $reportSignatories]);
            return $pdf->stream('SOE_Report_' . now()->format('Ymd') . '.pdf');
        }

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
                    $this->getEffectiveAmount($item),
                ]);
            }
            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="SOE_Report_' . now()->format('Ymd') . '.csv"',
        ]);
    }

    public function downloadCDR(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'specific_fund', 'cheque_number']);
        $reportSignatories = $request->only(self::SIGNATORY_KEYS);

        // Persist signatories in session
        session()->put($reportSignatories);

        $data = $this->reportService->getCDRData($filters);
        $format = $request->input('format', 'pdf');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.export_pdf_cdr', ['data' => $data, 'filters' => $filters, 'signatories' => $reportSignatories]);
            return $pdf->stream('CDR_Report_' . now()->format('Ymd') . '.pdf');
        }

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

    /**
     * Helper to get the actual amount for transactions.
     */
    private function getEffectiveAmount($item)
    {
        return (float) ($item->amount_issued > 0 ? $item->amount_issued : $item->amount);
    }
}