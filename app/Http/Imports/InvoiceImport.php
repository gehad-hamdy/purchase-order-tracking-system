<?php

namespace App\Http\Imports;

use App\Http\UseCases\InvoiceUseCase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvoiceImport implements ToCollection, WithHeadingRow
{
    private $header;
    private $data;
    private $invoiceUseCase;
    private $validHeader = true;

    public function __construct(InvoiceUseCase $invoiceUseCase){
        $this->header = \App\Http\Enums\AFileHeaders::IMPORT_INVOICE_FILE_HEADERS;
        $this->invoiceUseCase = $invoiceUseCase;
    }

    public function collection(Collection $collection)
    {
        $this->validateHeader($collection[0]);
        if ($this->validHeader) {
            foreach ($collection as $index => $row) {
                if ($index == 0) continue;
                $this->constructRowData($row);
            }
        }

        $this->invoiceUseCase->bulkInsertInvoices($this->getData());
    }

    public function validateHeader($row){
        foreach ($this->header as $name){
            if (!isset($row[$name])) {
                $this->validHeader = false;
                break;
            }
        }
    }

    public function constructRowData($row){
        $this->data[] = [
            'invoice_number' => $row['nfacture'],
            'supplier_name' => $row['fournisseur'],
            'currency' => $row['devise'],
            'amount' => $row['montant_ht'],
            'invoice_date' => date('Y-m-d', strtotime($row['date_creation_facture'])),
            'financial_account_id' => $row['compte_ap'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function getData() {
        return $this->data;
    }
}
