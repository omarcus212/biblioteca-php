@extends('layouts.bookstore.getdaisyui')

<body class="bg-white">
    <header>
        <div class="navbar bg-[#9D9D9D]">
            <div class="flex-1">
                <ul>
                    <li><a href="{{'/dashboard'}}" class="text-black text-base font-bold">Dashboard</a></li>
                </ul>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1 font-sans text-lg font-semibold">
                    <li><a href="{{'/library/publisher'}}" class="text-black text-base">Editoras</a></li>
                    <li><a href="{{'/library/authors'}}" class="text-black text-base">Autores</a></li>
                    <li><a href="{{'/library/bookstore'}}" class="text-black text-base">Livros</a></li>
                    <li><a href="{{'/library/logout'}}" class="text-black text-base">Logout</a></li>
                    </li>
                </ul>
            </div>
        </div>

    </header>

    <main class="p-4">
        <!-- Modal -->
        <div id="modal" tabindex="-1" aria-hidden="true"
            class="flex bg-[#1D232A] opacity-95 hidden w-full h-full opacity-1 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-50 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Send Excel to email
                        </h3>
                        <button type="button" id="closeModalBtn"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="/library/authors/send-export" method="post">
                            @csrf
                            <div space-y-2>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Email to</label>
                                <input type="email" name="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="name@company.com" required />
                                <label for="message"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    message</label>
                                <textarea id="message" name="message" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write your thoughts here..."></textarea>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Send Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal DELETE-->
        <div id="modalDelete" tabindex="-1" aria-hidden="true"
            class="flex  hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full bg-[#1D232A]">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div
                        class="flex bg-[#1D232A] items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Alert
                        </h3>
                        <button type="button" id="closeModalDelete"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4 bg-[#1D232A]">
                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                            Tem certeza de que deseja excluir este item? Essa ação é irreversível e os dados serão
                            permanentemente removidos.
                        </p>
                    </div>
                    <div
                        class="flex bg-[#1D232A] items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="default-modal" type="button" id="confirme" value="confirme"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Confirmar</button>
                        <button data-modal-hide="default-modal" id="cancelBtn" type="button" value="cancel"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-[#1D232A] rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <span class="container_msg" {{ session('') ? 'hidden' : '' }}>
            @if (session('success'))
                <p class="p-4 mb-4 font-medium text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                    role="alert">{{ session('success') }}</p>
            @endif
            @if (session('error'))
                <p class="p-4 mb-4 font-medium text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">{{ session('error') }}</p>
            @endif
        </span>

        @if (isset($object) || !empty($object))
            <section class="flex-col mb-10 mt-10">
                <form action="/library/authors/put/{{$object->id}}" method="POST" id="form_home"
                    enctype="multipart/form-data" class="w-full max-w-lg mx-auto flex flex-col gap-6 p-4">
                    @csrf

                    <span class="flex-col w-full">
                        <img src="/image/authors/{{ $object->image ?? '784568SemImagem.png'}}" class="w-full h-auto  mb-4"
                            alt="Imagem da editora" />
                        <input type="file" name="image" accept="image/png, image/jpeg, image/jpg"
                            class="file-input file-input-bordered w-full" />
                    </span>

                    <span class="flex-col w-full">
                        <input type="text" name="name" required value="{{$object->name}}" placeholder="Nome..."
                            class="input input-bordered w-full" />
                    </span>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-neutral w-full" id="submitButton">Atualizar</button>
                    </div>
                </form>
            </section>
        @endif

        @if (empty($object))
            <section class="flex-col mb-10 mt-10">
                <form action="/library/authors" method="POST" id="form_home" enctype="multipart/form-data"
                    class="w-full max-w-lg mx-auto flex flex-col gap-6 p-4">
                    @csrf

                    <span class="flex-col w-full">
                        <img src="/image/784568SemImagem.png" class="w-full h-auto mb-4" alt="Imagem de exemplo" />
                        <input type="file" name="image" accept="image/png, image/jpeg, image/jpg"
                            class="file-input file-input-bordered w-full" />
                    </span>

                    <span class="flex-col w-full">
                        <input type="text" name="name" required placeholder="Nome..." class="input input-bordered w-full" />
                    </span>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-neutral w-full" id="submitButton">Enviar</button>
                    </div>
                </form>
            </section>
        @endif

        <div class="m-4 mb-8 space-y-2">
            <hr class="border-2">
            <h2 class="text-2xl font-semibold text-black">Dtatable</h2>
        </div>

        <div>
            <div class="flex flex-row mb-6 pl-4 pr-4 text-white justify-center space-x-10">
                <span class="flex w-1/2 pl-4 space-x-4 items-center">

                    <label for="" class="text-[#1D232A]">Show</label>
                    <form action="/library/authors" method="get">
                        @csrf
                        <select name="show" onchange="this.form.submit();">
                            <option value="10" selected>10</option>
                            <option value="200">20</option>
                            <option value="3">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </form>
                    <label for="" class="text-[#1D232A]">entries</label>

                </span>
                <span class="flex w-1/2">
                    <form action="/library/authors/search" id="orderForm" method="GET"
                        class="flex w-full justify-end space-x-4">
                        <label class="input input-bordered flex items-center gap-2">
                            <input type="text" class="grow" name="search" placeholder="Search" />
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="h-4 w-4 opacity-70">
                                <path fill-rule="evenodd"
                                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </label>
                    </form>
                </span>
            </div>

            @if ($res)
                <div class="flex w-full justify-between">
                    <form id="actionForm" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="">
                        <input type="hidden" name="ids" id="selectedIds" value="">
                    </form>
                    <span class="felx w-full pl-6">
                        <button class="btn btn-neutral" id="updateButton" disabled>Update</button>
                        <button class="btn btn-neutral" id="deleteButton" disabled>Delete</button>
                    </span>
                    <span class="flex w-full pl-6 justify-end items-center">

                        <button data-modal-target="#modal" data-modal-toggle="modal" id="openModalBtn"
                            class="text-white bg-[#1D232A] hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                            Export Email
                        </button>

                        <form action="/library/authors/export" method="get">
                            @csrf
                            <button type="submit"
                                class="text-white bg-[#1D232A] hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                Export Excel
                            </button>
                        </form>

                    </span>
                </div>
                <div class="max-h-96 overflow-y-auto border border-gray-300 rounded-lg p-4">
                    <table class="min-w-full text-black">
                        <thead class="border-b-2 bg-[#1D232A] text-white">
                            <tr>
                                <th class="px-2 py-2">
                                    <label class="flex flex-col space-y-2">
                                        <h3>Action</h3>
                                        <span class="flex w-full justify-center">
                                            <input type="checkbox" id="selectAll" />
                                        </span>
                                    </label>
                                </th>
                                <th class="px-2 py-2" colspan="2">
                                    <span class="flex w-full justify-center space-x-4">
                                        <h2>ID</h2>
                                        <form action="/library/authors/search" id="orderForm" method="GET"
                                            style="display:inline;">
                                            <input type="hidden" name="order"
                                                value="{{ $order === 'desc' ? 'asc' : 'desc' }}">
                                            <button type="submit" value="desc">@if($order === 'desc')
                                                &#8595;
                                            @else
                                                &#8593;
                                            @endif
                                            </button>
                                        </form>
                                    </span>

                                </th>
                                <th class="px-4 py-2" colspan="2">Nome</th>
                                <th class="px-4 py-2" colspan="2">Imagem</th>
                            </tr>
                        </thead>
                        <tbody class="border-b-2">
                            @foreach ($res as $data)

                                <tr class="border-b-2 border-gray-500 font-bold text-center hover:bg-gray-700">
                                    <th class=" px-4 py-2">
                                        <label>
                                            <input type="checkbox" class="item-checkbox" value="{{$data->id}}" />
                                        </label>
                                    </th>
                                    <td class="px-4 py-2" colspan="2">{{ $data->id }}</td>
                                    <td class="px-4 py-2" colspan="2">{{ $data->name }}</td>
                                    <td class="px-4 py-2" colspan="2">
                                        <span class="flex w-full justify-center">
                                            <img src="/image/authors/{{ $data->image ?? '784568SemImagem.png' }}"
                                                class="w-20 h-20 object-cover text-center" alt="{{ $data->name }}" />
                                        </span>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tw-flex bg-white mt-4 mb-4 tw-justify-content-center">
                    {{ $res->links() }}
                </div>
            @elseif (empty($res))
                <table class="min-w-full text-black">
                    <thead class="border-b-2 bg-[#1D232A] text-white">
                        <thead class="border-b-2 bg-[#1D232A] text-white">
                            <tr>
                                <th class="px-4 py-2">Não há registros!</th>
                            </tr>
                        </thead>
                    </thead>
                </table>
            @endif
        </div>

    </main>
    <script src="{{ asset('js/bookstore/authors.js') }}" type="module" defer></script>

</body>