<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Models\Authors;
use App\Models\Books;
use App\Models\Publisher;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Storage;
use Maatwebsite\Excel\Facades\Excel;

class BooksController extends Controller
{
    public function index(Request $request)
    {

        $res = Auth::check();
        if ($res) {
            $show = $request->input('show', 10);
            $order = $request->input('order', 'desc');
            $books = new Books();
            $res = $books->getBooksModel($order, $show);
            $authors = Authors::all();
            $publishers = Publisher::all();
            $publisherRela = new Publisher();
            $relationship = $publisherRela->relationshipBooks();
            $authorsRela = new Authors();
            $relationshipAuthors = $authorsRela->relationshipBooks();

            if (count($res) == 0) {
                $res = null;
            }

            return view('bookstore.bookstore', ['res' => $res, 'authors' => $authors, 'publishers' => $publishers, 'relationshipAuthors' => $relationshipAuthors, 'relationship' => $relationship, 'order' => $order, 'show' => $show])->render();


        }
    }

    public function Data(Request $request)
    {

        $id = json_decode($request->input('ids'));
        // Salva os dados na sessão
        $request->session()->put('id', $id);
        return redirect('/library/bookstore/edit/');
    }


    public function getID(Request $request)
    {

        $res = Auth::check();
        if ($res) {
            $model = new Books();
            $show = $request->input('show', 10);
            $order = $request->input('order', 'desc');
            $id = session('id');
            $res = $model->getBooksModel($order, $show);
            if (is_array($id)) {
                $object = Publisher::findOrFail($id[0]);
            } else {
                $object = Publisher::findOrFail($id);
            }
            $authors = Authors::all();
            $publishers = Publisher::all();
            $publisherRela = new Publisher();
            $relationship = $publisherRela->relationshipBooks();
            $authorsRela = new Authors();
            $relationshipAuthors = $authorsRela->relationshipBooks();

            return view('bookstore.bookstore', ['res' => $res, 'object' => $object, 'authors' => $authors, 'publishers' => $publishers, 'relationship' => $relationship, 'relationshipAuthors' => $relationshipAuthors, 'order' => $order, 'show' => $show])->render();

        }

    }

    public function CreateBooks(Request $request)
    {

        $res = Auth::check();

        if ($res) {
            if (
                $request->name && $request->ISBN && $request->price && $request->publisher &&
                $request->authors
            ) {
                if (strlen($request->ISBN) === 13) {
                    if ($request->hasFile('image') && $request->file('image')->isValid()) {
                        $image = $request->file('image');
                        $imageName = time() . '.' . $image->getClientOriginalExtension();
                        $request->image->move(public_path('image/books'), $imageName);
                        $request->image = $imageName;
                    }

                    $model = new Books();
                    $res = $model->CreateBookModel($request);

                    if ($res) {

                        $res = redirect()->back()->with('success', 'Registro criado com sucesso');

                    } else {
                        $res = redirect()->back()->with('error', 'Ops! algo deu errado ao criar esse registro, tente de novo!');
                    }
                } else {
                    $res = redirect()->back()->with('error', 'ISBN incorreto!.');
                }
            } else {

                $res = redirect()->back()->with('error', 'Campos obrigatórios não forem preenchidos.');
            }

            return $res;

        } else {

            return redirect('/');
        }

    }

    public function UpdateBooks(Request $request)
    {

        $res = Auth::check();

        if ($res) {


            if (
                $request->name && $request->ISBN && $request->price && $request->publisher &&
                $request->authors
            ) {
                if (strlen($request->ISBN) === 13) {

                    $model = Books::findOrFail($request->id);

                    if ($request->hasFile('image') && $request->file('image')->isValid()) {

                        if ($model->image) {
                            Storage::delete($model->image);
                        }

                        $image = $request->file('image');
                        $imageName = time() . '.' . $image->getClientOriginalExtension();
                        $request->image->move(public_path('image/books'), $imageName);
                        $request->image = $imageName;

                        $model = new Books();
                        $id = intval($request->id);
                        $res = $model->UpdateBookModel($id, $request);

                    }

                    $model = new Books();
                    $id = intval($request->id);
                    $res = $model->UpdateBookModel($id, $request);

                    if ($res == true) {

                        $res = redirect('/library/bookstore')->with('success', 'Registro atualizado com sucesso');

                    } else {

                        $res = redirect('/library/bookstore')->with('error', 'Ops! algo deu errado ao criar esse registro, tente de novo!');
                    }

                } else {

                    $res = redirect()->back()->with('error', 'ISBN incorreto!.');
                }

            } else {

                $res = redirect()->back()->with('error', 'Campos obrigatórios não forem preenchidos.');
            }

            return $res;

        } else {

            return redirect('/');
        }

    }

    public function Deletebookstore(Request $request)
    {

        try {

            $model = new Books();
            $ids = json_decode($request->input('ids'));
            $res = $model->DeletBookModel($ids);

            if ($res) {
                return redirect('/library/bookstore')->with('success', 'Registro deletado com sucesso');
            } else {
                return redirect('/library/bookstore')->with('error', 'Ops! algo deu errado');
            }
        } catch (\Exception $ex) {

            return redirect()->back()->with('error', 'Esse livro está vinculado com id editora.');
        }

    }


    public function SearchBooks(Request $request)
    {
        $search = $_GET['search'] ?? '';
        $order = $_GET['order'] ?? 'desc';

        if ($search || $order) {
            $model = new Books();
            $show = $request->input('show', 10);
            $res = $model->getsearch($search, $order, $show);
            $authors = Authors::all();
            $publishers = Publisher::all();
            $publisherRela = new Publisher();
            $relationship = $publisherRela->relationshipBooks();
            $authorsRela = new Authors();
            $relationshipAuthors = $authorsRela->relationshipBooks();

            return view('bookstore.bookstore', ['res' => $res, 'authors' => $authors, 'publishers' => $publishers, 'relationship' => $relationship, 'relationshipAuthors' => $relationshipAuthors, 'order' => $order, 'show' => $show]);

        } else {
            $model = new Books();
            $show = $request->input('show', 10);
            $res = $model->getsearch($search, $order, $show);
            $authors = Authors::all();
            $publishers = Publisher::all();
            $publisherRela = new Publisher();
            $relationship = $publisherRela->relationshipBooks();
            $authorsRela = new Authors();
            $relationshipAuthors = $authorsRela->relationshipBooks();

            return view('bookstore.bookstore', ['res' => $res, 'authors' => $authors, 'publishers' => $publishers, 'relationship' => $relationship, 'relationshipAuthors' => $relationshipAuthors, 'order' => $order, 'show' => $show]);
        }





    }

    public function export()
    {
        return Excel::download(new BooksExport, 'Books.xlsx');
    }

    public function sendExportByEmail(Request $request)
    {
        $email = $request['email'];
        $messageEmail = $request['message'];
        $excelFile = Excel::raw(new BooksExport, \Maatwebsite\Excel\Excel::XLSX);

        Mail::raw($messageEmail ?? "Em anexo está o arquivo Excel com os dados da tabela Books. Revise e informe-nos se precisar de mais ajuda. ", function ($message) use ($email, $excelFile) {
            $message->subject('Excel File Books!');
            $message->from('info@inovcorp.com');
            $message->to($email);
            $message->attachData($excelFile, 'Books.xlsx', [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        });
        return redirect()->back()->with('success', 'Email sent successfully');

    }


}
