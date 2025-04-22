<?php

namespace App\Models;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Books_Authors extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'authors';



    public function DeleteBooks_Authros($ids)
    {
        try {
            DB::beginTransaction();
            if (is_array($ids) && count($ids) > 0) {
                $res = DB::table('books_authors')->whereIn('id_books', $ids)->delete();
                DB::commit();
                return $res;
            } else {
                throw new Exception('Invalid ids');
            }
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }

    }

    public function updateBook_Authors($idBooks, $authorsid)
    {
        try {
            DB::beginTransaction();

            $res = DB::table('books_authors')
                ->where('id_books', $idBooks)
                ->delete();

            if ($res) {
                $authors = $authorsid;  // IDs dos autores
                $data = [];

                foreach ($authors as $authorId) {
                    $data[] = [
                        'id_books' => $idBooks,
                        'id_authors' => $authorId
                    ];
                }

                $res = DB::table('books_authors')->insertOrIgnore($data);
                if ($res) {
                    DB::commit();
                    return true;
                }
            } else {
                throw new Exception('Error ');
            }


        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
