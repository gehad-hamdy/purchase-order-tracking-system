<?php

namespace App\Http\Repositories;



use App\Models\Invoice;

class InvoiceRepository
{
    public function bulkInsertInvoices($data){
        Invoice::insert($data);
    }

    public function listAllInvoiceData(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Invoice::query()->paginate(50);
    }

    public function searchInvoiceData($data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Invoice::query();

        if (isset($data['invoice_number'])){
          $query->where('invoice_number', '=', $data['invoice_number']);
        }

        if (isset($data['supplier_name'])){
          $query->where('supplier_name', 'like', '%'.$data['supplier_name'].'%');
        }

        if (isset($data['financial_account'])){
          $query->where('financial_account_id', '=', $data['financial_account']);
        }

        if (isset($data['invoice_date'])){
          $query->where('invoice_date', '>=', $data['invoice_date'])
                ->where('invoice_date', '<=', $data['invoice_date']);
        }

        return $query->paginate(50);
    }
}
