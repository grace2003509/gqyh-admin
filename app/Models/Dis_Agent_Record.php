<?php
/**
 * 代理商获取佣金记录
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dis_Agent_Record extends Model
{
	
	protected  $primaryKey = "Record_ID";
	protected  $table = "distribute_agent_rec";
	public $timestamps = false;
	
	// 多where
	public function scopeMultiwhere($query, $arr)
	{
		if (!is_array($arr)) {
			return $query;
		}
	
		foreach ($arr as $key => $value) {
			$query = $query->where($key, $value);
		}
		return $query;
	}
	
	
}