<?php

namespace App\Jobs\Unit;

use App\Models\Unit;
use Illuminate\Foundation\Bus\Dispatchable;


class UpdateUnit
{
    use Dispatchable;
    protected $request; 
    protected $id;
    public function __construct(array $request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Unit = Unit::findOrFail($this->id);
        $Unit->update($this->request);
        $Unit->refresh();
        return $Unit;
    }
}
