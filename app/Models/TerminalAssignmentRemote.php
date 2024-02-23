<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalAssignmentRemote extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'ybx_terminalassignment';
    protected $primaryKey = 'TerminalAssignmentID';
}
