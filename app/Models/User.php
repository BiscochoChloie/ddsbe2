<?php
 
namespace App\Model;
 
use Illuminate\Database\Eloquent\Model;
 
class User extends Model{
 
    protected $table = 'users';
    
    // column sa table 
    protected $fillable = [
    'username', 'passowrd'

 ];
 }
?>