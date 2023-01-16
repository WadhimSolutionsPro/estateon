<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Property;
class commonfunction extends Model
{
    //
    public static function createSlug($title, $id = 0, $type)
    {
        // Normalize the title
        $slug = $title;

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        if($type=="user"){
            $allSlugs = self::getRelatedSlugs($slug, $id);
        }
        if($type=='property'){
            $allSlugs = self::getPropertySlugs($slug, $id);
        }
     

       
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    public static function getRelatedSlugs($slug, $id = 0)
    {
        return User::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
    public static function getPropertySlugs($slug, $id = 0)
    {
        return Property::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
