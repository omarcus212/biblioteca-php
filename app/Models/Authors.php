<?php

namespace App\Models;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'authors';

    protected $guarded = [];

    protected $fillabel = [
        'name',
        'image'
    ];


    public function getsearch($search, $show)
    {
        $res = Authors::where(
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
        return Authors::join('books_authors', 'authors.id', '=', 'books_authors.id_authors')
            ->join('books as b', 'b.id', '=', 'books_authors.id_books')
            ->select(
                'authors.id as id_author',
                'authors.name as author_name',
                'authors.image as author_image',
                DB::raw("GROUP_CONCAT(DISTINCT b.id) as book_ids"),
                DB::raw("GROUP_CONCAT(DISTINCT b.name) as book_names"),
                DB::raw("GROUP_CONCAT(DISTINCT b.ISBN) as book_ISBNs"),
                DB::raw("GROUP_CONCAT(DISTINCT b.price) as book_prices"),
                DB::raw("GROUP_CONCAT(DISTINCT b.Bibliography) as book_bibliographies"),
                DB::raw("GROUP_CONCAT(DISTINCT b.image) as book_images")
            )
            ->groupBy('authors.id', 'authors.name', 'authors.image')
            ->get();
    }

}
