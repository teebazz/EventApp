<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\User;
use App\Models\Citizen;
use App\Models\Collection;
use App\Traits\MessageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    use MessageTrait;
    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $total_attendees = Attendee::count();
        $verified_attendees = Attendee::where(['status' => 'verified'])->count();
        $unverified_attendees = Attendee::where(['status' => 'pending'])->count();
        $data['stats'] = [
            'total_attendees' => $total_attendees,
            'verified_attendees' => $verified_attendees,
            'unverified_attendees' => $unverified_attendees,
        ];
        return view('dashboard', $data);
    }
    
    public function attendees()
    {
        $data['title'] = 'Attendees';
        $data['attendees'] = Attendee::orderBy('id','DESC')->get();
        return view('attendees', $data);
    }

    public function createAttendee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:attendees,email,'.$request->id,
            'phone_number' => 'required|unique:attendees,phone_number,'.$request->id,
            'no_of_admission' => 'required',            
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(!empty($request->id)){
            $attendee = Attendee::where(['id' => $request->id])->first();
            $attendee->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'no_of_admission' => $request->no_of_admission,
            ]);
            Alert::success('Success', 'Attendee Updated');
            return redirect()->back();
        } else {
            DB::beginTransaction();
            $attendee = Attendee::create([
                'reference' => 'INV-'.rand(100000,999999).'-'.date('YmdHis'),
                'code' => rand(100000,999999),
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'no_of_admission' => $request->no_of_admission,
            ]);

            $this->sendMail($attendee);
            $this->sendSMS($attendee);
            DB::commit();
            Alert::success('Success', 'Attendee Created');
            return redirect()->back();
        }
    }

    public function viewInvite($reference)
    {
        $data['title'] = 'Invite';
        $data['attendee'] = Attendee::where(['reference' => $reference])->first();
        return view('invites.temp1', $data);
    }
    
    public function deleteInvite($reference)
    {
        $attendee = Attendee::where(['reference' => $reference])->first();
        $attendee->delete();
        Alert::success('Success', 'Invite Deleted');
        return redirect()->back();
    }
    
    public function resendnvite($reference)
    {
        $attendee = Attendee::where(['reference' => $reference])->firstOrFail();
        $this->sendMail($attendee);
        $this->sendSMS($attendee);
        Alert::success('Success', 'Invite Resent');
        return redirect()->back();
    }
    
    public function verifyDetail($reference)
    {
        $data['title'] = 'Invite';
        $data['attendee'] = Attendee::where(['reference' => $reference])->first();
        $data['title'] = 'Verify - '.$data['attendee']->code;
        return view('verify', $data);   
    }

    public function verifyAttendee($reference)
    {
        $attendee = Attendee::where(['reference' => $reference])->firstOrFail();
        $attendee->update([
            'status' => 'verified',
        ]);
        Alert::success('Success', 'Attendee Verified');
        return redirect()->back();
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric|exists:attendees,code',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $attendee = Attendee::where(['code' => $request->code])->first();
        return redirect()->route('verify_details', ['reference' => $attendee->reference]);     
    }

    public function users()
    {
        $data['title'] = 'Users';
        $data['users'] = User::orderBy('created_at', 'desc')->get();
        $data['roles'] = Role::pluck('name','id');
        return view('admins', $data);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'role_id' => 'required',
            'email' => 'required|unique:users,email,'.$request->id,
            'phone_number' => 'required|unique:users,phone_number,'.$request->id,
        ]);
        if($validator->fails()){
            Alert::error('Alert', $validator->errors()->first());
            return redirect()->back();
        }
        $role = Role::find($request->role_id);
        if(!empty($request->id)){
            //
            $user = User::where(['id' => $request->id])->first();
            $user->syncRoles($role);
            $userUpdate = User::where(['id' => $request->id])->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);
            Alert::success('Alert', 'Admim Profile Updated');
            return redirect()->back();
        }else{
            $createUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make('123456'),
            ]);
            $createUser->assignRole($role);
            Alert::success('Alert', 'Admim Profile Created');
            return redirect()->back();
        }
    }

    public function permissions()
    {
        $data['title'] = 'Permissions';
        $roles = Role::where('name','!=','Member')->get();
        $dx = [];
        foreach ($roles as $key => $value) {
            $d['id'] = $value->id;
            $d['name'] = $value->name;
            $d['permissions'] = (!empty($value->permissions)) ? $value->permissions->pluck('name')->toArray() : [];
            $dx[] = $d;
        }
        $data['roles'] = $dx;
        $data['permissions'] = Permission::all();
        return view('permissions',$data);
    }

    public function updatePermission(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'role_perms' => 'required'
        ]);
        if($validator->fails()){
            Alert::error('Alert', $this->formatValidationErrors($validator));
            return redirect()->back();
        }
        $role = Role::find($id);
        $role->syncPermissions($request->role_perms);
        Alert::success('Alert', 'Permission Updated');
        return redirect()->back();
    }
}
