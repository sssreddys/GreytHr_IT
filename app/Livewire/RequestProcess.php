<?php

namespace App\Livewire;

use App\Models\HelpDesks;
use App\Models\IT;
use Illuminate\Http\Client\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use function Termwind\render;

class RequestProcess extends Component
{
    public $activeTab = 'active';
    public $requests = [];
    public $viewingDetails = false;
    public $assignTo;
    public $comments;
    public $remarks =[];
    public $request;
    public $selectedRequest;
    public $showOverview = false;
    public $attachments;
    public $currentRequestId;
    public $activeCount;
    public $pendingCount;
    public $closedCount;
    public $file_path;




    protected $rules = [
        'request.assignTo' => 'required',
        'comments' => 'required',
        'request.status' => 'required',
        'remarks' => 'required',
        'selectedStatus' => 'required',
        'selectedAssigne' => 'required',
    ];


    public function setActiveTab($tab)
    {

        $this->activeTab = $tab;
        $this->viewingDetails = false;
        $this->selectedStatus = '';
        $this->selectedAssigne = '';
        $this->updateCounts();
    }

    public function mount()
    {
        $this->selectedStatus = '';
        $this->selectedAssigne = '';
        $this->updateCounts();
    }


    public function showAttachments($requestId)
    {
        $request = collect($this->requests)->firstWhere('id', $requestId);
        $this->attachments = explode(',', $request['attach_files']);
    }

    public function getInProgressRequestsProperty()
    {
        return array_filter($this->requests, function ($request) {

            return $request['status'] == 'inProgress';
        });
    }
    public function getClosedRequestsProperty()
    {
        return array_filter($this->requests, function ($request) {
            return $request['status'] == 'Completed';
        });
    }


    public function viewDetails($index)
    {
        $this->selectedRequest = $this->forIT->where('status', 'Open')->values()->get($index);
        $this->viewingDetails = true;
            if (!$this->selectedRequest) {
            abort(404, 'Request not found');
        }
        $this->currentRequestId = $this->selectedRequest->id;
        $file_path = $this->selectedRequest->file_path;

    }


    public function toggleOverview()
    {
        $this->showOverview = !$this->showOverview;
    }


    public function closeDetails()
    {
        $this->viewingDetails = false;
        $this->mount();
        // $this->selectedRequest = true;
    }

    public function redirectBasedOnStatus()
    {

        $this->validate([
            'selectedStatus' => 'required',

            'selectedAssigne' => 'required',
        ], [
            'selectedStatus.required' => 'Status is required.',
            'selectedAssigne.required' => 'Assign to is required.',
        ]);


        if ($this->selectedStatus === 'Pending') {

            $this->setActiveTab('pending');

        } elseif ($this->selectedStatus === 'Completed') {

            $this->setActiveTab('closed');

        }
        $this->reset(['selectedStatus', 'selectedAssigne']);
        $this->resetErrorBag();
        $this->updateCounts();
    }




    public function pendingForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Pending']);
            session()->flash('message', 'Status saved successfully');
        }
        $this->updateCounts();
    }


    public function openForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Completed']);
            session()->flash('message', 'Status Closed successfully');
        }
        $this->updateCounts();
    }
    public $error = '';
    public $loading = false;
    public function closeForDesks($taskId)
    {
        $this->loading = true;
        sleep(3);
        $task = HelpDesks::find($taskId);
        try {
        if ($task) {
            $task->update(['status' => 'Open']);
            session()->flash('message', 'Status Reopened successfully');
        }
    }catch (\Exception $e) {
        // Handle exception
        $this->error = "An unexpected error occurred. Please try again.";
    } finally {
        $this->loading = false;

    }
        $this->updateCounts();
    }


    public $selectedStatus;

    public function updateStatus($taskId)
    {
        $this->validateOnly('selectedStatus');
        $this->resetErrorBag('selectedStatus');
        $task = HelpDesks::find($taskId);

        if ($task && $this->selectedStatus) {
            $task->update(['status' => $this->selectedStatus]);
            if ($this->selectedStatus === 'Pending') {
                session()->flash('statusMessage', 'Status has been set to Pending');
            } elseif ($this->selectedStatus === 'Completed') {
                session()->flash('statusMessage', 'Status has been set to Completed');
            } else {
                session()->flash('statusMessage', 'Status Updated successfully');
            }
        }
    }


    public $selectedAssigne;


    public function updateAssigne($taskId)
    {
        $this->validateOnly('selectedAssigne');
        $this->resetErrorBag('selectedAssigne');

        $task = HelpDesks::find($taskId);

        if ($task  && $this->selectedAssigne) {
            $task->update(['assign_to' => $this->selectedAssigne]);
            // session()->flash('message', 'Status Reopened successfully');
        }
    }




    public function postComment($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task && $this->comments) {

            $task->update(['active_comment' => $this->comments]);
            session()->flash('commentMessage', 'Comment posted successfully');
        }
    }


    public function postRemarks($taskId)
    {
        $remarks = $this->remarks[$taskId] ?? '';
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['inprogress_remarks' => $remarks]);
            // $task->update(['inprogress_remarks' => $this->remarks]);
            session()->flash('message', 'Comment posted successfully');
        }
    }


    public function updateCounts()
    {
        $this->activeCount = HelpDesks::where('status', 'Open')
        ->whereIn('category', [
            'Distribution List Request', 'New Laptop', 'New Distribution Request',
            'New Mailbox Request', 'Desktop Request', ' Request For IT',
            'Devops Access Request', 'New ID Card', 'MMS Request', 'N/A'
        ])->count();

        $this->pendingCount = HelpDesks::where('status', 'Pending')
        ->whereIn('category', [
            'Distribution List Request', 'New Laptop', 'New Distribution Request',
            'New Mailbox Request', 'Desktop Request', ' Request For IT',
            'Devops Access Request', 'New ID Card', 'MMS Request', 'N/A'
        ])->count();

        $this->closedCount = HelpDesks::where('status', 'Completed')
        ->whereIn('category', [
            'Distribution List Request', 'New Laptop', 'New Distribution Request',
            'New Mailbox Request', 'Desktop Request', ' Request For IT',
            'Devops Access Request', 'New ID Card', 'MMS Request', 'N/A'
        ])->count();

    }



    public $forIT;
    public $itData;
    public function render()
    {

        $this->itData = IT::with('empIt')->get();

        $companyId = auth()->guard('it')->user()->company_id;
        $this->forIT = HelpDesks::with('emp')
            ->whereHas('emp', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->orderBy('created_at', 'desc')
            ->whereIn('category', [
                'Distribution List Request', 'New Laptop', 'New Distribution Request',
                'New Mailbox Request', 'Desktop Request', ' Request For IT',
                'Devops Access Request', 'New ID Card', 'MMS Request', 'N/A'
            ])
            ->get();



        if ($this->activeTab == 'active') {
            $this->forIT = HelpDesks::with('emp')
                ->where('status', 'Open')
                ->orderBy('created_at', 'desc')
                ->whereIn('category', [
                    'Distribution List Request', 'New Laptop', 'New Distribution Request',
                    'New Mailbox Request', 'Desktop Request', ' Request For IT',
                    'Devops Access Request', 'New ID Card', 'MMS Request', 'N/A'
                ])->get();

        } elseif ($this->activeTab == 'pending') {
            $this->forIT = HelpDesks::with('emp')
                ->where('status', 'Pending')
                ->orderBy('created_at', 'desc')
                ->whereIn('category', [
                    'Distribution List Request', 'New Laptop', 'New Distribution Request',
                    'New Mailbox Request', 'Desktop Request', ' Request For IT',
                    'Devops Access Request', 'New ID Card', 'MMS Request', 'N/A'
                ])->get();
        } elseif ($this->activeTab == 'closed') {
            $this->forIT = HelpDesks::with('emp')
                ->where('status', 'Completed')
                ->orderBy('created_at', 'desc')
                ->whereIn('category', [
                    'Distribution List Request', 'New Laptop', 'New Distribution Request',
                    'New Mailbox Request', 'Desktop Request', ' Request For IT',
                    'Devops Access Request', 'New ID Card', 'MMS Request', 'N/A'
                ])->get();
        }

        return view('livewire.request-process', [
            'activeCount' => $this->activeCount,
            'pendingCount' => $this->pendingCount,
            'closedCount' => $this->closedCount,
            'ClosedRequests' => $this->ClosedRequests,
            'inProgressRequests' => $this->inProgressRequests,
            'viewingDetails' => $this->viewingDetails,
            'requests' => $this->requests,
            'activeTab' => $this->activeTab,


        ]);

    }
}