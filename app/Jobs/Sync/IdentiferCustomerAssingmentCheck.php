<?php

namespace App\Jobs\Sync;

use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\TerminalRemote;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IdentiferCustomerAssingmentCheck
{
    use Dispatchable;

    public function handle()
    {
        //Retrive the Uninstall Identifier from IMS
        $TerminalIdentifierNotYetVerified =  DB::table('product_identifiers')
            ->whereNotNull('float_user_id')
            ->whereNull('CustomerID')
            ->get()
            ->pluck('code');

        // Retrive the Identifier from YBX those are not installed
        $InstalledTerminals = TerminalRemote::with('latestAssignment')
            ->whereHas('latestAssignment', function (Builder $builder) { 
                $builder->whereNotNull('CustomerID');
                })
            ->whereIn('TerminalIdentifier', $TerminalIdentifierNotYetVerified)
            ->select('TerminalID','TerminalIdentifier','TerminalIMEI')
            ->get();

        //Update IMS Identifier
        $UpdatedIdentifer = [];
        $current_date_time= Carbon::now()->toDateTimeString();
        foreach($InstalledTerminals as $InstalledTerminal) { //dd($InstalledTerminal->latestAssignment->CustomerID);
            $UpdatedIdentifer[] = $InstalledTerminal->TerminalIdentifier; //dd($InstalledTerminal);
            DB::table('product_identifiers')
                ->where('code', $InstalledTerminal->TerminalIdentifier)
                ->update([
                    'last_sync_at' => $current_date_time,
                    'TerminalAssignmentTime' => $InstalledTerminal->latestAssignment->TerminalAssignmentTime,
                    'CustomerID' => $InstalledTerminal->latestAssignment->CustomerID
                ]);
        }

        Log::info('Identifier sync pass', $UpdatedIdentifer);
        
        return $UpdatedIdentifer;
    }
}
