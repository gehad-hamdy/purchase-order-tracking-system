<?php

namespace App\Http\UseCases;

interface IInvoices
{
    public function bulkInsertInvoices($data);

    public function listAllInvoices();

    public function searchInvoice($data);
}
