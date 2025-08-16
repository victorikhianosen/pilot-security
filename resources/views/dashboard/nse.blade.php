@extends('layouts.admin.app')

@section('admin_content')
    <main class="flex-grow p-6">

        <!-- Page Title Start -->
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">NSE Trends</h4>

            <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">

                <div>
                    <button class="btn bg-primary text-white" data-fc-target="default-modal" data-fc-type="modal"
                        type="button">
                        Upload Pricing
                    </button>
                </div>


            </div>
        </div>

        <div class="mt-12 overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white whitespace-nowrap">
                    <tr>
                        <th class="p-4 text-left text-sm font-medium">Company</th>

                        <th class="p-4 text-left text-sm font-medium">Company</th>
                        <th class="p-4 text-left text-sm font-medium">Previous Close</th>
                        <th class="p-4 text-left text-sm font-medium">Open</th>
                        <th class="p-4 text-left text-sm font-medium">High</th>
                        <th class="p-4 text-left text-sm font-medium">Low</th>
                        <th class="p-4 text-left text-sm font-medium">%Change</th>
                        <th class="p-4 text-left text-sm font-medium">Trades</th>
                        <th class="p-4 text-left text-sm font-medium">Volume</th>
                        <th class="p-4 text-left text-sm font-medium">Value</th>
                        <th class="p-4 text-left text-sm font-medium">Date</th>
                        <th class="p-4 text-left text-sm font-medium">Action</th>

                    </tr>
                </thead>
                <tbody class="whitespace-nowrap">
                    @forelse ($nsePrices as $item)
                        <tr class="even:bg-blue-50">
                            <td class="p-4">
                                <!-- oop-iteration -->
                                {{ $loop->iteration }}
                            </td>

                            <td class="p-4">{{ $item->security_name }}</td>
                            <td class="p-4">{{ $item->previous_close }}</td>
                            <td class="p-4">{{ $item->open }}</td>
                            <td class="p-4">{{ $item->high }}</td>
                            <td class="p-4">{{ $item->low }}</td>
                            <td class="p-4">{{ $item->change }}</td>
                            <td class="p-4">{{ $item->deals }}</td>
                            <td class="p-4">{{ $item->volume }}</td>
                            <td class="p-4">{{ $item->value }}</td>
                            <td class="p-4">
                                {{ $item->trade_date ? \Carbon\Carbon::parse($item->trade_date)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="p-4">
                                <button type="button" class="btn bg-primary text-white view-btn"
                                    data-item='@json($item)'>
                                    View
                                </button>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="p-4 text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



        <!-- Smaller centered modal -->
        <div id="nse-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50">
            <!-- Dialog -->
            <div class="relative w-[400px] max-w-md rounded-lg bg-white shadow-lg">
                <!-- Header -->
                <div class="flex items-center justify-between border-b px-4 py-3">
                    <h3 class="text-base font-semibold text-gray-900">Details</h3>
                    <button type="button" class="p-1 rounded hover:bg-gray-100" aria-label="Close">
                        <span class="text-xl leading-none">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-4 py-5">



                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-2 border-t px-4 py-3">
                    <button type="button" class="px-3 py-1.5 rounded-md bg-gray-600 text-white hover:bg-black text-sm">
                        Cancel
                    </button>

                </div>
            </div>
        </div>




    </main>
@endsection
