@extends('layouts.admin')
@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4">
        <!-- Header Section -->
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div>
                <h2 class="text-lg font-semibold">News</h2>
            </div>
            <div class="flex items-center space-x-2">
                <form action="" method="post">
                    @csrf
                    <input type="text" name="search" id="search"
                        class="border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        placeholder="Search" value="{{ request()->search }}" />
                    <button type="submit"
                        class="text-white bg-black px-5 py-2 rounded-lg hover:bg-gray-800">Search</button>
                </form>
                <a href="" class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">
                    <i class="fa fa-add"></i> Create
                </a>
            </div>
        </div>

        <!-- Table Section for Desktop -->
        <div class="mt-6 hidden md:block">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        <span>ID</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Name
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Audience
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($rows as $item)
                                    <tr>
                                        <td class="whitespace-normal px-4 py-2 text-sm text-gray-900">
                                            {{ $item['id'] }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-2 text-sm text-gray-900">
                                            {{ $item['name'] }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-2 text-sm text-gray-900">
                                            {{ $item['audience_size'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <x-pagging :paginator=$rows /> --}}
    </section>
@endsection
