<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\UserRequest;


class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    // list user
    public function index()
    {
        $list_users = [];
        $users = $this->user_repository->all();
        if (!empty($users)) {
          $list_users = $users;
        } else {
            Session::flash('error', 'Not found data');
        }
        return view('admin.user.index', ['list_users' => $list_users]);
    }

	// show create form
    public function create()
    {
        return view('admin.user.create');
    }

    // handle form create POST
    public function store(Request $request)
    {
        $params = $request->all();
        $user_request = new UserRequest;
        $validator = Validator::make($params, $user_request->rules());
        if($validator->fails()){
            $request->session()->flash('error', $validator->errors()->first());
            return redirect()->back()->withInput();
        }
        $data = handleDataUserModel($params);
        $userRepository = $this->user_repository->create($data);

        if (!$userRepository) {
            $request->session()->flash('error', 'Unknow eror!!');
            return redirect()->back()->withInput();
        } else {
            $request->session()->flash('success', 'User created!!');
            return redirect('admin/user');
        }
    }

    // show from edit
    public function edit($user_id)
    {
        $user = $this->user_repository->findById($user_id);

        if (!empty($user)) {
            return view('admin.user.edit', ['user' => $user, 'user_id' => $user_id]);
        } else {
            Session::flash('error', 'User not found!!');
            return redirect('admin/user');         
        }
    }

    // handle form edit POST
    public function update(Request $request, $user_id)
    {
        $params = $request->all();
        $user_request = new UserRequest();
        $validator = Validator::make($params, $user_request->rules($user_id));
        if($validator->fails()){
            $request->session()->flash('error', $validator->errors()->first());
            return back()->with(['user' => $params]);
        }
        $data = handleDataUserModel($params);
        $user_repository = $this->user_repository->update($user_id, $data);

        if (!$user_repository) {
            $request->session()->flash('error', 'Can not update user');
            return back()->with(['user' => $params]);
        } else {
            $request->session()->flash('success', 'User updated');
            return redirect('admin/user');
        }
    }

    // delete a user
    public function destroy($user_id)
    {
        $user = $this->user_repository->delete($user_id);
        if (!$user) {
          Session()->flash('error', 'Can not delete this user!!');
        } else {
          Session()->flash('success', 'User is deleted!!');
        }
        return redirect('admin/user');
    }
}
