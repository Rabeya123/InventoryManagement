<?php

namespace App\Jobs\Sync;

use App\Models\Customer;
use App\Models\CustomerRemote;
use Illuminate\Foundation\Bus\Dispatchable;

class CustomerTable
{
    use Dispatchable;

    public function handle()
    {
        $LastSyncCustomer = Customer::orderBy('CustomerID', 'desc')->first();
        $Customers = CustomerRemote::select('CustomerID','CustomerName','ProviderID','CustomerCode','CustomerAlertSMSRecipient','CustomerAlertEmailRecipient','TimeUpdated','TimeInserted')
            ->where('TimeUpdated', '>=', $LastSyncCustomer->updated_at)
            ->orWhere('TimeInserted', '>=', $LastSyncCustomer->updated_at)
            ->get();
        foreach($Customers as $Customer) {
            Customer::updateOrCreate(
                ['name' => $Customer->CustomerName, 'code' => $Customer->CustomerCode],
                ['mobile' => $Customer->CustomerAlertSMSRecipient, 'email' => $Customer->CustomerAlertEmailRecipient, 'CustomerID' => $Customer->CustomerID,'ProviderID' => $Customer->ProviderID,'created_by' => 1]
            );
        }
    }
}
