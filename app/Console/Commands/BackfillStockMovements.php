<?php

namespace App\Console\Commands;

use App\Models\ProductReturn;
use App\Models\StockMovement;
use App\Models\TransferStock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Stock;

class BackfillStockMovements extends Command
{
    protected $signature = 'stock:backfill';
    protected $description = 'Reconstruct historical stock movements from existing data';

    public function handle()
    {
        $this->info('Starting stock movements backfill...');
        $this->newLine();

        // Clear existing movements
        $count = StockMovement::count();
        if ($count > 0) {
            if (!$this->confirm("{$count} existing stock movements found. Delete and re-import?", true)) {
                $this->warn('Backfill cancelled.');
                return Command::FAILURE;
            }
            StockMovement::truncate();
            $this->info('Existing movements cleared.');
        }

        $validProductIds = Product::pluck('id')->toArray();

        $bar = $this->output->createProgressBar(4);
        $bar->start();

        $this->backfillOpeningStock($validProductIds);
        $bar->advance();

        $this->backfillSales($validProductIds);
        $bar->advance();

        $this->backfillTransfers($validProductIds);
        $bar->advance();

        $this->backfillReturns($validProductIds);
        $bar->advance();

        $bar->finish();
        $this->newLine(2);
        $this->info('✓ Stock movements backfill completed successfully!');
        $this->line('Total movements recorded: ' . StockMovement::count());

        return Command::SUCCESS;
    }

    /**
     * Bulk insert multiple movement records in a single query.
     */
    private function bulkInsert(array $records)
    {
        if (empty($records)) return;
        DB::table('stock_movements')->insert($records);
    }

    private function backfillOpeningStock(array $validProductIds)
    {
        $stocks = Stock::all();
        $inserted = 0;
        $skipped = 0;
        $batch = [];

        foreach ($stocks as $stock) {
            if ($stock->quantity <= 0) continue;
            if (!in_array($stock->product_id, $validProductIds)) { $skipped++; continue; }

            $ts = $stock->created_at ?? now();
            $batch[] = [
                'product_id'      => $stock->product_id,
                'type'            => $stock->type,
                'location'        => $stock->location,
                'quantity_before' => 0,
                'quantity_change' => $stock->quantity,
                'quantity_after'  => $stock->quantity,
                'reference_type'  => 'opening_stock',
                'reference_id'    => null,
                'created_by'      => 1,
                'created_at'      => $ts,
                'updated_at'      => $ts,
            ];
            $inserted++;

            if (count($batch) >= 500) {
                $this->bulkInsert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) $this->bulkInsert($batch);
        $this->line(" Opening stock: {$inserted} movements, {$skipped} skipped");
    }

    private function backfillSales(array $validProductIds)
    {
        $salesItems = DB::table('sales_items')
            ->join('sales', 'sales.id', '=', 'sales_items.order_id')
            ->select(
                'sales_items.product_id',
                'sales_items.qty',
                'sales.id as sale_id',
                'sales.created_at'
            )
            ->where('sales.status', '1')
            ->get();

        $inserted = 0;
        $skipped = 0;
        $batch = [];

        foreach ($salesItems as $item) {
            if (!in_array($item->product_id, $validProductIds)) { $skipped++; continue; }

            $ts = $item->created_at;
            $batch[] = [
                'product_id'      => $item->product_id,
                'type'            => 1,
                'location'        => 0,
                'quantity_before' => 0,
                'quantity_change' => -$item->qty,
                'quantity_after'  => 0,
                'reference_type'  => 'sale',
                'reference_id'    => $item->sale_id,
                'created_by'      => 1,
                'created_at'      => $ts,
                'updated_at'      => $ts,
            ];
            $inserted++;

            if (count($batch) >= 500) {
                $this->bulkInsert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) $this->bulkInsert($batch);
        $this->line(" Sale deductions: {$inserted} movements, {$skipped} skipped");
    }

    private function backfillTransfers(array $validProductIds)
    {
        $transfers = TransferStock::all();
        $inserted = 0;
        $skipped = 0;
        $batch = [];

        foreach ($transfers as $transfer) {
            if (!in_array($transfer->product_id, $validProductIds)) { $skipped++; continue; }

            $ts = $transfer->created_at;

            // Transfer OUT
            $batch[] = [
                'product_id'      => $transfer->product_id,
                'type'            => 2,
                'location'        => $transfer->stock_from,
                'quantity_before' => 0,
                'quantity_change' => -$transfer->quantity,
                'quantity_after'  => 0,
                'reference_type'  => 'transfer_out',
                'reference_id'    => $transfer->id,
                'created_by'      => 1,
                'created_at'      => $ts,
                'updated_at'      => $ts,
            ];

            // Transfer IN
            $batch[] = [
                'product_id'      => $transfer->product_id,
                'type'            => 1,
                'location'        => $transfer->stock_to,
                'quantity_before' => 0,
                'quantity_change' => $transfer->quantity,
                'quantity_after'  => 0,
                'reference_type'  => 'transfer_in',
                'reference_id'    => $transfer->id,
                'created_by'      => 1,
                'created_at'      => $ts,
                'updated_at'      => $ts,
            ];
            $inserted += 2;

            if (count($batch) >= 500) {
                $this->bulkInsert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) $this->bulkInsert($batch);
        $this->line(" Transfers: {$inserted} movements, {$skipped} skipped");
    }

    private function backfillReturns(array $validProductIds)
    {
        $returns = ProductReturn::with('items')->get();
        $inserted = 0;
        $skipped = 0;
        $batch = [];

        foreach ($returns as $return) {
            foreach ($return->items as $item) {
                if (!in_array($item->product_id, $validProductIds)) { $skipped++; continue; }

                $ts = $return->return_date ?? $return->created_at;

                $batch[] = [
                    'product_id'      => $item->product_id,
                    'type'            => 1,
                    'location'        => 0,
                    'quantity_before' => 0,
                    'quantity_change' => $item->quantity,
                    'quantity_after'  => 0,
                    'reference_type'  => 'return',
                    'reference_id'    => $return->id,
                    'created_by'      => 1,
                    'created_at'      => $ts,
                    'updated_at'      => $ts,
                ];
                $inserted++;

                if (count($batch) >= 500) {
                    $this->bulkInsert($batch);
                    $batch = [];
                }
            }
        }

        if (!empty($batch)) $this->bulkInsert($batch);
        $this->line(" Returns: {$inserted} movements, {$skipped} skipped");
    }
}
