<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoicesController extends Controller
{
    public function index(Request $request, $password)
    {

        if ($password === '1234') {
            $request->validate([
                'order' => 'nullable|string',
                'order_by' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            $orderBy = $request->order_by ?? 'sent_at';
            $order = $request->order ?? 'ASC';

            $invoices = Invoice::with('products')->orderBy($orderBy, $order)->paginate(20);

            return response()->json($invoices);
        }

        return response()
            ->json([
                'code' => 500,
                'message' => 'missing password parameter'
            ], 500);
    }

    public function show($password, Invoice $invoice)
    {
        if ($password === '1234') {
            $invoice->load('products');

            return response()->json($invoice);
        }

        return response()
            ->json([
                'code' => 500,
                'message' => 'missing password parameter'
            ], 500);
    }

    public function store(InvoiceRequest $invoiceRequest, $password)
    {
        if ($password === '1234') {
            Invoice::create($invoiceRequest->validated());

            return redirect()->back();
        }

        return response()
            ->json([
                'code' => 500,
                'message' => 'missing password parameter'
            ], 500);
    }

}
