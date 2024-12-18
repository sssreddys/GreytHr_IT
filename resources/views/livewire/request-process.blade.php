    <div class="main">

        <div wire:loading
            wire:target="submit,setActiveTab,rejectionModal,selectPriority,closePopup,showRejectedRequest,closePendingModal,submitPendingReason,inprogressForDesks,loadLogs,pendingForDesks,closeModal,rejectStatus,cancelModal,cancelStatus,viewRecord,Cancel,viewRejectDetails,closeRejectDetails,closeDetails,closeDetailsBack,selectedStatus,viewApproveDetails,showAllRequest,showRecentRequest,approveStatus,updateStatus,postComment,updateAssigne,redirectBasedOnStatus,viewDetails,openForDesks,postInprogressRemarks,postPendingRemarks,postRemarks,closeForDesks">
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

        <div class="d-flex req-pro-main-page">


            @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')))

            @if($viewRecentRequests)
            <div class="col-lg-9 col-md-10 col-xs-12" style="margin-left: 4%;">

                <div class="d-flex  justify-content-between mb-4">
                    <div>
                        <h3 class="d-flex justify-content-start mb-5 headingForAllModules1">New Requests</h3>

                    </div>


                    <div>
                        <button class="btn btn-success headingForAllModules"
                            style="background-color: #02114f;color:white" wire:click="showRejectedRequest">Rejected
                            Requests</button>

                        <button class="btn btn-success" style="background-color: #02114f;color:white"
                            wire:click="showAllRequest">Approved Requests</button>
                    </div>

                </div>

                @if($recentrequestDetails && $recentRequest)

                @if($recentrequestDetails)
                <button class="btn text-white float:right mb-3" style="background-color: #02114f;"
                    wire:click="closeDetails" @if($loading) disabled @endif>
                    <i class="fas fa-arrow-left"></i> Back
                </button>
                @endif
                <div class="req-pro-tablediv">

                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-2">View Details</h5>

                    </div>
                    <table class="table table-bordered mt-3 req-pro-table">



                        <tbody>

                            <tr>

                                <td>Request ID</td>

                                <td class="view-td">{{$recentRequest->request_id ?? 'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Requested By</td>

                                <td class="view-td">{{$recentRequest->emp->first_name }}
                                    {{$recentRequest->emp->last_name }}
                                </td>

                            </tr>

                            <tr>

                                <td>Catologue Request</td>

                                <td class="view-td">{{$recentRequest->category ?? 'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Subject</td>

                                <td class="view-td">{{$recentRequest->subject??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Description</td>

                                <td class="view-td">{{$recentRequest->description ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Distributor</td>

                                <td class="view-td">{{$recentRequest->distributor_name ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Phone</td>

                                <td class="view-td">{{$recentRequest->mobile ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>MailBox</td>

                                <td class="view-td">{{$recentRequest->mail ??'N/A' }}</td>

                            </tr>

                            <tr>
                                <td>Attach Files</td>
                                <td class="view-td">
                                    @if($recentRequest->image_url)
                                    <a href="#" data-toggle="modal" class="requestAttachments"
                                        data-target="#attachmentsModal-{{ $recentRequest->id }}">
                                        <i class="fas fa-eye"></i> View Attachments
                                    </a>
                                    @else
                                    <span>-</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="attachmentsModal-{{ $recentRequest->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="attachmentsModalLabel-{{ $recentRequest->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="attachmentsModalLabel-{{ $recentRequest->id }}">
                                                Attachments</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Swiper -->
                                            <div class="swiper-container">
                                                <div class="swiper-wrapper">

                                                    <div class="swiper-slide reqResSwiper">

                                                        <img src="{{ $recentRequest->image_url }}" class="req-Res-Image"
                                                            alt="Image">
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
                                            <button type="button" class="btn text-white"
                                                style="background-color: #02114f;" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <tr>

                                <td>CC To</td>

                                <td class="view-td">{{$recentRequest->cc_to ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Priority</td>

                                <td class="view-td">
                                    <!-- Dropdown for Priority -->
                                    <select wire:model="priority" class="form-control"
                                        wire:change="selectPriority($event.target.value)">
                                        <option value="high" @if($recentRequest->priority == 'high') selected
                                            @endif>High
                                        </option>
                                        <option value="medium" @if($recentRequest->priority == 'medium') selected
                                            @endif>Medium
                                        </option>
                                        <option value="low" @if($recentRequest->priority == 'low') selected
                                            @endif>Low
                                        </option>
                                    </select>
                                </td>

                            </tr>

                            <tr>

                                <td>Select Equipment</td>

                                <td class="view-td">{{$recentRequest->selected_equipment ??'N/A' }}</td>

                            </tr>

                        </tbody>

                    </table>

                </div>



                @else

                <!-- <div class="search-container">
                <input type="text" class="form-control" placeholder="Search..." wire:model="searchEmp"
                wire:input="filter">
                </div> -->
                @if($recentDetails && $recentDetails->where('status_code', '8')->count() > 0)

                <div class="scrollable-container">
                    <div class="req-pro-card">

                        @foreach ($recentDetails->where('status_code', '8') as $index => $request)

                        <div class="request-card">

                            <div class="req-pro-card-body">

                                <div>

                                    <p class="req-reqBy-Dep">Request ID:
                                        <span class="req-res-depart1">
                                            {{ $request->request_id }}

                                        </span>
                                    </p>

                                    <p class="req-reqBy-Dep">Requested By:
                                        <span class="req-res-depart1">
                                            {{ $request->emp->first_name }}
                                            {{ $request->emp->last_name }}
                                        </span>
                                    </p>

                                    <p title="{{ $request['category'] }}" class="req-reqBy-ser">
                                        Category <span class="req-res-depart">{{ $request->category ?? 'N/A' }}</span>
                                    </p>

                                </div>

                                <div class="p-2">
                                    <button wire:click="viewApproveDetails({{ $index }})"
                                        class="req-pro-view-details-btn" @if($loading) disabled @endif>View</button>

                                    <button wire:click="approveStatus('{{ $request->id }}')" class="req-pro-approve-btn"
                                        @if($loading) disabled @endif>Approve</button>

                                    <button wire:click="rejectionModal('{{ $request->id }}')"
                                        class="req-pro-approve-btn" @if($loading) disabled @endif>Reject</button>


                                </div>


                            </div>

                        </div>

                        @endforeach

                    </div>
                </div>

                @else
                <div class="req-requestnotfound">
                    <td colspan="20">

                        <div class="req-td-norecords">
                            <img src="{{ asset('images/Closed.webp') }}" alt="No Records" class="req-img-norecords">

                            <h3 class="req-head-norecords">No requests found
                            </h3>
                        </div>
                    </td>
                </div>
                @endif
                @endif




            </div>



            <div class="col-lg-2 col-md-5 col-xs-12 " style="margin-top:10% ;">

                <div class="req-pro-overview-container">

                    <div class="card text-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                        style="width: 85px; height: 85px; border-radius: 50%;  background-color: #02114f;">
                        <div class="text-center p-3">
                            <h5 class="card-title mb-2"> Total</h5>
                            <p class="card-text mb-0">

                                <span class="d-block mt-2 fs-4">
                                    <strong>{{$newRequestCount}}</strong>
                                </span>
                            </p>
                        </div>
                    </div>



                </div>
            </div>

            @endif

            @endif


            @if ($showRejectionModal)
            <div class="modal logout1" id="logoutModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-white logout2">
                            <h6 class="modal-title logout3" id="logoutModalLabel">Confirm Rejection</h6>
                        </div>
                        <div class="modal-body text-center logout4">
                            Are you sure you want to Reject?
                        </div>
                        <div class="modal-body text-center">
                            <form wire:submit.prevent="rejectStatus">
                                <span class="text-danger d-flex align-start">*</span>
                                <div class="row">
                                    <div class="col-12 req-remarks-div">
                                        <textarea wire:model.lazy="reason"
                                            class="form-control req-remarks-textarea logout5"
                                            placeholder="Reason for Rejection"></textarea>
                                    </div>
                                </div>
                                @error('reason')
                                <span class="text-danger d-flex align-start">{{ $message }}</span>
                                @enderror
                                <div class="d-flex justify-content-center p-3">
                                    <button type="submit" class="submit-btn mr-3">Reject</button>
                                    <button type="button" class="cancel-btn1 ml-3" wire:click="Cancel">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
            @endif



            @if ($showCancelModal)
            <div class="modal logout1" id="logoutModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-white logout2">
                            <h6 class="modal-title logout3" id="logoutModalLabel">Confirm Cancel</h6>
                        </div>
                        <div class="modal-body text-center logout4">
                            Are you sure you want to Cancel?
                        </div>
                        <div class="modal-body text-center">
                            <form wire:submit.prevent="cancelStatus">
                                <span class="text-danger d-flex align-start">*</span>
                                <div class="row">
                                    <div class="col-12 req-remarks-div">
                                        <textarea wire:model.lazy="reason"
                                            class="form-control req-remarks-textarea logout5"
                                            placeholder="Reason for Cancel"></textarea>
                                    </div>
                                </div>
                                @error('reason')
                                <span class="text-danger d-flex align-start">{{ $message }}</span>
                                @enderror
                                <div class="d-flex justify-content-center p-3">
                                    <button type="submit" class="submit-btn mr-3">Cancel Request</button>
                                    <button type="button" class="cancel-btn1 ml-3" wire:click="Cancel">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
            @endif

            <!-- Rejection details -->



            @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')))

            @if($viewRejectedRequests)
            <div class="col-lg-9 col-md-10 col-xs-12" style="margin-left: 4%;">

                <div class="d-flex  justify-content-between mb-4">
                    <div>
                        <h3 class="d-flex justify-content-start mb-5">Rejected Requests</h3>

                    </div>
                    <div>
                        <button class="btn btn-success" style="background-color: #02114f;color:white"
                            wire:click="showRecentRequest">Recent Requests</button>
                    </div>

                </div>

                @if($rejectedrequestDetails && $rejectedRequest)

                @if($rejectedrequestDetails)
                <button class="btn text-white float:right mb-3" style="background-color: #02114f;"
                    wire:click="closeRejectDetails" @if($loading) disabled @endif>
                    <i class="fas fa-arrow-left"></i> Back
                </button>
                @endif
                <div class="req-pro-tablediv">

                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-2">View Details</h5>

                    </div>

                    <table class="table table-bordered mt-3 req-pro-table">



                        <tbody>
                            <tr>

                                <td>Request ID</td>

                                <td class="view-td">{{$rejectedRequest->request_id ?? 'N/A' }}</td>

                            </tr>


                            <tr>

                                <td>Requested By</td>

                                <td class="view-td">{{$rejectedRequest->emp->first_name }}
                                    {{$rejectedRequest->emp->last_name }}
                                </td>

                            </tr>

                            <tr>

                                <td>Catologue Request</td>

                                <td class="view-td">{{$rejectedRequest->category ?? 'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Subject</td>

                                <td class="view-td">{{$rejectedRequest->subject??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Description</td>

                                <td class="view-td">{{$rejectedRequest->description ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Distributor</td>

                                <td class="view-td">{{$rejectedRequest->distributor_name ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Phone</td>

                                <td class="view-td">{{$rejectedRequest->mobile ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>MailBox</td>

                                <td class="view-td">{{$rejectedRequest->mail ??'N/A' }}</td>

                            </tr>

                            <tr>
                                <td>Attach Files</td>
                                <td class="view-td">
                                    @if($rejectedRequest->image_url)
                                    <a href="#" data-toggle="modal" class="requestAttachments"
                                        data-target="#attachmentsModal-{{ $rejectedRequest->id }}">
                                        <i class="fas fa-eye"></i> View Attachments
                                    </a>
                                    @else
                                    <span>-</span>
                                    @endif

                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="attachmentsModal-{{ $rejectedRequest->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="attachmentsModalLabel-{{ $rejectedRequest->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="attachmentsModalLabel-{{ $rejectedRequest->id }}">
                                                Attachments</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Swiper -->
                                            <div class="swiper-container">
                                                <div class="swiper-wrapper">

                                                    <div class="swiper-slide reqResSwiper">

                                                        <img src="{{ $rejectedRequest->image_url }}"
                                                            class="req-Res-Image" alt="Image">
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
                                            <button type="button" class="btn text-white"
                                                style="background-color: #02114f;" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <tr>

                                <td>CC To</td>

                                <td class="view-td">{{$rejectedRequest->cc_to ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Priority</td>

                                <td class="view-td">{{$rejectedRequest->priority ??'N/A' }}</td>

                            </tr>

                            <tr>

                                <td>Select Equipment</td>

                                <td class="view-td">{{$rejectedRequest->selected_equipment ??'N/A' }}</td>

                            </tr>

                        </tbody>

                    </table>

                </div>



                @else

                @if($rejectDetails->where('status_code', '3')->count() > 0)

                <div class="scrollable-container">
                    <div class="req-pro-card">

                        @foreach ($rejectDetails->where('status_code', '3') as $index => $request)

                        <div class="request-card">

                            <div class="req-pro-card-body">

                                <div>
                                    <p class="req-reqBy-Dep">Request ID:
                                        <span class="req-res-depart1">

                                            {{ $request->request_id }}

                                        </span>
                                    </p>

                                    <p class="req-reqBy-Dep">Requested By:
                                        <span class="req-res-depart1">
                                            {{ $request->emp->first_name }}
                                            {{ $request->emp->last_name }}
                                        </span>
                                    </p>

                                    <p title="{{ $request['category'] }}" class="req-reqBy-ser">
                                        Category <span class="req-res-depart">{{ $request->category ?? 'N/A' }}</span>
                                    </p>

                                </div>

                                <div class="p-3">
                                    <button wire:click="viewRejectDetails({{ $index }})"
                                        class="req-pro-view-details-btn" @if($loading) disabled @endif>View</button>
                                </div>


                            </div>

                        </div>

                        @endforeach

                    </div>
                </div>

                @else
                <div class="req-requestnotfound">
                    <td colspan="20">

                        <div class="req-td-norecords">
                            <img src="{{ asset('images/Closed.webp') }}" alt="No Records" class="req-img-norecords">

                            <h3 class="req-head-norecords">No requests found
                            </h3>
                        </div>
                    </td>
                </div>
                @endif
                @endif




            </div>



            <div class="col-lg-2 col-md-5 col-xs-12 " style="margin-top:10% ;">

                <div class="req-pro-overview-container">

                    <div class="card text-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                        style="width: 85px; height: 85px; border-radius: 50%;  background-color: #02114f;">
                        <div class="text-center p-3">
                            <h5 class="card-title mb-2"> Total</h5>
                            <p class="card-text mb-0">

                                <span class="d-block mt-2 fs-4">
                                    <strong>{{$newRejectionCount}}</strong>
                                </span>
                            </p>
                        </div>
                    </div>



                </div>
            </div>

            @endif

            @endif



            <!-- End rejection details -->





            @if($viewEmpRequest)

            <div class="col-lg-10 col-md-7 col-xs-12">
                <div class="req-pro-head">

                    <req-pro-nav class="req-pro-req-pro-nav mb-4">

                        <ul class="tabss">

                            <li class="tab text-white" wire:click="setActiveTab('active')">

                                <i class="fas fa-check"></i> Active

                                @if($activeTab === 'active')
                                <img class="req-active-tick"
                                    src="https://png.pngtree.com/png-vector/20221215/ourmid/pngtree-green-check-mark-png-image_6525691.png"
                                    alt="">
                                @endif
                            </li>

                            <li class="tab text-white" wire:click="setActiveTab('pending')">

                                <i class="fas fa-clock"></i> Pending

                                @if($activeTab === 'pending')
                                <img class="req-active-tick"
                                    src="https://png.pngtree.com/png-vector/20221215/ourmid/pngtree-green-check-mark-png-image_6525691.png"
                                    alt="">
                                @endif

                            </li>

                            <li class="tab text-white" wire:click="setActiveTab('inprogress')">

                                <i class="fas fa-clock"></i> Inprogress

                                @if($activeTab === 'inprogress')
                                <img class="req-active-tick"
                                    src="https://png.pngtree.com/png-vector/20221215/ourmid/pngtree-green-check-mark-png-image_6525691.png"
                                    alt="">
                                @endif

                            </li>

                            <li class="tab text-white" wire:click="setActiveTab('closed')">

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

                            <div
                                class="req-pro-details mb-5 ml-4 {{ auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')) ? '' : 'd-flex justify-content-center' }}">
                                <div>
                                    <h3 class=" headingForAllModules">Request Details</h3>
                                </div>

                                @if(auth()->check() && (auth()->user()->hasRole('admin') ||
                                auth()->user()->hasRole('super_admin')))
                                <div>
                                    <button class="btn" style="background-color: #02114f; color: white;"
                                        wire:click="showRecentRequest">Recent Requests</button>
                                </div>
                                @endif
                            </div>


                            @if($viewingDetails && $selectedRequest)

                            @if($viewingDetails)
                            <button class="btn text-white float:right mb-3" style="background-color: #02114f;"
                                wire:click="closeDetailsBack" @if($loading) disabled @endif>
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            @endif
                            <div class="req-pro-tablediv">

                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="m-2">View Details</h5>

                                </div>

                                <table class="table table-bordered mt-3 req-pro-table">



                                    <tbody>

                                        <tr>

                                            <td>Request ID</td>

                                            <td class="view-td">{{$selectedRequest->request_id ?? 'N/A' }}</td>

                                        </tr>


                                        <tr>

                                            <td>Requested By</td>

                                            <td class="view-td">{{$selectedRequest->emp->first_name }}
                                                {{$selectedRequest->emp->last_name }}
                                            </td>

                                        </tr>

                                        <tr>

                                            <td>Catologue Request</td>

                                            <td class="view-td">{{$selectedRequest->category ?? 'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Subject</td>

                                            <td class="view-td">{{$selectedRequest->subject??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Description</td>

                                            <td class="view-td">{{$selectedRequest->description ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Distributor</td>

                                            <td class="view-td">{{$selectedRequest->distributor_name ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Phone</td>

                                            <td class="view-td">{{$selectedRequest->mobile ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>MailBox</td>

                                            <td class="view-td">{{$selectedRequest->mail ??'N/A' }}</td>

                                        </tr>

                                        <tr>
                                            <td>Attach Files</td>
                                            <td class="view-td">
                                                @if($selectedRequest->image_url)
                                                <a href="#" data-toggle="modal" class="requestAttachments"
                                                    data-target="#attachmentsModal-{{ $selectedRequest->id }}">
                                                    <i class="fas fa-eye"></i> View Attachments
                                                </a>
                                                @else
                                                <span>-</span>
                                                @endif
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
                                                        <button type="button" class="btn text-white"
                                                            style="background-color: #02114f;"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <tr>

                                            <td>CC To</td>

                                            <td class="view-td">{{$selectedRequest->cc_to ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Priority</td>

                                            <td class="view-td">{{$selectedRequest->priority ??'N/A' }}</td>

                                        </tr>

                                        <tr>

                                            <td>Select Equipment</td>

                                            <td class="view-td">{{$selectedRequest->selected_equipment ??'N/A' }}</td>

                                        </tr>

                                        <tr>
                                            <td>Assign to <span class="text-danger">*</span></td>
                                            <td class="view-td">
                                                <select class="req-selected-status" wire:model="selectedAssigne"
                                                    wire:change="updateAssigne('{{ $selectedRequest->id }}')">
                                                    <option value="" disabled hidden>Select Assignee</option>
                                                    @foreach($itData as $itName)
                                                    <option
                                                        value="{{ $itName->empIt->first_name }} {{ $itName->empIt->last_name }} {{ $itName->empIt->emp_id }}">
                                                        {{ ucwords(strtolower($itName->empIt->first_name)) }}
                                                        {{ ucwords(strtolower($itName->empIt->last_name)) }}
                                                        {{ ucwords(strtolower($itName->empIt->emp_id)) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('selectedAssigne') <span
                                                    class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </td>

                                        </tr>

                                        <tr>
                                            <td>Status <span class="text-danger">*</span></td>

                                            <td class="view-td">
                                                <select wire:model="selectedStatus" class="req-selected-status"
                                                    wire:change="handleStatusChange('{{ $selectedRequest->id }}')">
                                                    <option value="" disabled hidden>Select Status </option>
                                                    <option value="5">Pending</option>
                                                    <option value="16">Inprogress</option>
                                                    <option value="11">Completed</option>
                                                    <option value="15">Cancel</option>
                                                    <!-- Add other status options as needed -->
                                                </select>
                                                @error('selectedStatus') <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </td>
                                        </tr>


                                        @if($showPendingModal)
                                        <div class="modal fade show d-block" tabindex="-1" role="dialog"
                                            style="background-color: rgba(0, 0, 0, 0.5);">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <!-- Added modal-dialog-centered for vertical centering -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reason for Pending Status</h5>
                                                        <button type="button" class="btn-close"
                                                            wire:click="closePendingModal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body flex-column">
                                                        <label for="pendingReason" class="form-label">Reason <span
                                                                class="text-danger">*</span></label>
                                                        <textarea id="pendingReason" class="form-control"
                                                            wire:model.defer="pendingReason" rows="3"></textarea>
                                                        @error('pendingReason')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            wire:click="closePendingModal">Close</button>
                                                        <button type="button" class="btn btn-primary"
                                                            wire:click="submitPendingReason">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif



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
                                                            <button class="btn text-white"
                                                                style="background-color: #02114f;"
                                                                wire:click="postComment('{{ $selectedRequest->id }}')"
                                                                @if($loading) disabled @endif>Post</button>
                                                        </div>
                                                    </div>


                                                </div>
                                            </td>
                                        </tr>





                                    </tbody>

                                </table>

                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn text-white mb-3" style="background-color: #02114f;"
                                        wire:click="redirectBasedOnStatus" @if($loading) disabled @endif>Submit</button>
                                </div>


                            </div>



                            @else

                            @if($forIT->where('status_code', '10')->count() > 0)
                            <div class="scrollable-container">
                                <div class="req-pro-card">

                                    @foreach ($forIT->where('status_code', '10') as $index => $request)

                                    <div class="request-card">

                                        <div class="req-pro-card-body">

                                            <div>

                                                <p class="req-reqBy-Dep">Request ID:
                                                    <span class="req-res-depart1">
                                                        {{ $request->request_id }}

                                                    </span>
                                                </p>

                                                <p class="req-reqBy-Dep">Requested By:
                                                    <span class="req-res-depart1">
                                                        {{ $request->emp->first_name }}
                                                        {{ $request->emp->last_name }}
                                                    </span>
                                                </p>

                                                <p title="{{ $request['category'] }}" class="req-reqBy-ser">
                                                    Category <span
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
                                <td colspan="20">

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
                                    Pending Requests</h3>
                            </div>

                            <div class="row ">

                                <div class="col-12 mt-2">

                                    <div class="table-responsive req-table-res">

                                        <table class="custom-table">
                                            @if($forIT->where('status_code', '5')->count() > 0)
                                            <thead>

                                                <tr>

                                                    <th scope="col" class="req-table-head">Employee ID
                                                        <span wire:click.debounce.500ms="toggleSortOrder('emp_id')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'emp_id')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Requested By

                                                    </th>

                                                    <th class="req-table-head">Catologue Request
                                                        <span wire:click.debounce.500ms="toggleSortOrder('category')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'category')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Subject
                                                        <span wire:click.debounce.500ms="toggleSortOrder('subject')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'subject')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Description</th>

                                                    <th class="req-table-head">Distributor
                                                        <span
                                                            wire:click.debounce.500ms="toggleSortOrder('distributor_name')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'distributor_name')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Phone
                                                        <span wire:click.debounce.500ms="toggleSortOrder('mobile')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'mobile')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">MailBox
                                                        <span wire:click.debounce.500ms="toggleSortOrder('mail')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'mail')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Attach Files</th>



                                                    <th class="req-table-head">Priority
                                                        <span wire:click.debounce.500ms="toggleSortOrder('priority')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'priority')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Select Equipment
                                                        <span
                                                            wire:click.debounce.500ms="toggleSortOrder('selected_equipment')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'selected_equipment')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Status

                                                    </th>

                                                    <th class="req-table-head">Assigned to
                                                        <span wire:click.debounce.500ms="toggleSortOrder('assign_to')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'assign_to')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>


                                                    <th class="req-table-head-Remarks">
                                                        Remarks</th>
                                                    <th class="req-table-head">Change Status</th>

                                                    <th class="req-table-head">Logs</th>

                                                </tr>

                                            </thead>
                                            @endif
                                            <tbody>

                                                @if($forIT->where('status_code', '5')->count() > 0)
                                                @foreach ($forIT->where('status_code', '5') as $index =>$record)
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


                                                    <td class="view-td">
                                                        @if($record->image_url)
                                                        <a href="#" data-toggle="modal" class="requestAttachments"
                                                            data-target="#attachmentsModal-{{ $record->id }}">
                                                            <i class="fas fa-eye"></i> View Attachments
                                                        </a>
                                                        @else
                                                        <span>-</span>
                                                        @endif

                                                    </td>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="attachmentsModal-{{ $record->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="attachmentsModalLabel-{{ $record->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="attachmentsModalLabel-{{ $record->id }}">
                                                                        Attachments</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">

                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Swiper -->
                                                                    <div class="swiper-container">
                                                                        <div class="swiper-wrapper">

                                                                            <div class="swiper-slide reqResSwiper">

                                                                                <img src="{{ $record->image_url }}"
                                                                                    class="req-Res-Image" alt="Image">
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
                                                                    <button type="button" class="btn text-white"
                                                                        style="background-color: #02114f;"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <td>{{ $record->priority?? 'N/A' }}</td>

                                                    <td>{{ $record->selected_equipment?? 'N/A' }}</td>

                                                    <td>
                                                        <div class="req-status">
                                                            @if($record->status_code == 5) Pending

                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>{{ $record['assign_to'] }}</td>







                                                    <td>
                                                        <form
                                                            wire:submit.prevent="postPendingRemarks('{{ $record->id }}')">
                                                            <div class="row">
                                                                <div class="col-12 d-flex align-items-center">
                                                                    <!-- Textarea takes most of the width -->
                                                                    <textarea
                                                                        wire:model.lazy="remarks.{{ $record->id }}"
                                                                        class="form-control me-2 req-remarks-textarea"
                                                                        style="flex-grow: 1;"></textarea>

                                                                    <!-- Button is small and aligned to the right -->
                                                                    <button type="submit"
                                                                        style="background-color: #02114f;"
                                                                        class="btn text-white p-2"
                                                                        style="height: fit-content;" @if($loading ||
                                                                        empty($remarks[$record->id]))
                                                                        disabled @endif>Post</button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </td>
                                                    <td>
                                                        <button wire:click="inprogressForDesks('{{ $record->id }}')"
                                                            class="btn btn-white border-black text-black" @if($loading)
                                                            disabled @endif>Inprogress</button>
                                                    </td>
                                                    <td>
                                                        <i wire:click="loadLogs('{{ $record->request_id }}')"
                                                            class="fas fa-clock-rotate-left"
                                                            style="cursor: pointer; padding: 8px;background-color: #4A90E2;border-radius: 20px;color:white;"></i>
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



                        <div id="inprogress" class="req-pro-tab-content"
                            style="display: {{ $activeTab === 'inprogress' ? 'block' : 'none' }};">

                            <div>
                                <h3 class="req-inprogress-heading">
                                    In Progress Requests</h3>
                            </div>

                            <div class="row ">

                                <div class="col-12 mt-2">

                                    <div class="table-responsive req-table-res">

                                        <table class="custom-table">
                                            @if($forIT->where('status_code', '16')->count() > 0)
                                            <thead>

                                                <tr>

                                                    <th scope="col" class="req-table-head">Employee ID
                                                        <span wire:click.debounce.500ms="toggleSortOrder('emp_id')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'emp_id')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Requested By

                                                    </th>

                                                    <th class="req-table-head">Catologue Request
                                                        <span wire:click.debounce.500ms="toggleSortOrder('category')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'category')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Subject
                                                        <span wire:click.debounce.500ms="toggleSortOrder('subject')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'subject')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Description</th>

                                                    <th class="req-table-head">Distributor
                                                        <span
                                                            wire:click.debounce.500ms="toggleSortOrder('distributor_name')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'distributor_name')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Phone
                                                        <span wire:click.debounce.500ms="toggleSortOrder('mobile')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'mobile')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">MailBox
                                                        <span wire:click.debounce.500ms="toggleSortOrder('mail')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'mail')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Attach Files</th>



                                                    <th class="req-table-head">Priority
                                                        <span wire:click.debounce.500ms="toggleSortOrder('priority')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'priority')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Select Equipment
                                                        <span
                                                            wire:click.debounce.500ms="toggleSortOrder('selected_equipment')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'selected_equipment')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head">Status

                                                    </th>

                                                    <th class="req-table-head">Assigned to
                                                        <span wire:click.debounce.500ms="toggleSortOrder('assign_to')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'assign_to')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-table-head-Remarks">
                                                        Remarks</th>
                                                    <th class="req-table-head">Time tracker</th>
                                                    <th class="req-table-head">Change Status</th>
                                                    <th class="req-table-head">Logs</th>

                                                </tr>

                                            </thead>
                                            @endif
                                            <tbody>

                                                @if($forIT->where('status_code', '16')->count() > 0)
                                                @foreach ($forIT->where('status_code', '16') as $index =>$record)
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


                                                    <td class="view-td">
                                                        @if($record->image_url)
                                                        <a href="#" data-toggle="modal" class="requestAttachments"
                                                            data-target="#attachmentsModal-{{ $record->id }}">
                                                            <i class="fas fa-eye"></i> View Attachments
                                                        </a>
                                                        @else
                                                        <span>-</span>
                                                        @endif

                                                    </td>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="attachmentsModal-{{ $record->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="attachmentsModalLabel-{{ $record->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="attachmentsModalLabel-{{ $record->id }}">
                                                                        Attachments</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">

                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Swiper -->
                                                                    <div class="swiper-container">
                                                                        <div class="swiper-wrapper">

                                                                            <div class="swiper-slide reqResSwiper">

                                                                                <img src="{{ $record->image_url }}"
                                                                                    class="req-Res-Image" alt="Image">
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
                                                                    <button type="button" class="btn text-white"
                                                                        style="background-color: #02114f;"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <td>{{ $record->priority?? 'N/A' }}</td>

                                                    <td>{{ $record->selected_equipment?? 'N/A' }}</td>

                                                    <td>
                                                        <div class="req-status"> @if($record->status_code == 16)
                                                            Inprogress

                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>{{ $record['assign_to'] }}</td>



                                                    <td>
                                                        <form
                                                            wire:submit.prevent="postInprogressRemarks('{{ $record->id }}')">
                                                            <div class="row">
                                                                <div class="col-12 d-flex align-items-center">
                                                                    <!-- Textarea takes most of the width -->
                                                                    <textarea
                                                                        wire:model.lazy="remarks.{{ $record->id }}"
                                                                        class="form-control me-2 req-remarks-textarea"
                                                                        style="flex-grow: 1;"></textarea>

                                                                    <!-- Button is small and aligned to the right -->
                                                                    <button type="submit"
                                                                        style="background-color: #02114f;"
                                                                        class="btn text-white p-2"
                                                                        style="height: fit-content;" @if($loading ||
                                                                        empty($remarks[$record->id]))
                                                                        disabled @endif>Post</button>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </td>

                                                    <td>

                                                        <div class="req-timebar">


                                                            @if($record->status_code == '16' &&
                                                            $record->in_progress_since)
                                                            @php

                                                            $totalElapsedMinutes =
                                                            \Carbon\Carbon::parse($record->in_progress_since)->diffInMinutes(now());

                                                            if (isset($record->total_in_progress_time)) {
                                                            $totalElapsedMinutes += $record->total_in_progress_time;
                                                            }

                                                            $days = floor($totalElapsedMinutes / 1440);
                                                            $remainingHours = floor(($totalElapsedMinutes % 1440) / 60);
                                                            $minutes = $totalElapsedMinutes % 60;


                                                            $maxTime = 7 * 1440;
                                                            $percentage = min(($totalElapsedMinutes / $maxTime) * 100,
                                                            100);


                                                            @endphp

                                                            <!-- Display elapsed time based on the total elapsed time -->
                                                            @if ($totalElapsedMinutes < 60) <span>{{ $minutes }}
                                                                minutes</span>
                                                                @elseif ($totalElapsedMinutes < 1440) <span>
                                                                    {{ $remainingHours }} hours {{ $minutes }}
                                                                    minutes</span>
                                                                    @else
                                                                    <span>{{ $days }} days {{ $remainingHours }} hours
                                                                        {{ $minutes }} minutes</span>
                                                                    @endif

                                                                    <!-- Custom Progress Bar -->
                                                                    <div class="custom-progress">
                                                                        <div class="custom-progress-bar"
                                                                            style="width: {{ $percentage }}%"
                                                                            aria-valuenow="{{ $percentage }}"
                                                                            aria-valuemin="0" aria-valuemax="100">
                                                                            <span
                                                                                class="progress-text">{{ round($percentage) }}%</span>
                                                                        </div>
                                                                    </div>

                                                                    @else
                                                                    <span>No time tracked</span>
                                                                    @endif

                                                        </div>
                                                    </td>

                                                    <td style="white-space: nowrap;">
                                                        <button wire:click="pendingForDesks('{{$record->id}}')"
                                                            class="btn btn-white border-black text-black" @if($loading)
                                                            disabled @endif>Pending </button>

                                                        <button wire:click="openForDesks('{{$record->id}}')"
                                                            class="btn btn-white border-black text-black" @if($loading)
                                                            disabled @endif>Close </button>
                                                    </td>

                                                    <td>
                                                        <i wire:click="loadLogs('{{ $record->request_id }}')"
                                                            class="fas fa-clock-rotate-left"
                                                            style="cursor: pointer; padding: 8px;background-color: #4A90E2;border-radius: 20px;color:white;"></i>
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
                                            @if($forIT->whereIn('status_code', ['11', '15'])->count() > 0)
                                            <thead>

                                                <tr>

                                                    <th scope="col" class="req-closed-th">Employee ID
                                                        <span wire:click.debounce.500ms="toggleSortOrder('emp_id')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'emp_id')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>

                                                    <th class="req-closed-th">Requested By</th>

                                                    <th class="req-closed-th">Catologue Request
                                                        <span wire:click.debounce.500ms="toggleSortOrder('category')"
                                                            style="cursor: pointer;">
                                                            @if($sortColumn == 'category')
                                                            <i
                                                                class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                                            @else
                                                            <i class="fas fa-sort"></i>
                                                            @endif
                                                        </span>
                                                    </th>
                                                    <th class="req-closed-th">Status</th>
                                                    <th class="req-closed-th">View</th>
                                                    <th class="req-closed-th">Logs</th>

                                                </tr>

                                            </thead>
                                            @endif
                                            <tbody>

                                                @if($forIT->whereIn('status_code', ['11', '15'])->count() > 0)
                                                @foreach ($forIT as $record)
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
                                                    <td>
                                                        <div class="req-status-closed
                                                @if($record['status_code'] == 11)
                                                    status-completed
                                                @elseif($record['status_code'] == 15)
                                                    status-cancelled
                                                @else
                                                    status-default
                                                @endif">
                                                            {{
                                                    $record['status_code'] == 11 ? 'Completed' :
                                                    ($record['status_code'] == 15 ? 'Cancelled' : 'N/A')
                                                }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <button class="btn"
                                                            style="background-color: #02114f;color:white"
                                                            wire:click="viewRecord({{ $record->id }})">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>

                                                    <td>
                                                        <i wire:click="loadLogs('{{ $record->request_id }}')"
                                                            class="fas fa-clock-rotate-left"
                                                            style="cursor: pointer; padding: 8px;background-color: #4A90E2;border-radius: 20px;color:white;"></i>
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

                                        <!-- Modal for displaying record details -->
                                        @if($showModal)
                                        <div class="modal fade show" id="catologueModal" tabindex="-1" role="dialog"
                                            aria-labelledby="catologueModalLabel" style="display: block;"
                                            aria-hidden="false">

                                            <div class="modal-content" style="margin: 4% 0px;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="catologueModalLabel">Closed Request
                                                        Details
                                                    </h5>
                                                    <button type="button" class="close p-2" wire:click="closeModal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="service-details">
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Employee ID:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->emp_id ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Requested By:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>
                                                                    {{ $selectedRecord->emp->first_name ?? 'N/A' }}
                                                                    {{ $selectedRecord->emp->last_name ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Catologue Request:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->category ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Subject:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->subject ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Description:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->description ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Distributor:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->distributor_name ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Phone:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->mobile ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>MailBox:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->mail ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Priority:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->priority ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Selected Equipment:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->selected_equipment ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Status:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->status_code ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Assigned to:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->assign_to ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Comments:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->active_comment ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Remarks:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->inprogress_remarks ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>


                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>CC to:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->cc_to ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>



                                                        <!-- Display files if available -->
                                                        <div id="modalFiles" class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Attachments:</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                @if (isset($selectedRecord->file_path))
                                                                <!-- Button to trigger the modal -->
                                                                <button type="button" class="btn btn-link"
                                                                    data-toggle="modal" data-target="#attachmentsModal">
                                                                    View Attachments
                                                                </button>
                                                                @else
                                                                <p>No files attached.</p>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="modal fade stack-modal" id="attachmentsModal" tabindex="-1"
                                                            role="dialog" aria-labelledby="attachmentsModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                                <div class="modal-content"  style="border: 2px solid #02114f;">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="attachmentsModalLabel">Attachments
                                                                        </h5>
                                                                        <button type="button" class="close p-2"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @if (isset($selectedRecord->file_path))
                                                                        @php
                                                                        // Convert the BLOB data to base64
                                                                        $base64Image =
                                                                        base64_encode($selectedRecord->file_path);
                                                                        @endphp

                                                                        <!-- Render the BLOB image directly if it's base64 -->
                                                                        <div class="mb-3">
                                                                            <img src="data:image/jpeg;base64,{{ $base64Image }}"
                                                                                class="img-fluid" alt="Attachment" />
                                                                        </div>
                                                                        @else
                                                                        <p>No attachments available.</p>
                                                                        @endif
                                                                    </div>



                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong>Reason</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span>{{ $selectedRecord->rejection_reason ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="row service-detail-item">
                                                            <div class="col-6">
                                                                <strong></strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <span></span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        @endif
                                        @if($selectedRecord)
                                        <div class="modal-backdrop fade show"
                                            style="background-color: rgba(0, 0, 0, 0.7);"></div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-2 col-md-5 col-xs-12 ">

                <div class="row req-overview-main">
                    <div class="col-12">
                        <h5 class="mb-3 req-overview-head">
                            Overview</h5>
                    </div>

                </div>

                <div class="req-pro-overview-container">
                    <div class="req-pro-overview-card">

                        <div class="card text-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                            style="width: 85px; height: 85px; border-radius: 50%;  background-color: #02114f;">
                            <div class="text-center p-3">
                                <h5 class="card-title mb-2 mt-5" style="font-size: 12px;"> Open</h5>
                                <p class="card-text mb-0">

                                    <span class="d-block mt-2 fs-4">
                                        <strong>{{$activeCount}}</strong>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <i class="fas fa-arrow-down req-pro-arrow"></i>

                    </div>

                    <div class="req-pro-overview-card">

                        <div class="card text-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                            style="width:85px; height: 85px; border-radius: 50%;  background-color: #02114f;">
                            <div class="text-center p-3">
                                <h5 class="card-title mb-2  mt-5" style="font-size: 12px;"> Pending</h5>
                                <p class="card-text mb-0">

                                    <span class="d-block mt-2 fs-4">
                                        <strong>{{$pendingCount}}</strong>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <i class="fas fa-arrow-down req-pro-arrow"></i>

                    </div>

                    <div class="req-pro-overview-card">

                        <div class="card text-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                            style="width: 85px; height: 85px; border-radius: 50%;  background-color: #02114f;">
                            <div class="text-center p-3">
                                <h5 class="card-title mb-2  mt-5" style="font-size: 12px;"> Inprogress</h5>
                                <p class="card-text mb-0">

                                    <span class="d-block mt-2 fs-4">
                                        <strong>{{$inprogressCount}}</strong>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <i class="fas fa-arrow-down req-pro-arrow"></i>

                    </div>

                    <div class="req-pro-overview-card">

                        <div class="card text-white shadow-sm border-0 d-flex align-items-center justify-content-center"
                            style="width: 85px; height: 85px; border-radius: 50%;  background-color: #02114f;">
                            <div class="text-center p-3">
                                <h5 class="card-title mb-2  mt-5" style="font-size: 12px;"> Closed</h5>
                                <p class="card-text mb-0">

                                    <span class="d-block mt-2 fs-4">
                                        <strong>{{$closedCount}}</strong>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            @endif









            @if ($showPopup)
            @if ($activityLogs)
            <div class="popup-overlay">
                <div class="popup-content col-11 mx-auto">
                    <!-- Popup Header -->
                    <div class="popup-header d-flex justify-content-between align-items-center">
                        <h5 class="popup-title">Activity Logs -
                            @if ($catologueIDHeader)
                            <span style="color: #4A90E2;font-size: 12px;">{{ $catologueIDHeader }}</span>
                            <!-- Display the request ID of the first log -->
                            @else
                            <span>No Request ID</span> <!-- Fallback if no logs are present -->
                            @endif
                        </h5>
                        <button class="close-popup" wire:click="closePopup">×</button>
                    </div>

                    <!-- Popup Body -->
                    <div class="popup-body">
                        @if (is_countable($activityLogs) && count($activityLogs) > 0)

                        <!-- Header with Activity Count -->
                        <div class="activity-header d-flex justify-content-between mb-4">
                            <h5 class="text-lg font-semibold">Activities: {{ count($activityLogs) }}</h5>
                            <button wire:click="filterLogs('field-change')" class="filter-btn text-sm text-gray-500">
                                <i class="fas fa-filter"></i> Filter by Field Change
                            </button>

                        </div>

                        <!-- Activity Log Entries -->
                        <div class="d-flex flex-column">
                            @foreach ($activityLogs as $index => $log)
                            <div class="activity-entry bg-white p-4 rounded-lg shadow-md mb-4">
                                <div class="log-header d-flex justify-content-between align-items-center">
                                    <div class="log-user d-flex align-items-center">
                                        <!-- Display initials -->
                                        <span class="initials text-lg font-bold">
                                            {{ $employeeInitials[$index] ?? '' }}
                                        </span>
                                        <span class="user-name ms-4 text-sm text-gray-600">
                                            {{ ucwords(strtolower( $log->performed_by ?? 'Unknown')) }}
                                        </span>
                                    </div>
                                    <div class="timestamp text-sm text-gray-500">
                                        Field changes <span style="font-size: 15px;">&#8226;</span>
                                        {{ $log->created_at ? $log->created_at->format('d-m-Y H:i:s') : 'N/A' }}
                                    </div>
                                </div>

                                <!-- Log Details -->
                                <div class="log-details mt-2">
                                    @if ($log->action && $log->details)
                                    <div class="log-action text-sm text-gray-800 d-flex">
                                        <div class="log-label" style="width: 150px; font-weight: bold;">
                                            {{ $log->action }}
                                        </div>
                                        <div class="log-value" style="width: calc(100% - 150px);">
                                            {{ $log->details }}
                                        </div>
                                    </div>
                                    @endif
                                    @if ($log->assigned_to)
                                    <div class="log-sub-details mt-2 text-sm">
                                        <div class="log-label" style="width: 150px; font-weight: bold;">Assigned to
                                        </div>
                                        <div class="log-value" style="width: calc(100% - 150px);">
                                            {{ $log->assigned_to }}
                                        </div>
                                    </div>
                                    @endif

                                    @if ($log->impact)
                                    <div class="log-sub-details mt-2 text-sm">
                                        <div class="log-label" style="width: 150px; font-weight: bold;">Impact</div>
                                        <div class="log-value" style="width: calc(100% - 150px);">
                                            {{ $log->impact }}
                                        </div>
                                    </div>
                                    @endif

                                    @if ($log->opened_by)
                                    <div class="log-sub-details mt-2 text-sm">
                                        <div class="log-label" style="width: 150px; font-weight: bold;">Opened by</div>
                                        <div class="log-value" style="width: calc(100% - 150px);">
                                            {{ $log->opened_by }}
                                        </div>
                                    </div>
                                    @endif

                                    @if ($log->priority)
                                    <div class="log-sub-details mt-2 text-sm">
                                        <div class="log-label" style="width: 150px; font-weight: bold;">Priority</div>
                                        <div class="log-value" style="width: calc(100% - 150px);">
                                            {{ $log->priority }}
                                        </div>
                                    </div>
                                    @endif

                                    @if ($log->state)
                                    <div class="log-sub-details mt-2 text-sm">
                                        <div class="log-label" style="width: 150px; font-weight: bold;">State</div>
                                        <div class="log-value" style="width: calc(100% - 150px);">
                                            {{ $log->state }}
                                        </div>
                                    </div>
                                    @endif
                                    <!-- Add more log details as needed -->
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-gray-500">No activity logs found.</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endif

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
