@extends('layouts.bookstore.header')
@section('title', 'Authors')
@section('h1_Dashboard', 'authors')
@section('main')
<script src="{{ asset('js/bookstore/authors.js') }}" type="module" defer></script>

<main class="flex flex-col p-4">

    <section class="flex flex-col p-2">
        {{--Modal Email--}}
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
                            <button type="submit" id="sendEmail"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Send Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--Modal Delete--}}
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
            <div class="flex">
                <form action="/library/authors/put/{{$object->id}}" method="POST" id="form_home"
                    enctype="multipart/form-data" class="flex flex-col w-full justify-center items-center gap-6 mb-12">
                    @csrf
                    <div class="w-1/2 col-span-full justify-center ">
                        <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover photo</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                @if($object->image)
                                    <img src="/image/authors/{{ $object->image ?? '784568SemImagem.png'}}"
                                        class="w-full h-auto  mb-4" alt="Imagem da editora" />

                                @else
                                    <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <div class="mt-4 flex text-sm/6 text-gray-600">
                                    <label for="file-upload"
                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="image" accept="image/png, image/jpeg, image/jpg"
                                            type="file">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center itens-center w-full ">
                        <div class="w-1/2 sm:col-span-3">
                            <label for="first-name" class="block text-sm/6 font-medium text-gray-900">Nome</label>
                            <div class="mt-2">
                                <input type="text" name="name" placeholder="Nome..." id="name" value="{{$object->name}}"
                                    autocomplete="given-name"
                                    class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                            </div>
                        </div>
                    </div>

                    <div class="w-full mt-6 flex items-center justify-center gap-x-4">
                        <button type="submit" id="submitButton"
                            class="rounded-md w-[120px] bg-[#1D232A] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        <button type="button"
                            class="rounded-md w-[120px] bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            onclick="window.history.back()">Cancel</button>
                    </div>
            </div>
            </form>

        @endif


        @if (empty($object))
            <div class="flex">
                <form action="/library/authors" method="POST" id="form_home" enctype="multipart/form-data"
                    class="flex flex-col w-full justify-center items-center gap-6 mb-12">
                    @csrf
                    <div class="w-1/2 col-span-full justify-center ">
                        <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover photo</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                    aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd"
                                        d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm/6 text-gray-600">
                                    <label for="file-upload"
                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="image" accept="image/png, image/jpeg, image/jpg"
                                            type="file">
                                    </label>
                                </div>
                                <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center itens-center w-full ">
                        <div class="w-1/2 sm:col-span-3">
                            <label for="first-name" class="block text-sm/6 font-medium text-gray-900">Nome</label>
                            <div class="mt-2">
                                <input type="text" name="name" placeholder="Nome..." id="name" autocomplete="given-name"
                                    class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                            </div>
                        </div>
                    </div>

                    <div class="w-full mt-6 flex items-center justify-center gap-x-6">
                        <button type="submit" id="submitButton"
                            class="rounded-md w-1/2 bg-[#1D232A] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
            </div>
            </form>

        @endif



        <div class="p-4">
            <div class="m-4 mb-8 space-y-2">
                <hr class="border-2 border-[#1D232A]">
                <h2 class="text-2xl font-semibold text-black">Dtatable</h2>
            </div>

            <div>
                <div class="flex flex-row mb-12 text-white justify-between space-x-10">
                    <span class="flex w-1/2 pl-4 space-x-4 items-center">
                        <span class="flex space-x-4">
                            <label for="" class="text-[#1D232A]">Show</label>
                            <form action="/library/authors/search" method="get">
                                @csrf
                                <select name="show" class="text-[#1D232A]" onchange="this.form.submit();">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </form>
                            <label for="" class="text-[#1D232A]">entries </label>
                        </span>
                    </span>

                    <span class="flex w-1/2  pl-36">
                        <form id="FormSearch" action="/library/authors/search" method="GET"
                            class=" flex max-w-md mx-auto w-full justify-between space-x-6 ">
                            <span class="flex w-[60px]">
                                <input type="hidden" name="order" id="order" value="{{ $order }}">
                                <div type="button" id="orderButton"
                                    class="flex justify-center items-center rounded-md w-full bg-[#1D232A] hover:cursor-pointer px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    @if($order === 'desc')
                                        desc
                                    @else
                                        asc
                                    @endif
                                </div>
                            </span>

                            <span class="w-full">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="search" id="searchInput" name="search"
                                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-[#1D232A] focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Search Mockups, Logos..." />
                                    <button type="submit" id="searchForm"
                                        class="text-white bg-[#1D232A] absolute end-2.5 bottom-2.5  hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:focus:ring-blue-800">Search</button>
                                </div>
                            </span>
                        </form>
                    </span>

                </div>

                <div class="flex w-full justify-between">
                    <form id="actionForm" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="">
                        <input type="hidden" name="ids" id="selectedIds" value="">
                    </form>
                    <span class="felx flex-row w-full pl-6">
                        <button
                            class="hidden rounded-md bg-[#1D232A] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            id="updateButton" disabled>Update</button>
                        <button
                            class="hidden rounded-md bg-[#1D232A] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            id="deleteButton" disabled>Delete</button>
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

                <article class="w-full pl-6 pr-6 m-auto bg-gray-800 max-h-96 overflow-y-auto ">
                    <ul role="list" class="divide-y divide-gray-100 max-h-96 overflow-y-auto ">
                        @if ($res)
                                        @foreach ($res as $data)
                                            <li class="flex justify-between text-black gap-x-6 py-5">
                                                <div class="flex min-w-0 gap-x-4 pl-6">
                                                    <div class="flex justify-center items-center ">
                                                        <p class="flex text-sm/6 font-semibold text-white text-center">{{ $data->id}}</p>
                                                    </div>
                                                </div>
                                                <div class="flex gap-x-4 space-x-6 w-[60px]">
                                                    <img class="size-12 flex-none bg-gray-200 justify-center text-center items-center  "
                                                        src="/image/authors/{{ $data->image ?? '784568SemImagem.png' }}"
                                                        alt="{{ $data->name }}">
                                                </div>
                                                <div class="flex min-w-0 gap-x-4 space-x-6  w-[60px] justify-center ">
                                                    <div class="flex justify-center items-center ">
                                                        <p class="flex text-sm/6 font-semibold text-wrap text-white text-center">
                                                            {{ $data->name}}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="flex min-w-0 gap-x-4 justify-center items-center pr-6">
                                                    <div class="flex justify-center items-center">
                                                        <span class="flex">
                                                            <input type="checkbox" class="item-checkbox" id="selectAll"
                                                                value="{{$data->id}}" />
                                                        </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </article>
                                <div class="tw-flex bg-white mt-4 mb-4 tw-justify-content-center">
                                    {{ $res->links() }}
                                </div>
                            </div>
                        @else
                            <p class="text-white text-center text-2xl">No data found</p>
                        @endif
        </div>

        <div class="flex flex-col">
            <div class="m-4 mb-8 space-y-2">
                <h5 class="text-xl font-semibold text-black">Relação Livros</h5>
            </div>

            <article class="w-full pl-6 pr-6 m-auto bg-gray-800 max-h-96 overflow-y-auto ">
                <ul role="list" class="divide-y divide-gray-100 max-h-96 overflow-y-auto ">
                    @if ($relationship)
                        @foreach ($relationship as $books)
                            <li class="flex justify-between text-black gap-x-6 py-5">

                                <div class="flex min-w-0 gap-x-4 pl-6">
                                    <div class="flex justify-center items-center w-[60px]">
                                        <p class="flex text-sm/6 font-semibold text-white text-center">
                                            {{ $books->id_author}}
                                            {{ $books->author_name}}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex min-w-0 gap-x-4 space-x-6  w-[60px] justify-center ">
                                    <div class="flex justify-center items-center ">
                                        <p class="flex text-sm/6 font-semibold text-wrap text-white text-center">
                                            {{ $books->book_names}}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex min-w-0 gap-x-4 space-x-6  w-[60px] justify-center ">
                                    <div class="flex justify-center items-center ">
                                        <p class="flex text-sm/6 font-semibold text-wrap text-white text-center">
                                            {{ $books->book_ISBNs}}
                                        </p>
                                    </div>

                                </div>
                                <div class="flex min-w-0 gap-x-4 space-x-6  w-[60px] justify-center ">
                                    <div class="flex justify-center items-center ">
                                        <p class="flex text-sm/6 font-semibold text-wrap text-white text-center">
                                            {{ $books->book_prices}}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex min-w-0 gap-x-4 space-x-6  w-[60px] justify-center ">
                                    <div class="flex justify-center items-center ">
                                        <p class="flex text-sm/6 font-semibold text-wrap text-white text-center">
                                            {{ $books->book_bibliographies}}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-x-4 space-x-6 w-[60px]">
                                    <img class="size-12 flex-none bg-gray-200 justify-center text-center items-center  "
                                        src="/image/books/{{ $books->book_images ?? '784568SemImagem.png' }}"
                                        alt="{{ $books->book_names }}">
                                </div>
                            </li>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500">Nenhum resultado encontrado</p>
                    @endif
                </ul>
            </article>
        </div>

    </section>

</main>

@endsection