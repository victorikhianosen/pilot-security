@extends('layouts.admin.app')

@section('admin_content')
    <main class="flex-grow p-6">

        <!-- Page Title Start -->
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Dashboard</h4>

            <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">

                <div>
                    <button class="btn bg-primary text-white" data-fc-target="default-modal" data-fc-type="modal"
                        type="button">
                        Upload Pricing
                    </button>
                </div>




            </div>
        </div>

        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
            <div class="col-span-1">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="w-12 h-12 flex justify-center items-center rounded text-primary bg-primary/25">
                                    <i class="mgc_document_2_line text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h5 class="mb-1">Total Customer</h5>
                                <p>{{ number_format($totalCustomers) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="w-12 h-12 flex justify-center items-center rounded text-success bg-success/25">
                                    <i class="mgc_group_line text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h5 class="mb-1">Total Employees</h5>
                                <p>32</p>
                            </div>
                            <div>
                                <button class="text-gray-600 dark:text-gray-400" data-fc-type="dropdown"
                                    data-fc-placement="left-start" type="button">
                                    <i class="mgc_more_2_fill text-xl"></i>
                                </button>

                                <div
                                    class="hidden fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-36 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                        href="javascript:void(0)">
                                        Today
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                        href="javascript:void(0)">
                                        Yesterday
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        href="javascript:void(0)">
                                        Last Week
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        href="javascript:void(0)">
                                        Last Month
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="w-12 h-12 flex justify-center items-center rounded text-info bg-info/25">
                                    <i class="mgc_star_line text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h5 class="mb-1">Project Reviews</h5>
                                <p>40</p>
                            </div>
                            <div>
                                <button class="text-gray-600 dark:text-gray-400" data-fc-type="dropdown"
                                    data-fc-placement="left-start" type="button">
                                    <i class="mgc_more_2_fill text-xl"></i>
                                </button>

                                <div
                                    class="hidden fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-36 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                        href="javascript:void(0)">
                                        Today
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                        href="javascript:void(0)">
                                        Yesterday
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        href="javascript:void(0)">
                                        Last Week
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        href="javascript:void(0)">
                                        Last Month
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="w-12 h-12 flex justify-center items-center rounded text-warning bg-warning/25">
                                    <i class="mgc_new_folder_line text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h5 class="mb-1">New Projects</h5>
                                <p>25</p>
                            </div>
                            <div>
                                <button class="text-gray-600 dark:text-gray-400" data-fc-type="dropdown"
                                    data-fc-placement="left-start" type="button">
                                    <i class="mgc_more_2_fill text-xl"></i>
                                </button>

                                <div
                                    class="hidden fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-36 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                        href="javascript:void(0)">
                                        Today
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                                        href="javascript:void(0)">
                                        Yesterday
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        href="javascript:void(0)">
                                        Last Week
                                    </a>
                                    <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        href="javascript:void(0)">
                                        Last Month
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Grid End -->




        <div class="mt-12 overflow-x-auto">
                    <h1 class="pb-6 text-lg">NSE Trends</h1>

            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white whitespace-nowrap">
                    <tr>
                        <th class="p-4 text-left text-sm font-medium">Company</th>
                        <th class="p-4 text-left text-sm font-medium">Previous Close</th>
                        <th class="p-4 text-left text-sm font-medium">Open</th>
                        <th class="p-4 text-left text-sm font-medium">High</th>
                        <th class="p-4 text-left text-sm font-medium">Low</th>
                        <th class="p-4 text-left text-sm font-medium">%Spread</th>
                        <th class="p-4 text-left text-sm font-medium">Close</th>
                        <th class="p-4 text-left text-sm font-medium">%Change</th>
                        <th class="p-4 text-left text-sm font-medium">Trades</th>
                        <th class="p-4 text-left text-sm font-medium">Volume</th>
                        <th class="p-4 text-left text-sm font-medium">Value</th>

                    </tr>
                </thead>
                <tbody class="whitespace-nowrap">
                    @forelse ($nsePrices as $item)
                        <tr class="even:bg-blue-50">

                            <td class="p-4">{{ $item->security_name }}</td>
                            <td class="p-4">{{ $item->previous_close }}</td>
                            <td class="p-4">{{ $item->open }}</td>
                            <td class="p-4">{{ $item->high }}</td>
                            <td class="p-4">{{ $item->low }}</td>
                            <td class="p-4">{{ $item->spread_pct }}</td>
                            <td class="p-4">{{ $item->close }}</td>
                            <td class="p-4">{{ $item->change }}</td>
                            <td class="p-4">{{ $item->deals }}</td>
                            <td class="p-4">{{ $item->volume }}</td>
                            <td class="p-4">{{ $item->value }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="p-4 text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>





        <!-- Modal -->
        <div id="default-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden"
            data-fc-backdrop="static">
            <div
                class="fc-modal-open:opacity-100 duration-500 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto flex flex-col bg-white border shadow-sm rounded-md dark:bg-slate-800 dark:border-gray-700">

                <div class="flex justify-between items-center py-2.5 px-4 border-b dark:border-gray-700">
                    <h3 class="font-medium text-gray-800 dark:text-white text-lg">Upload Pricing</h3>
                    <button class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8 dark:text-gray-200"
                        data-fc-dismiss type="button">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>

                <form action="{{ route('admin.upload.pricing') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="px-4 py-8 overflow-y-auto">

                        <div id="uploadArea" class="flex items-center justify-center w-full">
                            <label for="fileUpload"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-slate-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-slate-600 transition">
                                <div id="uploadContent" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-300">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-300">PDF, Excel, Word, Images up to 10MB
                                    </p>
                                </div>
                                <input id="fileUpload" name="nse" type="file" accept=".xls,.xlsx"
                                    class="hidden" />
                            </label>
                        </div>

                    </div>

                    <div class="flex justify-end items-center gap-4 p-4 border-t dark:border-slate-700">
                        <button
                            class="btn border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700"
                            data-fc-dismiss type="button">Close</button>
                        <button type="submit" class="btn bg-primary text-white">Save</button>
                    </div>
                </form>
            </div>
        </div>




        <script>
            const fileInput = document.getElementById('fileUpload');
            const uploadContent = document.getElementById('uploadContent');

            // Prevent modal from closing on file input interactions
            fileInput.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const fileType = file.type;
                const fileName = file.name;

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        uploadContent.innerHTML = `
                        <img src="${e.target.result}" alt="Preview"
                            class="max-h-40 rounded shadow border border-gray-300 object-contain" />
                        <button id="changeFileButton" type="button"
                            class="mt-3 px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Change File
                        </button>
                    `;
                        attachChangeButton();
                    }
                    reader.readAsDataURL(file);
                } else {
                    const iconSVG = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 dark:text-gray-300" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1M4 12l1.293-1.293a1 1 0 0 1 1.414 0L12 16l5.293-5.293a1 1 0 0 1 1.414 0L20 12"/>
                    </svg>
                `;

                    uploadContent.innerHTML = `
                    ${iconSVG}
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 text-center truncate max-w-[200px]">${fileName}</p>
                    <button id="changeFileButton" type="button"
                        class="mt-3 px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Change File
                    </button>
                `;
                    attachChangeButton();
                }
            });

            function attachChangeButton() {
                const changeButton = document.getElementById('changeFileButton');
                if (changeButton) {
                    changeButton.addEventListener('click', function(event) {
                        event.stopPropagation();
                        fileInput.value = '';
                        uploadContent.innerHTML = `
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-300" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-300">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-300">PDF, Excel, Word, Images up to 10MB</p>
                    `;
                    });
                }
            }
        </script>


    </main>
@endsection
