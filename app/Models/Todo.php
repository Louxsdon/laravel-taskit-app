<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

 /**
  * Get the user that owns the Todo
  *
  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
  */
 public function user(): BelongsTo
 {
     return $this->belongsTo(User::class);
 }
}
