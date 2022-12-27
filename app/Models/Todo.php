<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;


 protected $fillable = [
    'todo',
    'finished'
 ];

//  todo scope filter
 public function scopeFilter($query, array $params){
   // dd($params['filter'] ?? false, $query);
   if($params['filters'] ?? false){
      $query->where('todo', 'like', '%'.$params['filters'].'%');
   }
 }
}
