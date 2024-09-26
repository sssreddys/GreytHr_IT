<div class="main">

    <div class="container AssetEmployee mt-4">

        <div class="col-11 d-flex justify-content-end">
            <div class="">
                @if ($showEMployeeAssetBtn)
                <button class="btn btn-dark" wire:click="closeViewVendor"><i class="fas fa-arrow-left"></i> Back
                </button>
                @endif
                @if ($showOldEMployeeAssetBtn)
                <button class="btn btn-dark mr-3" wire:click="oldAssetlisting">Previous Owners </button>
                @endif
                @if ($showAssignAssetBtn)
                <button class="btn btn-dark" wire:click="assignAsset">Assign Asset</button>
                @endif
            </div>
        </div>

        @if($assetEmpCreateUpdate)
        <!-- Row for Dropdowns -->
        <div class="row mb-3 d-flex justify-content-around">
            <!-- Asset Dropdown -->
            <div class="col-md-5">
                @if (session()->has('message'))
                <div id="flash-message" class="alert alert-success mt-1">
                    {{ session('message') }}
                </div>
                @endif
                <label for="assetSelect" class="form-label">Select Asset</label>
                <select id="assetSelect" class="form-select" wire:model="selectedAsset" wire:change="fetchAssetDetails">
                    <option value="">Choose Asset</option>
                    @foreach ($assetSelect as $asset)
                    <option value="{{ $asset->asset_id }}"
                        class="{{ in_array($asset->asset_id, $assignedAssetIds) ? 'inactive-option' : 'active-option' }}"
                        {{ (in_array($asset->asset_id, $assignedAssetIds) && $asset->asset_id !== $selectedAsset) ? 'disabled' : '' }}
                        {{ $isUpdateMode && $asset->asset_id == $selectedAsset ? 'selected' : '' }}>
                        {{ $asset->asset_id }}
                    </option>

                    @endforeach
                </select>
                @error('selectedAsset')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Employee ID Dropdown -->
            <div class="col-md-5">
                <label for="employeeSelect" class="form-label">Select Employee ID</label>
                <select id="employeeSelect" class="form-select" wire:model="selectedEmployee"
                    wire:change="fetchEmployeeDetails" {{ $isUpdateMode ? 'disabled' : '' }}>
                    <option value="">Choose Employee</option>
                    @foreach ($assetSelectEmp as $employee)
                    <option value="{{ $employee->emp_id }}"
                        class="{{ in_array($employee->emp_id, $assignedEmployeeIds) ? 'inactive-option' : 'active-option' }}"
                        {{ (in_array($employee->emp_id, $assignedEmployeeIds) && $employee->emp_id !== $selectedEmployee) ? 'disabled' : '' }}
                        {{ $isUpdateMode && $employee->emp_id == $selectedEmployee ? 'selected' : '' }}>
                        {{ $employee->emp_id }}
                    </option>
                    @endforeach
                </select>
                @error('selectedEmployee')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Row for Details Cards -->
        <div class="row mt-4 d-flex justify-content-around">
            <div class="col-md-4">
                @if ($assetDetails)
                <div class="assetEmpDetailsCard p-3 mb-3">
                    <h5><u>Asset Details</u></h5>
                    <p><strong>Manufacturer:</strong> <span>{{ $assetDetails->manufacturer }}</span></p>
                    <p><strong>Asset Type:</strong> {{ $assetDetails->asset_type }}</p>
                    <p><strong>Asset Model:</strong> {{ $assetDetails->asset_model }}</p>
                    <p><strong>Serial Number:</strong> {{ $assetDetails->serial_number }}</p>
                    <p><strong>Specifications:</strong> {{ $assetDetails->asset_specification }}</p>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                @if ($empDetails)
                <div class="assetEmpDetailsCard p-3 mb-3">
                    <h5><u>Employee Details</u></h5>
                    <p><strong>Employee Id:</strong> {{ $empDetails->emp_id }}</p>
                    <p><strong>Employee Name:</strong> {{ $empDetails->first_name }} {{ $empDetails->last_name }}</p>
                    <p><strong>Email:</strong> {{ $empDetails->email }}</p>
                    <p><strong>Department:</strong> {{ $empDetails->job_role }}</p>
                    <p><strong>Job Mode:</strong> {{ $empDetails->job_mode }}</p>
                </div>
                @endif
            </div>
        </div>

        <div wire:loading>
            <div class="loader-overlay">
                <div class="loader"></div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-4 text-center">
            <button class="btn btn-dark" wire:click="submit">
                {{ $isUpdateMode ? 'Update Assigne' : 'Assign' }}
            </button>

            <!-- Success Message -->
            @if (session()->has('message'))
            <div id="flash-message" class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
            @endif
        </div>
        @endif




        @if($employeeAssetListing)

        @if($searchFilters)
        <!-- Search Filters -->
        <div class="row mb-3 mt-4 ml-4 employeeAssetList">
            <!-- Employee ID Search Input -->
            <div class="col-10 col-md-3 mb-2 mb-md-0">
                <input type="text" class="form-control" placeholder="Search by Employee ID"
                    wire:model.debounce.500ms="searchEmpId" wire:keydown.enter="filter">
            </div>

            <!-- Asset ID Search Input -->
            <div class="col-10 col-md-3 mb-2 mb-md-0">
                <input type="text" class="form-control" placeholder="Search by Asset ID"
                    wire:model.debounce.500ms="searchAssetId" wire:keydown.enter="filter">
            </div>

            <!-- Buttons -->
            <div class="col-10 col-md-3 d-flex gap-2 flex-column flex-md-row">
                <button class="btn btn-dark" wire:click="filter">
                    <i class="fa fa-search"></i> Search
                </button>
                <button class="btn btn-white text-dark border border-dark" wire:click="clearFilters">
                    <i class="fa fa-times"></i> Clear
                </button>
            </div>
        </div>

        @endif
        @if($showEditDeleteEmployeeAsset)
        <div class="col-11 mt-4 ml-4">
            <div class="table-responsive it-add-table-res">
                <div wire:loading>
                    <div class="loader-overlay">
                        <div class="loader"></div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th class="req-table-head" scope="col">Employee Id</th>

                            <th class="req-table-head">Asset Id</th>
                            <th class="req-table-head">Manufacturer</th>
                            <th class="req-table-head">Asset Type</th>
                            <th class="req-table-head">Employee Name</th>
                            <th class="req-table-head">Department</th>

                            <th class="req-table-head">Actions</th> <!-- Added Actions Column -->
                        </tr>
                    </thead>
                    <tbody>

                        @if($employeeAssetLists->count() > 0)
                        @forelse($employeeAssetLists as $employeeAssetList)
                        @if($employeeAssetList->is_active == 1)
                        <tr>
                            <td>{{ $employeeAssetList->emp_id }}</td>
                            <td>{{ $employeeAssetList->asset_id }}</td>
                            <td>{{ $employeeAssetList->manufacturer }}</td>
                            <td>{{$employeeAssetList['asset_type_name'] }}</td>
                            <td>{{ $employeeAssetList->employee_name }}</td>
                            <td>{{ $employeeAssetList->department }}</td>
                            <td class="d-flex ">
                                <!-- Action Buttons -->
                                <div class="col">
                                    <button class="btn btn-sm btn-white border-dark"
                                        wire:click="viewDetails({{ $employeeAssetList->id }})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <!-- Edit Action -->
                                <div class="col">
                                    <button class="btn btn-sm btn-white border-dark"
                                        wire:click="edit({{ $employeeAssetList->id }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <!-- Delete Action -->
                                <div class="col">
                                    <button class="btn btn-dark btn-sm border-dark"
                                        wire:click="confirmDelete({{ $employeeAssetList->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        @endforelse
                        @else
                        <tr>
                            <td colspan="20" class="req-td-norecords">

                                <div>
                                    <img src="{{ asset('images/Closed.webp') }}" alt="No Records"
                                        class="req-img-norecords">


                                    <h3 class="req-head-norecords">No data found</h3>
                                </div>
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
        @endif


        <!-- View Vendor Details Modal -->
        @if($showViewEmployeeAsset && $currentVendorId)
        @php
        // Find the specific vendor by the currentVendorId
        $vendor = $employeeAssetLists->firstWhere('id', $currentVendorId);
        @endphp

        @if($vendor)
        <div class="col-10 mt-4 itadd-maincolumn">
            <div class="d-flex justify-content-between align-items-center">
                <h3>View Details</h3>
                <button class="btn btn-dark" wire:click="closeViewVendor" aria-label="Close">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>

            <table class="table table-bordered mt-3 req-pro-table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Employee Id</td>
                        <td>{{ $vendor->emp_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Vendor Id</td>
                        <td>{{ $vendor->vendorAsset->vendor_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Asset Id</td>
                        <td>{{ $vendor->asset_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Manufacturer</td>
                        <td>{{ $vendor->manufacturer ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Asset Type</td>
                        <td>{{ $vendor['asset_type_name'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Asset Model</td>
                        <td>{{ $vendor->vendorAsset->asset_model ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Employee Name</td>
                        <td>{{ $vendor->employee_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{{ $vendor->department ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Color</td>
                        <td>{{ $vendor->vendorAsset->color ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Invoice Amount</td>
                        <td>{{ $vendor->vendorAsset->invoice_amount ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Invoice Number</td>
                        <td>{{ $vendor->vendorAsset->invoice_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Serial Number</td>
                        <td>{{ $vendor->vendorAsset->serial_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Asset Purchase Date</td>
                        <td>
                            {{ $vendor->vendorAsset->purchase_date ? \Carbon\Carbon::parse($vendor->vendorAsset->purchase_date)->format('d-m-Y') : 'N/A' }}
                        </td>
                    </tr>

                    <tr>
                        <td>No of Days</td>
                        <td>
                            {{ $vendor->created_at ? \Carbon\Carbon::parse($vendor->created_at)->diffInDays(\Carbon\Carbon::now()) . ' days' : 'N/A' }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        @else
        <div class="col-10 mt-4 itadd-maincolumn">
            <p>No details available.</p>
        </div>
        @endif

        @endif
        @endif

        @if($oldAssetEmp)

        @if($oldAssetBackButton)
        <div class="col-11 d-flex justify-content-end">
            <div class="">
                <button class="btn btn-dark" wire:click="closeViewVendor" aria-label="Close">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
        @endif

        @if($searchFilters)
        <!-- Search Filters -->
        <div class="row mb-3 mt-4 ml-4 employeeAssetList">
            <!-- Employee ID Search Input -->
            <div class="col-10 col-md-3 mb-2 mb-md-0">
                <input type="text" class="form-control" placeholder="Search by Employee ID"
                    wire:model.debounce.500ms="searchEmpId" wire:keydown.enter="filter">
            </div>

            <!-- Asset ID Search Input -->
            <div class="col-10 col-md-3 mb-2 mb-md-0">
                <input type="text" class="form-control" placeholder="Search by Asset ID"
                    wire:model.debounce.500ms="searchAssetId" wire:keydown.enter="filter">
            </div>

            <!-- Buttons -->
            <div class="col-10 col-md-3 d-flex gap-2 flex-column flex-md-row">
                <button class="btn btn-dark" wire:click="filter">
                    <i class="fa fa-search"></i> Search
                </button>
                <button class="btn btn-white text-dark border border-dark" wire:click="clearFilters">
                    <i class="fa fa-times"></i> Clear
                </button>
            </div>
        </div>

        @endif
        @if($showEditDeleteEmployeeAsset)
        <div class="col-11 mt-4 ml-4">
            <div class="table-responsive it-add-table-res">
                <div wire:loading>
                    <div class="loader-overlay">
                        <div class="loader"></div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th class="req-table-head" scope="col">Employee Id</th>
                            <!-- <th class="req-table-head">Vendor Id</th> -->
                            <th class="req-table-head">Asset Id</th>
                            <th class="req-table-head">Manufacturer</th>
                            <th class="req-table-head">Asset Type</th>
                            <th class="req-table-head">Employee Name</th>
                            <th class="req-table-head">Department</th>
                            <th class="req-table-head">Actions</th>


                        </tr>
                    </thead>
                    <tbody>

                        @if($employeeAssetLists->count() > 0)
                        @forelse($employeeAssetLists as $employeeAssetList)
                        @if($employeeAssetList->is_active == 0)
                        <tr>
                            <td>{{ $employeeAssetList->emp_id }}</td>
                            <!-- <td>{{ $employeeAssetList->vendorAsset->vendor_id }}</td> -->
                            <td>{{ $employeeAssetList->asset_id }}</td>
                            <td>{{ $employeeAssetList->manufacturer }}</td>
                            <td>{{ $employeeAssetList['asset_type_name'] }}</td>
                            <td>{{ $employeeAssetList->employee_name }}</td>
                            <td>{{ $employeeAssetList->department }}</td>
                            <td class="d-flex ">
                                <!-- Action Buttons -->
                                <div class="col">
                                    <button class="btn btn-sm btn-white border-dark"
                                        wire:click="viewOldAssetDetails({{ $employeeAssetList->id }})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        @endif
                        @empty
                        @endforelse
                        @else
                        <tr>
                            <td colspan="20" class="req-td-norecords">

                                <div>
                                    <img src="{{ asset('images/Closed.webp') }}" alt="No Records"
                                        class="req-img-norecords">


                                    <h3 class="req-head-norecords">No data found</h3>
                                </div>
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
        @endif


        <!-- View Vendor Details Modal -->
        @if($showViewEmployeeAsset && $currentVendorId)
        @php
        // Find the specific vendor by the currentVendorId
        $vendor = $employeeAssetLists->firstWhere('id', $currentVendorId);
        @endphp

        @if($vendor)
        <div class="col-10 mt-4 itadd-maincolumn">
            <div class="d-flex justify-content-between align-items-center">
                <h3>View Details</h3>
                <button class="btn btn-dark" wire:click="closeViewEmpAsset" aria-label="Close">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>

            <table class="table table-bordered mt-3 req-pro-table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Employee Id</td>
                        <td>{{ $vendor->emp_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Vendor Id</td>
                        <td>{{ $vendor->vendorAsset->vendor_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Asset Id</td>
                        <td>{{ $vendor->asset_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Manufacturer</td>
                        <td>{{ $vendor->manufacturer ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Asset Type</td>
                        <td>{{ $vendor['asset_type_name'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Asset Model</td>
                        <td>{{ $vendor->vendorAsset->asset_model ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Employee Name</td>
                        <td>{{ $vendor->employee_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{{ $vendor->department ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Color</td>
                        <td>{{ $vendor->vendorAsset->color ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Invoice Amount</td>
                        <td>{{ $vendor->vendorAsset->invoice_amount ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Invoice Number</td>
                        <td>{{ $vendor->vendorAsset->invoice_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Serial Number</td>
                        <td>{{ $vendor->vendorAsset->serial_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Purchase Date</td>
                        <td>
                            {{ $vendor->vendorAsset->purchase_date ? \Carbon\Carbon::parse($vendor->vendorAsset->purchase_date)->format('d-m-Y') : 'N/A' }}
                        </td>
                    </tr>

                    <tr>
                        <td>No of Days</td>
                        <td>
                            @if($vendor->deleted_at)
                            {{ $vendor->created_at ? \Carbon\Carbon::parse($vendor->created_at)->diffInDays(\Carbon\Carbon::parse($vendor->deleted_at)) . ' days' : 'N/A' }}
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @else
        <div class="col-10 mt-4 itadd-maincolumn">
            <p>No details available.</p>
        </div>
        @endif

        @endif
        @endif
    </div>


    @if ($showLogoutModal)
    <div class="modal" style="display: block;" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white " style="background-color: black;">
                    <h6 class="modal-title" style=" align-items: center;" id="logoutModalLabel">Confirm Delete</h6>
                </div>
                <div class="modal-body text-center" style=" font-size: 16px;color:black;">
                    Are you sure you want to delete?
                </div>
                <div class="modal-body text-center">
                    <form wire:submit.prevent="delete">
                        <span class="text-danger d-flex align-start">*</span>
                        <div class="row">
                            <div class="col-12 req-remarks-div">

                                <textarea wire:model.lazy="reason" class="form-control req-remarks-textarea"
                                    style=" min-height: 76px;" placeholder="Reason for deactivation"></textarea>

                            </div>
                        </div>
                        @error('reason') <span class="text-danger d-flex align-start">{{ $message }}</span>@enderror
                        <div class="d-flex justify-content-center p-3">
                            <button type="submit" class="submit-btn mr-3"
                                wire:click="delete({{ $employeeAssetList->id }})">Delete</button>
                            <button type="button" class="cancel-btn1 ml-3" wire:click="cancel">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif






</div>