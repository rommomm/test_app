<?php

namespace App\Http\Controllers;

use App\DTO\InvoiceDTO;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceRepository $invoiceRepository,
    ) {
        $this->authorizeResource(Invoice::class, 'invoice');
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(InvoiceResource::collection($this->invoiceRepository->getAll()));
    }

    /**
     * @param CreateInvoiceRequest $request
     * @return JsonResponse
     */
    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        $invoice = new InvoiceDTO($request->validated(), $this->getUser());

        return response()->json(new InvoiceResource($this->invoiceRepository->create($invoice->toArray())));
    }

    /**
     * @param UpdateInvoiceRequest $request
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        $updatedInvoice = new InvoiceDTO($request->validated(), $this->getUser());

        return response()->json(new InvoiceResource($this->invoiceRepository->update($invoice, $updatedInvoice->toArray())));
    }

    /**
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        $this->invoiceRepository->delete($invoice);

        return response()->json();
    }
}
