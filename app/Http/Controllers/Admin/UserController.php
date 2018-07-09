<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\User_Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Validator;
use Image;
use Input;

class UserController extends BaseController
{
    /**
     * Responds to requests to GET /users
     */
    public function __construct() 
    {
        parent::__construct();
    } 
    /**
     * Responds to requests to GET /users
     */
    public function index()
    {
        //
        switch(true){
            case $this->shareddata['current_user']->hasRole('Admin'):
                $data["users"] = User::all();
            break;
            case $this->shareddata['current_user']->hasRole('Agency'):
                $data["users"] = User::where('parent',$this->shareddata['current_user']->id)->get();
            break;
            case $this->shareddata['current_user']->hasRole('Agent'):
                $data["users"] = "";
            break;

            default:
                $data["users"] = "";
            break;

        }
        return view('admin.users.list', $data);
    }

    public function add()
    {
        $data["users_forparent"] = DB::table('users')
                                    ->leftJoin('user_role', 'users.id', '=', 'user_role.user_id')
                                    ->select('users.id','users.name','users.email')
                                    ->whereIn('user_role.role_id',[3,4])
                                    ->get();

        return view('admin.users.add',$data);
    }

    protected function postadd(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'address' => 'required|max:255',
            'phone' => 'required|max:100',
            'officephone' => 'max:100',
            'fax' => 'max:100',
            'website' => 'max:100',
            'facebook' => 'max:100',
            'twitter' => 'max:100',
            'google' => 'max:100',
            'instagram' => 'max:100',
            'language' => 'required|max:100',
            'avatar' => 'required|image',
            'user_role' => 'required|min:1',
            'can_change_property_status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/user/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $avatar = $request->file('avatar');
        $uniqueimgid = rand() .'_'. time();
        $filename = 'avatar_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
        // $filename_261x233 = 'avatar_261x233_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
        // $filename_217x222 = 'avatar_217x222_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
        // $filename_228x207 = 'avatar_228x207_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
        // $filename_49x49 = 'avatar_49x49_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();

        // $path_261x233 = public_path() . '/uploads/avatar/'. $filename_261x233;
        // Image::make($avatar->getRealPath())->resize(261, 233)->save($path_261x233);

        // $path_217x222 = public_path() . '/uploads/avatar/'. $filename_217x222;
        // Image::make($avatar->getRealPath())->resize(217, 222)->save($path_217x222);

        // $path_228x207 = public_path() . '/uploads/avatar/'. $filename_228x207;
        // Image::make($avatar->getRealPath())->resize(228, 207)->save($path_228x207);

        // $path_49x49 = public_path() . '/uploads/avatar/'. $filename_49x49;
        // Image::make($avatar->getRealPath())->resize(49, 49)->save($path_49x49);

        $avatarfilename =  $filename;

        if($avatar->move(public_path() . '/uploads/avatar/', $avatarfilename))
        {
        }else{
            return redirect('/admin/user/add')->with('errmessage_aftersubmit', trans('general.error_occurred_while_uploading_the_file'))->withInput();
        }

        if(isset($data['email_show'])){
            $email_show = 'no';
        }else{
            $email_show = "yes";
        }
        if(isset($data['phone_show'])){
            $phone_show = 'no';
        }else{
            $phone_show = "yes";
        }
        if(isset($data['officephone_show'])){
            $officephone_show = 'no';
        }else{
            $officephone_show = "yes";
        }
        if(isset($data['fax_show'])){
            $fax_show = 'no';
        }else{
            $fax_show = "yes";
        }
        if(isset($data['website_show'])){
            $website_show = 'no';
        }else{
            $website_show = "yes";
        }
        if(isset($data['facebook_show'])){
            $facebook_show = 'no';
        }else{
            $facebook_show = "yes";
        }
        if(isset($data['twitter_show'])){
            $twitter_show = 'no';
        }else{
            $twitter_show = "yes";
        }
        if(isset($data['google_show'])){
            $google_show = 'no';
        }else{
            $google_show = "yes";
        }
        if(isset($data['instagram_show'])){
            $instagram_show = 'no';
        }else{
            $instagram_show = "yes";
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_show' => $email_show,
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'phone_show' => $phone_show,
            'officephone' => $data['officephone'],
            'officephone_show' => $officephone_show,
            'fax' => $data['fax'],
            'fax_show' => $fax_show,
            'website' => $data['website'],
            'website_show' => $website_show,
            'facebook' => $data['facebook'],
            'facebook_show' => $facebook_show,
            'twitter' => $data['twitter'],
            'twitter_show' => $twitter_show,
            'google' => $data['google'],
            'google_show' => $google_show,
            'instagram' => $data['instagram'],
            'instagram_show' => $instagram_show,
            'about' => $data['about'],
            'address' => $data['address'],
            'avatar' => $avatarfilename,
            'language' => $data['language'],
            'parent' => $data['parent'],
            'can_change_property_status' => $data['can_change_property_status'],
            'status' => isset($data['status']) ? $data['status'] : 'Inactive',
        ]);
        
        foreach ($data["user_role"] as $user_role) {
            $user->roles()->attach(Role::where('name',$user_role)->first());
        }

        return redirect()->route('users')->with('message', trans('general.record_added_successfully').'.');

    }

    public function details($id)
    {
        $data['user'] = User::where('id',$id)->first();
        return view('admin.users.details',$data);
    }

    public function update($id)
    {
        $data["user_details"] = User::where('id',$id)->first();
        $data['languages'] = Language::all();
        
        $data["users_forparent"] = DB::table('users')
                                    ->leftJoin('user_role', 'users.id', '=', 'user_role.user_id')
                                    ->select('users.id','users.name','users.email')
                                    ->whereIn('user_role.role_id',[3,4])
                                    ->get();
        return view('admin.users.update',$data);
    }

    public function postupdate(Request $request, $id)
    {
        //
        $data = $request->all();
        $user = User::find($data['id']);

        if($this->shareddata['current_user']->hasRole('Admin'))
        {
            $validator = Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                'password' => 'min:6|confirmed',
                'address' => 'required|max:255',
                'phone' => 'required|max:100',
                'officephone' => 'max:100',
                'fax' => 'max:100',
                'website' => 'max:100',
                'facebook' => 'max:100',
                'twitter' => 'max:100',
                'google' => 'max:100',
                'instagram' => 'max:100',
                'language' => 'required|max:100',
                'avatar' => 'image',
                'user_role' => 'required|min:1',
                'can_change_property_status' => 'required',
            ]);
        }else{
            $validator = Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                'password' => 'min:6|confirmed',
                'address' => 'required|max:255',
                'phone' => 'required|max:100',
                'officephone' => 'max:100',
                'fax' => 'max:100',
                'website' => 'max:100',
                'facebook' => 'max:100',
                'twitter' => 'max:100',
                'google' => 'max:100',
                'instagram' => 'max:100',
                'language' => 'required|max:100',
                'avatar' => 'image',
                'can_change_property_status' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return redirect('/admin/user/update/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $avatar = $request->file('avatar');
        if(isset($avatar)){
            // $avatarfilename = str_replace(" ", "", $data["name"]) . '_'. time() .'.' . $avatar->getClientOriginalExtension();
            $uniqueimgid = rand() .'_'. time();
            $filename = 'avatar_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            // $filename_261x233 = 'avatar_261x233_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            // $filename_217x222 = 'avatar_217x222_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            // $filename_228x207 = 'avatar_228x207_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            // $filename_49x49 = 'avatar_49x49_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();

            // $path_261x233 = public_path() . '/uploads/avatar/'. $filename_261x233;
            // Image::make($avatar->getRealPath())->resize(261, 233)->save($path_261x233);

            // $path_217x222 = public_path() . '/uploads/avatar/'. $filename_217x222;
            // Image::make($avatar->getRealPath())->resize(217, 222)->save($path_217x222);

            // $path_228x207 = public_path() . '/uploads/avatar/'. $filename_228x207;
            // Image::make($avatar->getRealPath())->resize(228, 207)->save($path_228x207);

            // $path_49x49 = public_path() . '/uploads/avatar/'. $filename_49x49;
            // Image::make($avatar->getRealPath())->resize(49, 49)->save($path_49x49);

            $avatarfilename =  $filename;

            if($avatar->move(public_path() . '/uploads/avatar/', $avatarfilename))
            {
            }else{
                return redirect('/admin/user/update/'.$id)->with('errmessage_aftersubmit', trans('general.error_occurred_while_uploading_the_file'))->withInput();
            }
        }

        if(isset($data['email_show'])){
            $email_show = 'no';
        }else{
            $email_show = "yes";
        }
        if(isset($data['phone_show'])){
            $phone_show = 'no';
        }else{
            $phone_show = "yes";
        }
        if(isset($data['officephone_show'])){
            $officephone_show = 'no';
        }else{
            $officephone_show = "yes";
        }
        if(isset($data['fax_show'])){
            $fax_show = 'no';
        }else{
            $fax_show = "yes";
        }
        if(isset($data['website_show'])){
            $website_show = 'no';
        }else{
            $website_show = "yes";
        }
        if(isset($data['facebook_show'])){
            $facebook_show = 'no';
        }else{
            $facebook_show = "yes";
        }
        if(isset($data['twitter_show'])){
            $twitter_show = 'no';
        }else{
            $twitter_show = "yes";
        }
        if(isset($data['google_show'])){
            $google_show = 'no';
        }else{
            $google_show = "yes";
        }
        if(isset($data['instagram_show'])){
            $instagram_show = 'no';
        }else{
            $instagram_show = "yes";
        }
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->email_show = $email_show;
        if($data['password'] != ""){
            $user->password = bcrypt($data['password']);
        }
        $user->phone = $data['phone'];
        $user->phone_show = $phone_show;
        $user->officephone = $data['officephone'];
        $user->officephone_show = $officephone_show;
        $user->fax = $data['fax'];
        $user->fax_show = $fax_show;
        $user->website = $data['website'];
        $user->website_show = $website_show;
        $user->facebook = $data['facebook'];
        $user->facebook_show = $facebook_show;
        $user->twitter = $data['twitter'];
        $user->twitter_show = $twitter_show;
        $user->google = $data['google'];
        $user->google_show = $google_show;
        $user->instagram = $data['instagram'];
        $user->instagram_show = $instagram_show;
        $user->about = $data['about'];
        $user->address = $data['address'];
        if(isset($avatarfilename)){
            $user->avatar = $avatarfilename;
        }
        $user->language = $data['language'];
        $user->parent = $data['parent'];
        $user->can_change_property_status = $data['can_change_property_status'];
        $user->status = isset($data['status']) ? $data['status'] : 'Inactive';

        $user->save();
        
        User_Role::where('user_id','=',$user->id)->delete();

        foreach ($data["user_role"] as $user_role) {
            $user->roles()->attach(Role::where('name',$user_role)->first());
        }
        return redirect()->route('users')->with('message', trans('general.record_updated_successfully').'.');
    }

    public function delete(Request $request, $id = ''){

        $input = $request->all();

        $rules = [
            'idstodelete' => 'required'
        ];

        $messages = [
            'idstodelete.required' => trans('validation.please_select_atleast_one_record_to_delete'),
        ];        

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return redirect('/admin/users')
                        ->withErrors($validator)
                        ->withInput();
        }

        $idstodelete = explode(",", $input['idstodelete']);

        if(User::destroy($idstodelete)){
            return redirect()->route('users')->with('message', trans('general.record_deleted_successfully').'.');
        }else{
            return redirect()->route('users')->withErrors('errors', trans('general.error_occurred_while_deleting_the_record').'.');
        }
    }

    public function postAdminAssignRoles(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();
        if($request["role_user"]){
            $user->roles()->attach(Role::where('name','User')->first());
        }
        if($request["role_agent"]){
            $user->roles()->attach(Role::where('name','Agent')->first());
        }
        if($request["role_admin"]){
            $user->roles()->attach(Role::where('name','Admin')->first());
        }

        return redirect()->back();
    }

    protected function isValidSession()
    {
       
        if (!Auth::check()) {
            $message = ['status' => 'ERROR', 'message' => 'Invalid credentials'];
            return Response::json($message, 401);
        }

        $user        = Auth::user();

        $user_arr = array(
            'id'              => $user->id,
            'name'            => $user->name,
            'email'           => $user->email,
            'phone'           => $user->phone,
            'language'        => $user->language
        );

        return Response::json(array(
            'status'            => 'SUCCESS',
            'user'              => $user_arr
        ));
    }

    public function authenticate(array $data)
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => bcrypt($data['password'])])) {
            $message = ['status' => 'success', 'message' => 'Auth succeeded'];
            return Response::json($message, 200);
        }
    }

    public function keepAlive() {
        $message = ['status' => 'success', 'message' => 'Alive'];
        return Response::json($message, 200);
    }

    public function myprofile()
    {
        $data["user_details"] = User::find($this->shareddata['current_user']->id);
        $data["users_forparent"] = DB::table('users')
                                    ->leftJoin('user_role', 'users.id', '=', 'user_role.user_id')
                                    ->whereIn('user_role.role_id',[3,4])
                                    ->get();
        return view('admin.users.myprofile',$data);
    }

    public function postmyprofile(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['id']);

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'password' => 'min:6|confirmed',
            'address' => 'required|max:255',
            'phone' => 'required|max:100',
            'officephone' => 'max:100',
            'fax' => 'max:100',
            'website' => 'max:100',
            'facebook' => 'max:100',
            'twitter' => 'max:100',
            'google' => 'max:100',
            'instagram' => 'max:100',
            'language' => 'required|max:100',
            'avatar' => 'image',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/user/update/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $avatar = $request->file('avatar');
        if(isset($avatar)){
            // $avatarfilename = str_replace(" ", "", $data["name"]) . '_'. time() .'.' . $avatar->getClientOriginalExtension();
            $uniqueimgid = rand() .'_'. time();
            $filename = 'avatar_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_261x233 = 'avatar_261x233_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_217x222 = 'avatar_217x222_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_228x207 = 'avatar_228x207_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_49x49 = 'avatar_49x49_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();

            $path_261x233 = public_path() . '/uploads/avatar/'. $filename_261x233;
            Image::make($avatar->getRealPath())->resize(261, 233)->save($path_261x233);

            $path_217x222 = public_path() . '/uploads/avatar/'. $filename_217x222;
            Image::make($avatar->getRealPath())->resize(217, 222)->save($path_217x222);

            $path_228x207 = public_path() . '/uploads/avatar/'. $filename_228x207;
            Image::make($avatar->getRealPath())->resize(228, 207)->save($path_228x207);

            $path_49x49 = public_path() . '/uploads/avatar/'. $filename_49x49;
            Image::make($avatar->getRealPath())->resize(49, 49)->save($path_49x49);

            $avatarfilename =  $filename;

            if($avatar->move(public_path() . '/uploads/avatar/', $avatarfilename))
            {
            }else{
                return redirect('/admin/user/add')->with('errmessage_aftersubmit', trans('general.error_occurred_while_uploading_the_file'))->withInput();
            }
        }
        
        $user->name = $data['name'];
        if($data['password'] != ""){
            $user->password = bcrypt($data['password']);
        }
        $user->phone = $data['phone'];
        $user->officephone = $data['officephone'];
        $user->fax = $data['fax'];
        $user->website = $data['website'];
        $user->facebook = $data['facebook'];
        $user->twitter = $data['twitter'];
        $user->google = $data['google'];
        $user->instagram = $data['instagram'];
        $user->about = $data['about'];
        $user->address = $data['address'];
        if(isset($avatarfilename)){
            $user->avatar = $avatarfilename;
        }
        $user->language = $data['language'];
        $user->status = isset($data['status']) ? $data['status'] : 'Inactive';

        $user->save();

        return redirect()->route('users.myprofile')->with('message', trans('general.record_updated_successfully').'.');
    }

    function completeregistration()
    {
        $data['userdetails'] = $this->shareddata['current_user'];
        $data['languages'] = Language::all();
        $data['roles'] = Role::all();
        return view('admin.users.completeregistration',$data);
    }

    function postcompleteregistration(Request $request)
    {
        $formdata = $request->all();
        $user = Auth::User();

        $validator = Validator::make($formdata, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'min:6|confirmed',
            'address' => 'required|max:255',
            'phone' => 'required|max:100',
            'language' => 'required|max:100',
            'avatar' => 'required|image',
            'user_role' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/user/completeregistration/')
                        ->withErrors($validator)
                        ->withInput();
        }

        $avatar = $request->file('avatar');
        if(isset($avatar)){
            // $avatarfilename = str_replace(" ", "", $data["name"]) . '_'. time() .'.' . $avatar->getClientOriginalExtension();
            $uniqueimgid = rand() .'_'. time();
            $filename = 'avatar_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_261x233 = 'avatar_261x233_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_217x222 = 'avatar_217x222_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_228x207 = 'avatar_228x207_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();
            $filename_49x49 = 'avatar_49x49_'. $uniqueimgid .'.' . $avatar->getClientOriginalExtension();

            $path_261x233 = public_path() . '/uploads/avatar/'. $filename_261x233;
            Image::make($avatar->getRealPath())->resize(261, 233)->save($path_261x233);

            $path_217x222 = public_path() . '/uploads/avatar/'. $filename_217x222;
            Image::make($avatar->getRealPath())->resize(217, 222)->save($path_217x222);

            $path_228x207 = public_path() . '/uploads/avatar/'. $filename_228x207;
            Image::make($avatar->getRealPath())->resize(228, 207)->save($path_228x207);

            $path_49x49 = public_path() . '/uploads/avatar/'. $filename_49x49;
            Image::make($avatar->getRealPath())->resize(49, 49)->save($path_49x49);

            $avatarfilename =  $filename;

            if($avatar->move(public_path() . '/uploads/avatar/', $avatarfilename))
            {
            }else{
                return redirect('/admin/user/update/'.$id)->with('errmessage_aftersubmit', trans('general.error_occurred_while_uploading_the_file'))->withInput();
            }
        }

        
        $user->name = $formdata['name'];
        $user->email = $formdata['email'];
        if($formdata['password'] != ""){
            $user->password = bcrypt($formdata['password']);
        }
        $user->phone = $formdata['phone'];
        $user->address = $formdata['address'];
        if(isset($avatarfilename)){
            $user->avatar = $avatarfilename;
        }
        $user->language = $formdata['language'];
        $admin = User::join('user_role','users.id','=','user_role.user_id')->where('user_role.role_id','=',3)->first();        
        $user->parent = $admin->id;
        $user->status = 'Active';
        $user->save();
        $user->roles()->attach(Role::where('id',$formdata['user_role'])->first());
        if($user->hasRole('Agency') || $user->hasRole('Agent'))
        {
            return redirect('/admin/mysubscription');
        }else{
            return redirect('/');
        }
        
    }

}
