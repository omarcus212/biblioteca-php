<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'publisher';

    protected $guarded = [];
    protected $fillabel = [
        'name',
        'image'
    ];


    public function getsearch($search, $show)
    {
        $res = Publisher::where(
            'name',
            'like',
            '%' . $search . '%'
        )->orWhere('name', 'like', '%' . $search . '%')->paginate($show);
        if (count($res) === 0) {
            $res = null;
        }
        return $res;
    }


    public function relationshipBooks()
    {
        return Publisher::join('books', 'books.id_publisher', '=', 'publisher.id')
            ->select('books.id as id_books', 'publisher.image as image_p', 'publisher.id as id_p', 'publisher.name as name_p', 'books.name', 'books.ISBN', 'books.price', 'books.Bibliography', 'books.image')
            ->groupBy('books.id')
            ->get();
    }
}
