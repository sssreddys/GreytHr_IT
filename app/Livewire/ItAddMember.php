<?php

namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Models\EmployeeDetails;
use Livewire\Component;
use App\Models\IT;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ItAddMember extends Component
{
    public $itmember = true;
    public $addItmember = false;
    public $itRelatedEmye = [];
    public $assetSelectEmp = [];
    public $empDetails = null;
    public $selectedEmployee = null;
    public $searchFilters = true;
    public $searchEmp = '';
    public $searchAssetId = '';
    public $assetsFound = false;
    public $showLogoutModal = false;
    public $filteredEmployeeAssets = [];
    public $reason = [];

    protected function rules()
    {
        return [

            'selectedEmployee' => 'required|string|max:255',
        ];
    }

    protected $messages = [
        'selectedEmployee.required' => 'Employee ID is required.',
    ];

    public function addMember()
    {
        $this->resetForm();
        $this->empDetails = null;
        $this->addItmember = true;
        $this->itmember = false;
        $this->searchFilters = false;
        $this->resetErrorBag('selectedEmployee');
    }

    public function Cancel()
    {
        $this->addItmember = false;
        $this->showLogoutModal = false;
        $this->itmember = true;
        $this->empDetails = null;
        $this->searchFilters = true;
        $this->resetErrorBag('selectedEmployee');
    }

    public $sortColumn = 'emp_id'; // default sorting column
    public $sortDirection = 'asc'; // default sorting direction

    public function toggleSortOrder($column)
    {
        if ($this->sortColumn == $column) {
            // If the column is the same, toggle the sort direction
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // If a different column is clicked, set it as the new sort column and default to ascending order
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function fetchEmployeeDetails()
    {

        if ($this->selectedEmployee !== "" && $this->selectedEmployee !== null) {
            $this->empDetails = EmployeeDetails::find($this->selectedEmployee);
            $this->resetErrorBag('selectedEmployee');
        } else {

            $this->empDetails = null;
        }
    }


    public function mount()
    {

        $this->loadAssetsAndEmployees();
    }

    public function loadAssetsAndEmployees()
    {
        $this->assetSelectEmp = EmployeeDetails::where('sub_dept_id', '9915')
            ->where('dept_id', '8803')
            ->orderBy('first_name', 'asc')->get();
    }

    private function resetForm()
    {
        $this->selectedEmployee = null;
    }


    public function cancelLogout()
    {
        $this->showLogoutModal = true;
    }

    public $recordId;
    public function confirmDelete($id)
    {

        $this->recordId = $id; // Assign the ID first
        $this->showLogoutModal = true; // Show the modal after assigning the ID
    }


    public function delete()
    {
        $this->validate([

            'reason' => 'required|string|max:255', // Validate the remark input
        ], [
            'reason.required' => 'Reason is required.',
        ]);
        // $this->resetErrorBag();
        $itMember = IT::find($this->recordId);

        if ($itMember) {
            $itMember->update([
                'delete_itmember_reason' => $this->reason,
                'status' => 0
            ]);


            FlashMessageHelper::flashSuccess("IT member deactivated successfully!");
            $this->showLogoutModal = false;
            $this->itRelatedEmye = IT::where('status', 1)->get();
            // Reset the recordId and reason after processing
            $this->recordId = null;
            $this->reason = '';
        }
    }





    public function submit()
    {
        $this->validate();
        try {

            // Attempt to create a new IT record
            IT::create([
                'emp_id' => $this->empDetails->emp_id,
                'employee_name' => $this->empDetails->first_name . ' ' . $this->empDetails->last_name,
                'email' => $this->empDetails->email,
                'password' => bcrypt('ags@123'),

            ]);

            // Flash success message if everything works
            FlashMessageHelper::flashSuccess("IT member added successfully!");

            // Reset the form or any related state (if needed)
            $this->resetForm();
            return redirect()->route('itMembers');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error adding IT member: ' . $e->getMessage());
            // Flash an error message to the user
            FlashMessageHelper::flashError("There was an error adding the IT member. Please try again.");
        }
    }


    public function filter()
    {
        try {
            $trimmedEmpId = trim($this->searchEmp);
            // $trimmedAssetId = trim($this->searchAssetId);

            $this->filteredEmployeeAssets = IT::query()
                ->when($trimmedEmpId, function ($query) use ($trimmedEmpId) {
                    $query->where(function ($query) use ($trimmedEmpId) {
                        $query->where('emp_id', 'like', '%' . $trimmedEmpId . '%')
                            ->orWhere('it_emp_id', 'like', '%' . $trimmedEmpId . '%')
                            ->orWhere('employee_name', 'like', '%' . $trimmedEmpId . '%')
                            ->orWhere('email', 'like', '%' . $trimmedEmpId . '%');
                    });
                })
                ->get();

            $this->assetsFound = count($this->filteredEmployeeAssets) > 0;
        } catch (\Exception $e) {
            Log::error('Error in filter method: ' . $e->getMessage());
        }
    }



    public function clearFilters()
    {
        // Reset search fields and filtered results
        // $this->searchEmp = '';
        // $this->searchAssetId = '';
        $this->reset();
        $this->filteredEmployeeAssets = [];
        $this->assetsFound = false;
    }


    public function render()
    {
        $this->itRelatedEmye = !empty($this->filteredEmployeeAssets)
            ? $this->filteredEmployeeAssets
            : EmployeeDetails::with('its') // Eager load the empIt relationship
            ->whereHas('its', function ($query) {
                $query->whereColumn('employee_details.emp_id', 'i_t.emp_id'); // Correctly reference the columns
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->get();

        return view('livewire.it-add-member');
    }
}
