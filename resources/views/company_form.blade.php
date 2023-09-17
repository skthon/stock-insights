<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
</head>
<body>
<div class="h-screen flex flex-col items-center justify-center">
    <form action="/company/history" method="POST" class="shadow-lg p-8 max-w-96">
        <div class="space-y-6">
            <h1 class="content-center text-2xl">Fill the company information</h1>
            @if($errors->has('message')){{ $errors->first('message') }}@endif
            @csrf
            <div>
                <label for="symbol" class="block text-gray-700">Company Symbol</label>
                <input required type="text" name="symbol" placeholder="" value="{{ old('symbol') }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 @if($errors->has('symbol'))border-red-500 @endif">
                @if($errors->has('symbol'))<span class="text-red-500">{{ $errors->first('symbol') }}</span>@endif
            </div>
            <div>
                <label for="email" class="block text-gray-700">Email Address</label>
                <input required type="email" name="email" placeholder="" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 @if($errors->has('email'))border-red-500 @endif">
                @if($errors->has('email'))<span class="text-red-500">{{ $errors->first('email') }}</span>@endif
            </div>
            <div date-rangepicker class="flex items-center space-b-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input required name="start_date" value="{{old('start_date')}}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                </div>
                <span class="mx-4 text-gray-500">to</span>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input required name="end_date" value="{{old('end_date')}}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                </div>
            </div>
            <div class="flex flex-col justify-center items-center">
                <div class="flex">
                @if($errors->has('end_date'))<span class="text-red-500">{{ $errors->first('end_date') }}</span>@endif
                </div>
                <div class="flex">
                @if($errors->has('start_date'))<span class="text-red-500">{{ $errors->first('start_date') }}</span>@endif
                </div>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white font-semibold px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Submit</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>


