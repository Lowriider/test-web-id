<?php

namespace Tests\Unit;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use function Laravel\Prompts\password;

class InvoiceTest extends TestCase
{
    public function test_can_get_invoices()
    {
        $this->get(route('api.invoices.index', '1234'))->assertSuccessful();
    }

    public function test_invoices_pagination()
    {
        Invoice::factory()->count(100)->create();

        $response = $this->getJson(route('api.invoices.index', '1234'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'customer_name',
                    'number',
                    'status',
                    'sent_at',
                    'paid_at',
                    'total',
                    'products' => [
                        '*' => [
                            'name',
                            'price'
                        ]
                    ]
                ]
            ],
        ]);

        $response->assertJsonCount(20, 'data'); // Vérifie que 20 factures sont retournées par page
    }

    public function test_invoices_are_sorted_by_sent_at()
    {
        $oldInvoice = Invoice::factory()->create(['sent_at' => now()->subDays(5)]);
        $newInvoice = Invoice::factory()->create(['sent_at' => now()]);

        $response = $this->getJson(route('api.invoices.index', '1234'));

        $response->assertStatus(200);
        $this->assertTrue($response->json('invoices.0.sent_at') >= $response->json('invoices.1.sent_at'));
    }

    public function test_invoice_total_is_correct()
    {
        $products = Product::factory(
            [
                'name' => 'test',
                'price' => 10.00
            ]
        )->count(3);

        $invoice =  Invoice::factory()->hasAttached($products)->create();

        $response = $this->getJson(route('api.invoices.show', ['1234',$invoice]));

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'total' => 30.00
        ]);
    }

    public function test_invoice_with_different_status()
    {
        $invoice = Invoice::factory()->create([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $response = $this->getJson(route('api.invoices.show', ['1234',$invoice]));

        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => 'paid']);
    }
}
