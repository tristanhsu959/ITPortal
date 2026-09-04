<?php

namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

#Util helper
class HelperLib
{
	public function __construct()
	{
	}
	
	public static function appName()
	{
		$env = env('APP_ENV');
		$appName = env('APP_NAME');
		
		$name = "八方雲集 $appName";
		
		if ($env == 'production')
			return $name;
		else
			return $name . "-Staging";
	}
	
	/* Cache name
	 * @params: string
	 * @params: array
	 * @return: object
	 */
	public static function buildCacheKey(array $params)
	{
		$keys[] = array_filter($params);
		$keys = Arr::whereNotNull(Arr::flatten($keys));
		
		return implode(':', $keys);
	}
	
	public static function versionAsset($path) 
	{
        $fullPath = public_path($path);
        
        #檢查檔案是否存在，避免報錯
        if (file_exists($fullPath)) 
		    return asset($path) . '?v=' . filemtime($fullPath);
        
        return asset($path);
    }
}