<?php

namespace App\Http\Enums;

class AFileHeaders
{
    const IMPORT_INVOICE_FILE_HEADERS = [
        'nfacture',  //invoice number
        'fournisseur', //supplier
        'date_facture',  //invoice date
        'devise', //currency
        'montant_ht', //amount without taxes
        'compte_de_charge' //financial account
    ];
}
