<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class UserJob extends Model{
 
    protected $table = 'usersjob';
    
    // column sa table 
    protected $fillable = [
    'jobId','jobname'

 ];
    public $timestamps=false;
    protected $primaryKey = 'jobId';

 
 }
?>