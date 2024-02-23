<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalRemote extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'ybx_terminal';
    protected $primaryKey = 'TerminalID';

    public function latestAssignment()
    {
        return $this->hasOne(TerminalAssignmentRemote::class, 'TerminalID', 'TerminalID')
            ->latestOfMany('TerminalID', 'TerminalID');
    }

    public function assignments()
    {
        return $this->hasMany(TerminalAssignmentRemote::class, 'TerminalID', 'TerminalID');
    }
}
