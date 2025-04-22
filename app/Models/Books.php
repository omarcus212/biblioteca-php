<?php

namespace App\Models;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    protected $guarded = [];

    protected $fillabel = [
        'name',
        'image',
        'ISBN',
        'price',
        'bibliography',
        'id_publisher',
    ];




    public function getBooksModel($order, $show)
    {
        try {
            $books = DB::table('books as b')
                ->join('publisher as p', 'b.id_publisher', '=', 'p.id')
                ->join('books_authors as ab', 'b.id', '=', 'ab.id_books')
                ->join('authors as au', 'au.id', '=', 'ab.id_authors')
                ->select(
                    'b.id',
                    'b.name',
                    'b.ISBN',
                    'b.price',
                    'b.image',
                    'b.Bibliography',
                    'b.id_publisher',
                    'p.name as publisher_name',
                    DB::raw('GROUP_CONCAT(au.name SEPARATOR ", ") as authors')
                )
                ->groupBy('b.id')
                ->orderBy('id', $order)
                ->paginate($show);

            return $books;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }


    public function CreateBookModel($request)
    {

        $price = $request->price; // Exemplo de preço com vírgula
        $price = str_replace(',', '.', $price); // Troca a vírgula por ponto
        $price = floatval($price);

        try {
            $model = new Books();
            $model->name = $request->name;
            $model->ISBN = $request->ISBN;
            $model->price = $price;
            $model->bibliography = $request->bibliography;
            $model->id_publisher = $request->publisher;
            $model->image = $request->image;
            $res = $model->save();

            if ($res) {

                $lastbook = Books::latest()->first();
                $idlast = $lastbook->id;

                foreach ($request->authors as $authorId) {
                    try {
                        $res = DB::table('books_authors')->insert([
                            'id_books' => $idlast,
                            'id_authors' => $authorId,
                        ]);
                    } catch (Exception $ex) {
                        return $ex->getMessage();
                    }

                }

                return $res;

            } else {

                $res = false;
            }
            return $res;

        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    public function UpdateBookModel($idBooks, $request)
    {

        $price = $request->price;
        $price = str_replace(',', '.', $price);
        $price = floatval($price);

        try {
            DB::beginTransaction();

            DB::table('books')
                ->where('id', $idBooks)
                ->update([
                    'name' => $request->name,
                    'ISBN' => $request->ISBN,
                    'price' => $price,
                    'image' => $request->image,
                    'Bibliography' => $request->bibliography,
                    'id_publisher' => $request->publisher
                ]);


            $booksAuthors = new Books_Authors();
            $res = $booksAuthors->updateBook_Authors($idBooks, $request->authors);
            if ($res) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }

        } catch (Exception $e) {

            DB::rollBack();
            return false;
        }


    }

    public function DeletBookModel($ids)
    {


        try {
            DB::beginTransaction();

            $booksAuthors = new Books_Authors();
            $res = $booksAuthors->DeleteBooks_Authros($ids);

            if ($res) {
                foreach ($ids as $id) {
                    $model = Model::find($id);
                    if ($model) {
                        DB::table('books')->where('id', '=', $id)->update(['id_publisher' => null]);
                        $model->delete();
                    }
                }
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }

        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function getsearch($search, $order, $show)
    {
        $res = DB::table('books as b')
            ->join('publisher as p', 'b.id_publisher', '=', 'p.id')
            ->join('books_authors as ab', 'b.id', '=', 'ab.id_books')
            ->join('authors as au', 'au.id', '=', 'ab.id_authors')
            ->select(
                'b.id',
                'b.name',
                'b.ISBN',
                'b.price',
                'b.image',
                'b.Bibliography',
                'b.id_publisher',
                'p.name as publisher_name',
                DB::raw('GROUP_CONCAT(au.name SEPARATOR ", ") as authors')
            )
            ->where('b.name', 'LIKE', '%' . $search . '%')
            ->orderBy('id', $order)
            ->groupBy('b.id', 'p.name')
            ->paginate($show);

        return $res;
    }


}
