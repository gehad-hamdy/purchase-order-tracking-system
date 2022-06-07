<?php

namespace App\Http\UseCases;

use App\Http\Repositories\InvoiceRepository;

class InvoiceUseCase implements IInvoices
{
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository){
        $this->invoiceRepository = $invoiceRepository;
    }

    public function bulkInsertInvoices($data){
      $this->invoiceRepository->bulkInsertInvoices($data);
    }

    public function listAllInvoices(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->invoiceRepository->listAllInvoiceData();
    }

    public function searchInvoice($data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->invoiceRepository->searchInvoiceData($data);
    }
}
