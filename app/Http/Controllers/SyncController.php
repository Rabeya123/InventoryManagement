<?php

namespace App\Http\Controllers;

use App\Jobs\Sync\CustomerTable;
use App\Jobs\Sync\IdentiferCustomerAssingmentCheck;
use App\Models\TerminalRemote;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function identifier()
    {
        try {
        
            DB::beginTransaction();
                $this->customer();
                $response = dispatch_sync(new IdentiferCustomerAssingmentCheck);
            DB::commit();
            
            Log::info('Terminal sync successfully at ' . Carbon::now()->toDateTimeString());

            return  response([
                'status' => true,
                'data' => $response
            ]);

        } catch (\Throwable $th) { //dd($th);
            
            DB::rollBack();
            Log::info('Terminal sync failed at ' . Carbon::now()->toDateTimeString());
           // Log::info('Indentifer sync failed', $th);
                return  response([
                'status' => false,
                'error' => $th
            ]);
        }
    }

    public function customer()
    {
        try {
        
            DB::beginTransaction();
                $response = dispatch_sync(new CustomerTable);
            DB::commit();
            
            return  response([
                'status' => true,
                'data' => $response
            ]);

            Log::info('Customer sync successfully at ' . Carbon::now()->toDateTimeString());

        } catch (\Throwable $th) { //dd($th);
            
            DB::rollBack();
            Log::info('Customer sync failed at ' . Carbon::now()->toDateTimeString());
                return  response([
                'status' => false,
                'error' => $th
            ]);
        }
    }
}
