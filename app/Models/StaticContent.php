<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class StaticContent
{
    CONST CACHE_KEY = 'static-content';

    public function list() {
        $data = Cache::get(self::CACHE_KEY);
        return ($data) ? $data : [];
    }

    public function create($create) {
        $data = Cache::get(self::CACHE_KEY);
        $next = Count($data);

        $data[$next + 1] = $create;
        Cache::forever(self::CACHE_KEY, $data);
    }

    public function find($id) {
        $data = Cache::get(self::CACHE_KEY);

        if(isset($data[$id])) {
            $data[$id]['id'] = $id;
            return $data[$id];
        }
        
        return false;
    }

    public function update($id, $update) {
        $data = Cache::get(self::CACHE_KEY);

        if(isset($data[$id])) {
            $data[$id] = $update;
            Cache::forever(self::CACHE_KEY, $data);
        }

        return false;
    }

    public function delete($id) {
        $data = Cache::get(self::CACHE_KEY);

        if(isset($data[$id])) {
            unset($data[$id]);
            Cache::forever(self::CACHE_KEY, $data);
        }

        return false;
    }
}
