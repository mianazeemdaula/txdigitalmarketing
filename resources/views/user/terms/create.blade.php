@extends('layouts.admin')

@section('content')
    <div class="mx-auto ">
        <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
            <form action="{{ route('user.terms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                    <div class="flex flex-col gap-2">
                        <x-label>Term</x-label>
                        <x-input name="term" value="{{ old('term') }}" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>Country</x-label>
                        <x-select name="country">
                            <option value="US">United States</option>
                            <option value="PK">Pakistan</option>
                            <option value="GB">United Kingdom</option>
                            <option value="AU">Australia</option>
                        </x-select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>Start Date</x-label>
                        <x-input type="date" name="start_date" value="{{ old('start_date') }}"
                            value="{{ now()->subDays(10)->format('Y-m-d') }}" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>End Date</x-label>
                        <x-input type="date" name="end_date" value="{{ old('end_date') }}"
                            value="{{ now()->subDays(1)->format('Y-m-d') }}" />
                    </div>
                </div>
                <div class="flex py-6 space-x-4">
                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer">Gether
                        Information</button>

                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('head')
    <script src="https://cdn.tiny.cloud/1/kput55tw7sf7m8nadh5lth5ghsdshrjgwfbj9ju8hcdigf4a/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
@endsection
