<?php

namespace App\Http\Controllers;

use App\Exports\AuthorsExport;
use App\Models\Authors;
use Auth;
use Illuminate\Http\Request;
use Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

class AuthorsController extends Controller
{
    public function index(Request $request)
    {

        $res = Auth::check();
        if ($res) {
            $show = $request->input('show', 10);
            $order = $request->input('order', 'desc');
            $res = Authors::orderBy('id', $order)->paginate($show);
            $authors = new Authors();
            $relationship = $authors->relationshipBooks();

            if (count($res) == 0) {
                $res = null;
            }
            return view('bookstore.authors', compact('res', 'order', 'relationship'))->render();
        }

    }

    public function Data(Request $request)
    {

        $id = json_decode($request->input('ids'));
        // Salva os dados na sessão
        $request->session()->put('id', $id);
        return redirect('/library/authors/edit/');
    }
    public function getID(Request $request)
    {

        $res = Auth::check();
        if ($res) {
            $id = session('id');
            $res = Authors::paginate();
            $object = Authors::findOrFail($id[0]);
            $show = $request->input('show', 10);
            $order = $request->input('order', 'desc');
            $authors = new Authors();
            $relationship = $authors->relationshipBooks();
            return view('bookstore.authors', compact('object', 'res', 'order', 'relationship'))->render();
        }

    }

    public function CreateAuthors(Request $request)
    {

        $res = Auth::check();
        if ($res) {

            if ($request->name) {

                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $request->image->move(public_path('image/authors'), $imageName);
                    $request->image = $imageName;
                }

                $model = new Authors();
                $model->name = $request->name;
                $model->image = $request->image;
                $res = $model->save();
                if ($res) {

                    $res = redirect('/library/authors')->with('success', 'Registro criado com sucesso');

                } else {
                    $res = redirect()->back()->with('error', 'Ops! algo deu errado ao criar esse registro, tente de novo!');
                }

            } else {

                $res = redirect()->back()->with('error', 'Campos obrigatórios não forem preenchidos.');
            }

            return $res;

        } else {

            return redirect('/');
        }

    }

    public function UpdateAuthors(Request $request)
    {

        $imageName = '';
        $res = Auth::check();
        if ($res) {

            if ($request->name) {

                $model = Authors::findOrFail($request->id);

                if ($request->hasFile('image') && $request->file('image')->isValid()) {

                    if ($model->image) {
                        Storage::delete($model->image);
                    }

                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $request->image->move(public_path('image/authors'), $imageName);
                    $request->image = $imageName;

                    $model->name = $request->name;
                    $model->image = $request->image;
                    $res = $model->save();

                } else {
                    $model->name = $request->name;
                    $res = $model->save();
                }

                if ($res) {

                    $res = redirect('/library/authors')->with('success', 'Registro atualizado com sucesso');

                } else {
                    $res = redirect()->back()->with('error', 'Ops! algo deu errado ao criar esse registro, tente de novo!');
                }

            } else {

                $res = redirect()->back()->with('error', 'Campos obrigatórios não forem preenchidos.');
            }

            return $res;

        } else {

            return redirect('/');
        }

    }

    public function DeleteAuthors(Request $request)
    {


        try {
            $ids = json_decode($request->input('ids'));
            if (is_array($ids) && count($ids) > 0) {
                $res = Authors::whereIn('id', $ids)->delete();
                if ($res) {
                    return redirect('/library/authors')->with('success', 'Registro deletado com sucesso');
                } else {
                    return redirect('/library/publisher')->with('error', 'Erro ao deletar registro');
                }
            }
        } catch (\Exception $ex) {

            return redirect()->back()->with('error', 'Esse id está vinculado com livros.');
        }


    }


    public function SearchAuthors(Request $request)
    {
        $search = request('search');
        $model = new Authors();
        $show = $request->input('show', 10);
        $order = $request->input('order', 'desc');
        $authors = new Authors();
        $relationship = $authors->relationshipBooks();

        if ($search) {

            $res = $model->getsearch($search, $show);
            return view('bookstore.authors', ['res' => $res, 'order' => $order, 'search' => $search, 'relationship' => $relationship]);

        } else {
            $res = Authors::paginate($show);
            return view('bookstore.authors', ['res' => $res, 'order' => $order, 'search' => $search, 'relationship' => $relationship]);
        }

    }

    public function export()
    {
        return Excel::download(new AuthorsExport, 'Authors.xlsx');
    }

    public function sendExportByEmail(Request $request)
    {
        $email = $request['email'];
        $messageEmail = $request['message'];
        $excelFile = Excel::raw(new AuthorsExport, \Maatwebsite\Excel\Excel::XLSX);

        Mail::raw($messageEmail ?? "Em anexo está o arquivo Excel com os dados da tabela Publisher. Revise e informe-nos se precisar de mais ajuda. ", function ($message) use ($email, $excelFile) {
            $message->subject('Excel File Authors!');
            $message->from('info@inovcorp.com');
            $message->to($email);
            $message->attachData($excelFile, 'Authors.xlsx', [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        });

        return redirect()->back()->with('success', 'Email sent successfully');
    }



}
