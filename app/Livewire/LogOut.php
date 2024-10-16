<?php
#/ livewire
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LogOut extends Component
{

    public $showLogoutModal = false;

    public function handleLogout()
    {
        $this->showLogoutModal = true;
    }
    public function confirmLogout()
    {
        // dump(Session::get('hr_emp_id'));
        // dump(Session::get('admin_emp_id'));
        // dump(Session::get('emp_id'));
        // dump(Session::get('fi_emp_id'));
        // dump(Session::get('it_emp_id'));
        // dd(Session::pull('emp_id'));

        //    if (auth()->guard('emp')->logout()) {
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     } elseif (auth()->guard('hr')->logout()) {
        //         dd('hello');
        //         dump(Session::get('hr_emp_id'));
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     } elseif (auth()->guard('it')->logout()) {
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     } elseif (auth()->guard('finance')->logout()) {
        //         Auth::logout();
        //         session()->forget('emp_id');
        //         session()->forget('admin_emp_id');
        //         session()->forget('fi_emp_id');
        //         session()->forget('hr_emp_id');
        //         session()->forget('it_emp_id');
        //         session()->forget('company_id');
        //         session()->flush();
        //         session_unset();
        //         session()->flash('success', "You are logged out successfully!");
        //     }
        //     //return redirect(route('emplogin'));

        try {
            // Logout the user from all guards
            Auth::logout();

            // Clear session data
            session()->flush();

            // Flash success message
            FlashMessageHelper::flashSuccess("You are logged out successfully!");
            // flash(
            //     message: 'You are logged out successfully!',
            //     type: 'success',
            //     options: (
            //         [
            //             'timeout' => 3000, // 3 seconds
            //             'position' => 'top-center',
            //         ]
            //     ),
            // );

            // flash()->addSuccess(
            //     'You are logged out successfully!',
            //     'success',

            //     [
            //         'timeout' => 3000, // 3 seconds
            //         'position' => 'top-center',
            //     ]

            // );

            // Redirect to the login page
            return redirect()->route('itlogin');
        } catch (\Exception $exception) {
            // Handle exceptions
            session()->flash('error', "An error occurred while logging out.");
            return redirect()->back(); // Redirect back with an error message
        }
    }
    public function cancelLogout()
    {
        $this->showLogoutModal = false;
    }

    public function render()
    {
        return view('livewire.logout');
    }
}
