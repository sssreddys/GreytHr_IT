    <div class="main">

        <div wire:loading
            wire:target="submit,setActiveTab,closeDetails,selectedStatus,updateStatus,postComment,updateAssigne,redirectBasedOnStatus,viewDetails,openForDesks,postRemarks,closeForDesks">
            <div class="loader-overlay">
                <div>
                    <div class="logo">
                        <!-- <i class="fas fa-user-headset"></i> -->
                        <img src="{{ asset('images/Screenshot 2024-10-15 120204.png') }}" width="58" height="50"
                            alt="">&nbsp;
                        <span>IT</span>&nbsp;&nbsp;
                        <span>EXPERT</span>
                    </div>
                </div>
                <div class="loader-bouncing">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <div class="row req-pro-main-page">

            <div class="col-lg-9 col-md-7 col-xs-12">

                <div class="req-pro-head">

                    <req-pro-nav class="req-pro-req-pro-nav">

                        <ul class="tabss">

                            <li class="tab" wire:click="setActiveTab('active')">

                                <i class="fas fa-check"></i> Active

                                @if($activeTab === 'active')
                                <img class="req-active-tick"
                                    src="https://png.pngtree.com/png-vector/20221215/ourmid/pngtree-green-check-mark-png-image_6525691.png"
                                    alt="">
                                @endif
                            </li>

                            <li class="tab" wire:click="setActiveTab('pending')">

                                <i class="fas fa-clock"></i> Inprogress

                                @if($activeTab === 'pending')
                                <img class="req-active-tick"
                                    src="https://png.pngtree.com/png-vector/20221215/ourmid/pngtree-green-check-mark-png-image_6525691.png"
                                    alt="">
                                @endif

                            </li>

                            <li class="tab" wire:click="setActiveTab('closed')">

                                <i class="fas fa-times"></i> Closed

                                @if($activeTab === 'closed')
                                <img class="req-active-tick"
                                    src="https://png.pngtree.com/png-vector/20221215/ourmid/pngtree-green-check-mark-png-image_6525691.png"
                                    alt="">
                                @endif

                            </li>

                        </ul>

                    </req-pro-nav>



                </div>



                <div class="mt-2">

                    <div class="req-main-page">
                        <div id="active" class="req-pro-tab-content"
                            style="display: {{ $activeTab === 'active' ? 'block' : 'none' }};">

                            <div class="req-pro-details">

                                <h3 class="req-inprogress-heading mb-3">Request Details</h3>

                            </div>

                            @if($viewingDetails && $selectedRequest)

                            @if($viewingDetails)
                            <button class="btn text-white float:right" style="background-color: #02114f;" wire:click="closeDetails" @if($loading)
                                disabled @endif>
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            @endif
                            <div class="req-pro-tablediv">

                                <table class="table table-bordered mt-3 req-pro-table">

                                    <thead>

                                        <tr>

                                            <th>Field</th>

                                            <th>Value</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>Requested By</td>

                                            <td>{{$selectedRequest->emp->first_name }}
                                                {{$selectedRequest->emp->last_name }}
                                            </td>

                                        </tr>

                                        <tr>

                                            <td>Service Request</td>

                                            <td>{{$selectedRequest->category ?? 'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Subject</td>

                                            <td>{{$selectedRequest->subject??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Description</td>

                                            <td>{{$selectedRequest->description ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Distributor</td>

                                            <td>{{$selectedRequest->distributor_name ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Phone</td>

                                            <td>{{$selectedRequest->mobile ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>MailBox</td>

                                            <td>{{$selectedRequest->mail ??'N/A' }}</td>

                                        </tr>

                                        <tr>
                                            <td>Attach Files</td>
                                            <td>
                                                <a href="#" data-toggle="modal"
                                                    data-target="#attachmentsModal-{{ $selectedRequest->id }}">
                                                    <i class="fas fa-eye"></i> View Attachments
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="attachmentsModal-{{ $selectedRequest->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="attachmentsModalLabel-{{ $selectedRequest->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="attachmentsModalLabel-{{ $selectedRequest->id }}">
                                                            Attachments</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">

                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Swiper -->
                                                        <div class="swiper-container">
                                                            <div class="swiper-wrapper">

                                                                <div class="swiper-slide reqResSwiper">

                                                                    <img src="{{ $selectedRequest->image_url }}"
                                                                        class="req-Res-Image" alt="Image">
                                                                    <!-- <img src="data:image/jpeg;base64,{{ $selectedRequest->file_path }}" class="img-fluid" width="50" height="50" alt="Image preview"> -->
                                                                </div>
                                                            </div>
                                                            <!-- Add Pagination -->
                                                            <div class="swiper-pagination"></div>
                                                            <!-- Add Navigation -->
                                                            <div class="swiper-button-next"></div>
                                                            <div class="swiper-button-prev"></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn text-white" style="background-color: #02114f;"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                        <tr>

                                            <td>CC To</td>

                                            <td>{{$selectedRequest->cc_to ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Priority</td>

                                            <td>{{$selectedRequest->priority ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Select Equipment</td>

                                            <td>{{$selectedRequest->selected_equipment ??'N/A' }}</td>

                                        </tr>

                                        <tr>
                                            <td>Status <span class="text-danger">*</span></td>

                                            <td>
                                                <select wire:model="selectedStatus" class="req-selected-status"
                                                    wire:change="updateStatus('{{ $selectedRequest->id }}')">
                                                    <option value="" disabled selected>Select Status </option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Completed">Completed</option>
                                                    <!-- Add other status options as needed -->
                                                </select>
                                                @error('selectedStatus') <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </td>
                                        </tr>


                                        <tr>
                                            <td>Comments</td>
                                            <td>

                                                <div>
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <textarea wire:model.lazy="comments"
                                                                class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-2 d-flex align-items-center">
                                                            <button class="btn text-white" style="background-color: #02114f;"
                                                                wire:click="postComment('{{ $selectedRequest->id }}')"
                                                                @if($loading) disabled @endif>Post</button>
                                                        </div>
                                                    </div>


                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>Assign to <span class="text-danger">*</span></td>
                                            <td>
                                                <select class="req-selected-status" wire:model="selectedAssigne"
                                                    wire:change="updateAssigne('{{ $selectedRequest->id }}')">
                                                    <option value="" disabled selected>Select Assignee</option>
                                                    @foreach($itData as $itName)
                                                    <option
                                                        value="{{ $itName->empIt->first_name }} {{ $itName->empIt->last_name }} ">
                                                        {{ ucwords(strtolower($itName->empIt->first_name)) }}
                                                        {{ ucwords(strtolower($itName->empIt->last_name)) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('selectedAssigne') <span
                                                    class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </td>

                                        </tr>




                                    </tbody>

                                </table>

                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn text-white mb-3" style="background-color: #02114f;" wire:click="redirectBasedOnStatus" @if($loading)
                                        disabled @endif>Save &
                                        Continue</button>
                                </div>


                            </div>



                            @else

                            @if($forIT->where('status', 'Open')->count() > 0)
                            <div class="scrollable-container">
                                <div class="req-pro-card">

                                    @foreach ($forIT->where('status', 'Open') as $index => $request)

                                    <div class="request-card">

                                        <div class="req-pro-card-body">

                                            <div>

                                                <p class="req-reqBy-Dep"><b>Requested By:</b>
                                                    <span class="req-res-depart1">
                                                        {{ $request->emp->first_name }}
                                                        {{ $request->emp->last_name }}
                                                    </span>
                                                </p>

                                                <p title="{{ $request['category'] }}">
                                                    <b>Service Request: </b><span
                                                        class="req-res-depart">{{ $request->category ?? 'N/A' }}</span>
                                                </p>

                                            </div>

                                            <button wire:click="viewDetails({{ $index }})"
                                                class="req-pro-view-details-btn" @if($loading) disabled
                                                @endif>View</button>

                                        </div>

                                    </div>

                                    @endforeach

                                </div>
                            </div>

                            @else
                            <div class="req-requestnotfound">
                                <td colspan="20" >

                                    <div class="req-td-norecords">
                                        <img src="{{ asset('images/Closed.webp') }}" alt="No Records"
                                            class="req-img-norecords">

                                        <h3 class="req-head-norecords">No requests found
                                        </h3>
                                    </div>
                                </td>
                            </div>
                            @endif
                            @endif
                        </div>

                        <div id="pending" class="req-pro-tab-content"
                            style="display: {{ $activeTab === 'pending' ? 'block' : 'none' }};">

                            <div>
                                <h3 class="req-inprogress-heading">
                                    In Progress Requests</h3>
                            </div>

                            <div class="row ">

                                <div class="col-12 mt-2">

                                    <div class="table-responsive req-table-res">

                                        <table class="custom-table">

                                            <thead>

                                                <tr>

                                                    <th scope="col" class="req-table-head">Employee ID</th>

                                                    <th class="req-table-head">Requested By</th>

                                                    <th class="req-table-head">Service Request</th>

                                                    <th class="req-table-head">Subject</th>

                                                    <th class="req-table-head">Description</th>

                                                    <th class="req-table-head">Distributor</th>

                                                    <th class="req-table-head">Phone</th>

                                                    <th class="req-table-head">MailBox</th>

                                                    <th class="req-table-head">Attach Files</th>



                                                    <th class="req-table-head">Priority</th>

                                                    <th class="req-table-head">Select Equipment</th>

                                                    <th class="req-table-head">Status</th>

                                                    <th class="req-table-head">Assigned to</th>

                                                    <th class="req-table-head">Comments</th>

                                                    <th class="req-table-head">Close Request</th>
                                                    <th class="req-table-head-Remarks">
                                                        Remarks</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                @if($forIT->where('status', 'Pending')->count() > 0)
                                                @foreach ($forIT->where('status', 'Pending') as $index =>$record)
                                                @php
                                                $ccToArray = explode(',', $record->cc_to);
                                                @endphp
                                                <tr>

                                                    <td scope="row">{{ $record->emp_id }}</td>

                                                    <td>{{ $record->emp->first_name }} {{ $record->emp->last_name }}
                                                        <br>
                                                        <strong class="req-res-emp_id">({{$record->emp_id}})
                                                    </td>

                                                    <td>{{ $record->category ?? 'N/A'}}</td>

                                                    <td>{{ $record->subject ?? 'N/A' }}</td>

                                                    <td>{{ $record->description?? 'N/A' }}</td>

                                                    <td>{{ $record->distributor_name?? 'N/A' }}</td>

                                                    <td>{{ $record->mobile?? 'N/A' }}</td>

                                                    <td>{{ $record->mail ??'N/A' }}</td>

                                                    <td>

                                                        @if(isset($record['file_path']) &&
                                                        is_array($record['file_path']))

                                                        <div class="req-image-grid">

                                                            @foreach($record['file_path'] as $image)

                                                            <a href="{{ $image }}" target="_blank">

                                                                <img src="{{ $image }}" alt="Attached Image">

                                                            </a>

                                                            @endforeach

                                                        </div>

                                                        @else

                                                        <p class="d-flex justify-content-center">-</p>

                                                        @endif

                                                    </td>





                                                    <td>{{ $record->priority?? 'N/A' }}</td>

                                                    <td>{{ $record->selected_equipment?? 'N/A' }}</td>

                                                    <td>
                                                        <div class="req-status"> {{ $record['status'] }}
                                                        </div>
                                                    </td>

                                                    <td>{{ $record['assign_to'] }}</td>

                                                    <td> {{$record -> active_comment?? 'N/A'}}</td>


                                                    <td>
                                                        <button wire:click="openForDesks('{{$record->id}}')"
                                                            class="btn btn-white border-black text-black" @if($loading)
                                                            disabled @endif>Close </button>
                                                    </td>

                                                    <td>
                                                        <form wire:submit.prevent="postRemarks('{{ $record->id }}')">
                                                            <div class="row">
                                                                <div class="col-12 d-flex align-items-center">
                                                                    <!-- Textarea takes most of the width -->
                                                                    <textarea
                                                                        wire:model.lazy="remarks.{{ $record->id }}"
                                                                        class="form-control me-2 req-remarks-textarea"
                                                                        style="flex-grow: 1;"></textarea>

                                                                    <!-- Button is small and aligned to the right -->
                                                                    <button type="submit" style="background-color: #02114f;" class="btn text-white p-2"
                                                                        style="height: fit-content;" @if($loading || empty($remarks[$record->id]))
                                                                        disabled @endif>Post</button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </td>
                                                </tr>



                                                <tr class="req-cc-tr">
                                                    <td colspan="19" class="req-cc-td">
                                                        <div class="req-cc-div">
                                                            <strong style="margin-left: 5px;">CC TO: </strong>
                                                            {{ (empty($ccToArray) || (count($ccToArray) === 1 && $ccToArray[0] === '-')) ? 'N/A' : implode(', ', $ccToArray) }}
                                                            </div>
                                                    </td>
                                                </tr>

                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="20">

                                                        <div class="req-td-norecords">
                                                            <img src="{{ asset('images/Closed.webp') }}"
                                                                alt="No Records" class="req-img-norecords">

                                                            <h3 class="req-head-norecords">No records found
                                                            </h3>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="closed" class="req-pro-tab-content"
                            style="display: {{ $activeTab === 'closed' ? 'block' : 'none' }};">
                            <div>
                                <h3 class="req-closed-head">
                                    Closed Requests</h3>
                            </div>
                            <div class="row">

                                <div class="col-12 mt-2">


                                    <div class="table-responsive  req-closed-table-res">


                                        <table class="custom-table">

                                            <thead>

                                                <tr>

                                                    <th scope="col" class="req-closed-th">Employee ID</th>

                                                    <th class="req-closed-th">Requested By</th>

                                                    <th class="req-closed-th">Service Request</th>

                                                    <th class="req-closed-th">Subject</th>

                                                    <th class="req-closed-th">Description</th>

                                                    <th class="req-closed-th">Distributor</th>

                                                    <th class="req-closed-th">Phone</th>

                                                    <th class="req-closed-th">MailBox</th>

                                                    <th class="req-closed-th">Attach Files</th>



                                                    <th class="req-closed-th">Priority</th>

                                                    <th class="req-closed-th">Select Equipment</th>

                                                    <th class="req-closed-th">Status</th>

                                                    <th class="req-closed-th">Assigned to</th>

                                                    <th class="req-closed-th">Comments</th>
                                                    <th class="req-closed-th">Remarks</th>
                                                    <th class="req-closed-th">Re Open</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                @if($forIT->where('status', 'Completed')->count() > 0)
                                                @foreach ($forIT->where('status', 'Completed') as $record)
                                                @php
                                                $ccToArray = explode(',', $record->cc_to);
                                                @endphp
                                                <tr>

                                                    <td scope="row">{{ $record->emp_id }}</td>

                                                    <td>{{ $record->emp->first_name }} {{ $record->emp->last_name }}
                                                        <br>
                                                        <strong class="req-res-emp_id">({{$record->emp_id}})
                                                    </td>

                                                    <td>{{ $record->category ?? 'N/A'}}</td>

                                                    <td>{{ $record->subject ?? 'N/A' }}</td>

                                                    <td>{{ $record->description ?? 'N/A' }}</td>

                                                    <td>{{ $record->distributor_name ?? 'N/A' }}</td>

                                                    <td>{{ $record->mobile ?? 'N/A' }}</td>

                                                    <td>{{ $record->mail ??'N/A' }}</td>

                                                    <td>

                                                        @if(isset($record['file_path']) &&
                                                        is_array($record['file_path']))

                                                        <div class="req-image-grid">

                                                            @foreach($record['file_path'] as $image)

                                                            <a href="{{ $image }}" target="_blank">

                                                                <img src="{{ $image }}" alt="Attached Image">

                                                            </a>

                                                            @endforeach

                                                        </div>

                                                        @else

                                                        <p class="d-flex justify-content-center">-</p>

                                                        @endif

                                                    </td>



                                                    <td>{{ $record->priority?? 'N/A' }}</td>

                                                    <td>{{ $record->selected_equipment?? 'N/A' }}</td>

                                                    <td>
                                                        <div class="req-status-closed">
                                                            {{ $record['status'] }}
                                                        </div>
                                                    </td>

                                                    <td>{{ $record['assign_to'] }}</td>

                                                    <td>{{$record -> active_comment?? 'N/A'}}</td>
                                                    <td>{{$record -> inprogress_remarks?? 'N/A'}}</td>

                                                    <td>

                                                        <button wire:click="closeForDesks('{{$record->id}}')"
                                                            class="btn border-white text-white" style="background-color: #02114f;" @if($loading)
                                                            disabled @endif>Open</button>
                                                    </td>


                                                </tr>


                                                <tr class="req-cc-tr">


                                                    <td colspan="19" class="req-cc-td">
                                                        <div class="req-cc-div">
                                                            <strong style="margin-left: 5px;">CC TO: </strong>
                                                       {{ (empty($ccToArray) || (count($ccToArray) === 1 && $ccToArray[0] === '-')) ? 'N/A' : implode(', ', $ccToArray) }}</u>

                                                        </div>
                                                    </td>
                                                </tr>


                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="20" >

                                                        <div class="req-td-norecords">
                                                            <img src="{{ asset('images/Closed.webp') }}"
                                                                alt="No Records" class="req-img-norecords">

                                                            <h3 class="req-head-norecords">No records found
                                                            </h3>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-5 col-xs-12  req-pro-col3">
                <div class="row req-overview-main">
                    <div class="col-10">
                        <h5 class="mb-3 req-overview-head">
                            Overview</h5>
                    </div>
                    <div class="col-2">
                        <!-- <i wire:click="toggleOverview" class="fas fa-caret-down req-pro-dropdown-arrow" style="margin-left: auto; cursor: pointer;"></i> -->
                        <!-- <i wire:click="toggleOverview"
                            class="fas fa-caret-down req-pro-dropdown-arrow {{ $showOverview ? 'rotated' : '' }} req-overview-icon"></i> -->

                    </div>
                </div>

                <div class="req-pro-overview-container">
                    <div class="req-pro-overview-card">

                        <div class="card text-dark  req-pro-over-card1">

                            <div class="req-pro-card-body-overview">

                                <h5 class="card-title"> Active</h5>

                                <p class="card-text reqCardText">Total Active

                                    <span
                                        class="bg-white text-primary rounded-circle  p-2 d-inline-flex align-items-center justify-content-center req-pro-overview-val">

                                        <strong> {{$activeCount}} </strong>

                                    </span>

                                </p>

                            </div>

                        </div>

                        <i class="fas fa-arrow-down req-pro-arrow"></i>

                    </div>

                    <div class="req-pro-overview-card">

                        <div class="card text-dark  req-pro-over-card2">

                            <div class="req-pro-card-body-overview">

                                <h5 class="card-title">In Progress</h5>

                                <p class="card-text reqCardText">Total In Progress

                                    <span
                                        class="bg-white text-primary rounded-circle p-2 d-inline-flex align-items-center justify-content-center req-pro-overview-val">

                                        <strong>{{$pendingCount}}</strong>

                                    </span>

                                </p>

                            </div>

                        </div>

                        <i class="fas fa-arrow-down req-pro-arrow"></i>

                    </div>

                    <div class="req-pro-overview-card">

                        <div class="card text-dark  req-pro-over-card3">

                            <div class="req-pro-card-body-overview">

                                <h5 class="card-title">Closed</h5>

                                <p class="card-text reqCardText">Total Closed

                                    <span
                                        class="bg-white text-primary rounded-circle p-2 d-inline-flex align-items-center justify-content-center req-pro-overview-val">

                                        <strong>{{$closedCount}}</strong>

                                    </span>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>









        <!-- jQuery and Bootstrap Bundle (includes Popper) -->

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



        <script>
        function showTab(tab) {

            document.querySelectorAll('.req-pro-tab-content').forEach(el => el.style.display = 'none');

            document.getElementById(tab).style.display = 'block';

        }



        document.addEventListener("DOMContentLoaded", () => {
            showTab('{{ $activeTab }}'); // Show the initially active tab
        });

        Livewire.on('tabSwitched', tab => {
            showTab(tab);
        });




        document.addEventListener('livewire:load', function() {
            var swiper = new Swiper('.swiper-container', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });

        //for to remove the space after session message
        </script>

    </div>
