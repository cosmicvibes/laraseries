<?php

namespace Cosmicvibes\Laraseries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NumberSeries extends Model
{
    protected $fillable = [
        'code',
        'name',
        'prefix',
        'suffix',
        'length',
        'increment_by',
        'padding_character',
        'start_date',
        'end_date',
        'active',
        'starting_number',
        'ending_number',
        'last_used_number'
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (is_null($model->ending_number)) {
                $model->ending_number = str_pad(9, $model->length, 9, STR_PAD_LEFT);
            }

            if (is_null($model->last_used_number)) {
                $model->last_used_number = $model->starting_number;
            }
        });
    }

    public function getCurrentAttribute()
    {
        return $this->currentNumber();
    }

    private function currentNumber()
    {
        $last_used_number = str_pad($this->last_used_number, $this->length, $this->padding_character, STR_PAD_LEFT);
        return $this->prefix.$last_used_number.$this->suffix;
    }

    public function advance($step = 0)
    {
        DB::beginTransaction();
        $next_number = ($this->last_used_number + $step + $this->increment_by);
        if ($next_number > $this->ending_number) {
            return null;
            // TODO: Throw exception? Return current value? I'll leave at null for now to allow the user to check if it worked
        }
        $this->last_used_number = $next_number;
        $this->save();

        $new_current_formatted_number = $this->current;
        DB::commit();

        return $new_current_formatted_number;
    }
}
