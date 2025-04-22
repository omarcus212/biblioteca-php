<?php

namespace App\Http\Controllers;

use App\Exports\PublisherExport;
use App\Models\Publisher;
use Auth;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Mail;

class PublisherController extends Controller
{
    public function index(Request $request)
    {

        $res = Auth::check();
        if ($res) {
            $publisher = new Publisher();
            $show = $request->input('show', 10);
            $order = $request->input('order', 'desc');
            $res = Publisher::orderBy('id', $order)->paginate($show);
            $relationship = $publisher->relationshipBooks();

            if (count($res) == 0) {
                $res = null;
            }
            return view('bookstore.publisher', compact('res', 'order', 'relationship'))->render();
        }

    }
    public function Data(Request $request)
    {

        $id = json_decode($request->input('ids'));
        // Salva os dados na sessão
        $request->session()->put('id', $id);
        return redirect('/library/publisher/edit/');
    }

    public function getID(Request $request)
    {

        $res = Auth::check();
        if ($res) {
            $id = session('id');
            if (is_array($id)) {
                $object = Publisher::findOrFail($id[0]);
            } else {
                $object = Publisher::findOrFail($id);
            }
            $res = Publisher::paginate();
            $show = $request->input('show', 10);
            $order = $request->input('order', 'desc');
            $publisher = new Publisher();
            $relationship = $publisher->relationshipBooks();
            return view('bookstore.publisher', compact('object', 'res', 'order', 'relationship'))->render();
        }

    }

    public function CreatePublisher(Request $request)
    {

        $res = Auth::check();
        if ($res) {

            if ($request->name) {

                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $request->image->move(public_path('image/publisher'), $imageName);
                    $request->image = $imageName;
                }

                $model = new Publisher();
                $model->name = $request->name;
                $model->image = $request->image;
                $res = $model->save();
                if ($res) {

                    $res = redirect('/library/publisher')->with('success', 'Registro criado com sucesso');

                } else {
                    $res = redirect('/library/publisher')->with('error', 'Ops! algo deu errado ao criar esse registro, tente de novo!');
                }

            } else {

                $res = redirect()->back()->with('error', 'Campos obrigatórios não forem preenchidos.');
            }

            return $res;

        } else {

            return redirect('/');
        }

    }

    public function UpdatePublisher(Request $request)
    {

        $res = Auth::check();
        if ($res) {

            if ($request->name) {

                $model = Publisher::findOrFail($request->id);

                // Verifica se uma nova imagem foi enviada
                if ($request->hasFile('image') && $request->file('image')->isValid()) {

                    if ($model->image) {
                        Storage::delete($model->image);
                    }

                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $request->image->move(public_path('image/publisher'), $imageName);
                    $request->image = $imageName;

                    $model->name = $request->name;
                    $model->image = $request->image;
                    $model->save();
                    $res = redirect('/library/publisher')->with('success', 'Registro atualizado com sucesso');
                } else {
                    try {
                        $model->name = $request->name;
                        $model->save();
                        $res = redirect('/library/publisher')->with('success', 'Registro atualizado com sucesso');

                    } catch (Exception $ex) {

                        $res = redirect()->back()->with('error', 'Ops! algo deu errado ao criar esse registro, tente de novo!');
                    }

                }

            } else {

                $res = redirect('/library/publisher')->with('error', 'Campos obrigatórios não forem preenchidos.');
            }

            return $res;

        } else {

            return redirect('/');
        }

    }

    public function DeletePublisher(Request $request)
    {

        try {
            $ids = json_decode($request->input('ids'));
            if (is_array($ids) && count($ids) > 0) {
                $res = Publisher::whereIn('id', $ids)->delete();
                if ($res) {
                    return redirect('/library/publisher')->with('success', 'Registro deletado com sucesso');
                } else {
                    return redirect('/library/publisher')->with('error', 'Erro ao deletar registro');
                }
            }
        } catch (\Exception $ex) {

            return redirect()->back()->with('error', 'Esse id está vinculado com livros.');
        }


    }

    public function SearchPublisher(Request $request)
    {
        $search = request('search', '');
        $show = $request->input('show', 10);
        $order = $request->input('order', 'desc');
        $publisher = new Publisher();
        $relationship = $publisher->relationshipBooks();
        $model = new Publisher();


        if ($search) {

            $res = $model->getsearch($search, $show);
            return view('bookstore.publisher', ['res' => $res, 'order' => $order, 'search' => $search, 'relationship' => $relationship]);

        } else {
            $res = Publisher::paginate($show);
            return view('bookstore.publisher', ['res' => $res, 'order' => $order, 'search' => $search, 'relationship' => $relationship]);
        }


    }
    public function export()
    {
        return Excel::download(new PublisherExport, 'Publisher.xlsx');
    }

    public function sendExportByEmail(Request $request)
    {
        $email = $request['email'];
        $messageEmail = $request['message'];
        $excelFile = Excel::raw(new PublisherExport, \Maatwebsite\Excel\Excel::XLSX);

        Mail::raw($messageEmail ?? "Em anexo está o arquivo Excel com os dados da tabela Publisher. Revise e informe-nos se precisar de mais ajuda. ", function ($message) use ($email, $excelFile) {
            $message->subject('Excel File Publisher!');
            $message->from('info@inovcorp.com');
            $message->to($email);
            $message->attachData($excelFile, 'Publisher.xlsx', [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        });
        return redirect()->back()->with('success', 'Email sent successfully');

    }

}
