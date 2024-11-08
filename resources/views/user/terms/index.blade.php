@extends('layouts.admin')
@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4">
        <!-- Header Section -->
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div>
                <h2 class="text-lg font-semibold">News</h2>
            </div>
            <div class="flex items-center space-x-2">
                <form action="{{ route('user.terms.store') }}" method="post">
                    @csrf
                    <input type="text" name="search" id="search"
                        class="border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        placeholder="Search" value="{{ request()->search }}" />
                    <button type="submit"
                        class="text-white bg-black px-5 py-2 rounded-lg hover:bg-gray-800">Search</button>
                </form>
                <a href="{{ route('user.terms.create') }}"
                    class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">
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
                                        Keyword
                                    </th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Country
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Start
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        End
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        FB Ads
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Updated
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($terms as $item)
                                    <tr>
                                        <td class="whitespace-normal px-4 py-2">
                                            {{ implode(', ', $item->terms) }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-2 text-sm text-gray-900">
                                            {{ implode(', ', $item->countries) }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                            {{ $item->start_date }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                            {{ $item->end_date }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                            {{ $item->fbAds->count() }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                            {{ $item->updated_at->diffForHumans() }}
                                        </td>
                                        <td class="px-4 py-2 text-right text-xs font-medium flex space-x-2">
                                            <a href="{{ route('user.terms.show', $item->id) }}" class="">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.terms.edit', $item->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('user.terms.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit">
                                                    <i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-pagging :paginator=$terms />
    </section>
@endsection
