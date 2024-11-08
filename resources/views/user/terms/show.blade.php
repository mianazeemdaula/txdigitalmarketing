@extends('layouts.admin')

@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4">
        <!-- Header Section -->
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div>
                <h2 class="text-lg font-semibold">Terms</h2>
            </div>
        </div>
        <div class="my-2"></div>
        <div class="grid grid-cols-5 gap-4">
            <div class="bg-white p-4">
                <h2 class="text-lg font-semibold">Terms</h2>
                <div>
                    {{ implode(', ', $term->terms) }}
                </div>
            </div>
            <div class="bg-white p-4">
                <h2 class="text-lg font-semibold">Countries</h2>
                <div>
                    {{ implode(', ', $term->countries) }}
                </div>
            </div>
            <div class="bg-white p-4">
                <h2 class="text-lg font-semibold">Terms</h2>
                <div>
                    {{ implode(', ', $term->terms) }}
                </div>
            </div>
            <div class="bg-white p-4">
                <h2 class="text-lg font-semibold">Terms</h2>
                <div>
                    {{ implode(', ', $term->terms) }}
                </div>
            </div>
        </div>

        <div class="py-2 text-xs">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-1 text-left text-sm font-normal text-gray-700">
                            Ad
                        </th>
                        <th scope="col" class="px-6 py-1 text-left text-sm font-normal text-gray-700">
                            Page
                        </th>
                        <th scope="col" class="px-4 py-1 text-left text-sm font-normal text-gray-700">
                            Created On
                        </th>
                        <th scope="col" class="px-4 py-1 text-left text-sm font-normal text-gray-700">
                            Start
                        </th>
                        <th scope="col" class="px-4 py-1 text-left text-sm font-normal text-gray-700">
                            End
                        </th>
                        <th scope="col" class="px-4 py-1 text-left text-sm font-normal text-gray-700">
                            Links
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($term->fbAds()->paginate() as $item)
                        <tr>
                            <td class="whitespace-normal px-4 py-2">
                                <a href="{{ $item->ad_snapshot_url }}" target="_blank" class="text-green-500">
                                    {{ $item->ad_id }}
                                </a>
                            </td>
                            <td class="whitespace-normal px-6 py-2">
                                <a href="https://facebook.com/{{ $item->page_id }}" target="_blank">
                                    {{ $item->page_name }}
                                </a>
                            </td>
                            <td class="whitespace-normal px-4 py-2">
                                {{ $item->ad_creation_time }}
                            </td>
                            <td class="whitespace-normal px-4 py-2">
                                {{ $item->ad_delivery_start_time }}
                            </td>
                            <td class="whitespace-normal px-4 py-2">
                                {{ $item->ad_delivery_stop_time }}
                            </td>
                            <td class="whitespace-normal px-4 py-2">
                                {{ implode(', ', array_unique(array_filter($item->ad_creative_link_captions) ?? ['N/A']) ?? ['N/A']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-pagging :paginator="$term->fbAds()->paginate()" />
        </div>
    </section>
@endsection
