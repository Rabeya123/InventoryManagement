<?php

namespace App\Jobs\Category;

use App\Models\Category;
use Illuminate\Foundation\Bus\Dispatchable;


class UpdateCategory
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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
        $Category = Category::findOrFail($this->id);
        $Category->update($this->request);
        $Category->refresh();
        return $Category;
    }
}
