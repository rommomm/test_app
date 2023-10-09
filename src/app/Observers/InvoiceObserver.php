<?php

namespace App\Observers;

use App\Jobs\SendInvoiceEmailJob;
use App\Models\Invoice;

class InvoiceObserver
{
    public function created(Invoice $invoice): void
    {
        SendInvoiceEmailJob::dispatch($invoice)->onQueue('emails');
    }
}
