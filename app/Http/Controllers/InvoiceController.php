<?php

namespace App\Http\Controllers;

use App\Http\Imports\InvoiceImport;
use App\Http\UseCases\InvoiceUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    private $invoiceUseCase;

    public function __construct(InvoiceUseCase $invoiceUseCase)
    {
        $this->invoiceUseCase = $invoiceUseCase;
    }

    public function importInvoices(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'sheet' => 'required|max:250'
            ]);
            if ($validator->fails()) {
                return Response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'msg' => $validator->errors()->first(),
                    'details' => $validator->errors()
                ], 400);
            }
            if ($request->hasFile('sheet')) {
                $sheet = $request->file('sheet');

                $ext = $sheet->getClientOriginalExtension();
                // server side file validation
                if ($ext == 'xlsx' || $ext == 'csv') {
                    Excel::import(new InvoiceImport($this->invoiceUseCase), $request->file('sheet'));
                    return response()->json([
                        'status' => true,
                        'msg' => 'Imported successfully',
                        'data' => []
                    ], 200);
                }
            }

            return response()->json([
                'status' => false,
                'msg' => 'Invalid data file type',
                'data' => []
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function listInvoices(): \Illuminate\Http\JsonResponse
    {
       $invoices = $this->invoiceUseCase->listAllInvoices();
        return response()->json($invoices, 200);
    }

    public function searchInvoice(Request $request): \Illuminate\Http\JsonResponse
    {
        $invoices = $this->invoiceUseCase->searchInvoice($request->all());
        return response()->json($invoices, 200);
    }
}
