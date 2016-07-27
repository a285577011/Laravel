<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Currency extends Model
{

    protected $table = 'currency';

    public $timestamps = false;

    public static function getAll()
    {
        $data = Cache::store('file')->get('Currency:all_data');
        if (! $data) {
            $data = self::get();
            Cache::store('file')->forever('Currency:all_data', $data);
        }
        return $data;
    }

    public static function getPriceById($price, $id)
    {
        $data = self::getOne($id);
        return round($price / $data->value, 2);
    }

    public static function getOne($id)
    {
        $data = Cache::store('file')->get('Currency:data_' . $id);
        if (! $data) {
            $data = self::findOrFail($id);
            Cache::store('file')->forever('Currency:data_' . $id, $data);
        }
        return $data;
    }

    public static function add($name, $code, $value)
    {
        $self = new self();
        $self->name = $name;
        $self->code = $code;
        $self->value = $value;
        $self->creat_time = time();
        $self->update_time = time();
        if ($self->save()) {
            $data = Cache::store('file')->forget('Currency:all_data');
            return $self->id;
        }
        return false;
    }

    public static function updateById($id, $name, $code, $value)
    {
        if (is_int(self::where([
            'id' => $id
        ])->update([
            'name' => $name,
            'code' => $code,
            'value' => $value,
            'update_time' => time()
        ]))) {
            $data = Cache::store('file')->forget('Currency:data_' . $id);
            $data = Cache::store('file')->forget('Currency:all_data');
            return true;
        }
        return false;
    }

    public static function del(array $ids)
    {
        if ($ids) {
            foreach ($ids as $id) {
                self::destroy($id);
                $data = Cache::store('file')->forget('Currency:data_' . $id);
            }
            $data = Cache::store('file')->forget('Currency:all_data');
            return true;
        }
        return false;
    }
}
