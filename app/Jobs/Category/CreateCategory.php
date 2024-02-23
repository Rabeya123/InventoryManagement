<?php

namespace App\Jobs\Category;
use App\Models\Category;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateCategory
{
    use Dispatchable;
    
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $request)
    {
        $this->request=$request; 
    }

    public function handle()
    {
        return Category::create($this->request);
    }
}
