<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exceptions;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $result_response  = $this->response_body['SUCCESS'];
      try {
        $users = $this->user_repository->all();
        if (!empty($users)) {
          $result_response['data'] = $users;
        } else {
          $result_response  = $this->response_body['NO_DATA'];
          $result_response['msg'] = 'Data result is empty';
        }
      } catch( Exception $e ) {
        $result_response  = $this->response_body['UNKNOWN'];
      }
      return response()->json($result_response, $result_response['code']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $result_response  = $this->response_body['SUCCESS'];
        $params   = $request->all();

        try {
          $data = handleDataUserModel($params);
          $userRepository = $this->user_repository->create($data);

          if (!$userRepository) {
            $result_response  = $this->response_body['FUNCTION_NOT_EXCUTE'];
            $result_response['msg']    = 'Save data fails';
          } else {
            $result_response  = $this->response_body['SUCCESS'];
            $result_response['msg']    = 'User created';
          }
        }catch (Exception $e) {
          $result_response  = $this->response_body['UNKNOWN'];
        }
        return response()->json($result_response, $result_response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $result_response  = $this->response_body['SUCCESS'];
      try {
        $user = $this->user_repository->findById($id);
        if (!empty($user)) {
            $result_response['msg']  = 'Get user inf success';
            $result_response['data'] = $user;
        } else {
          $result_response  = $this->response_body['NO_DATA'];
          $result_response['msg'] = 'Data result is empty';          
        }
      } catch(Exception $e) {
          $result_response  = $this->response_body['UNKNOWN'];
      }
      return response()->json($result_response, $result_response['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $user_id)
    {
      $result_response  = $this->response_body['SUCCESS'];
      $params   = $request->all();

      try {
        $data = handleDataUserModel($params);
        $user_repository = $this->user_repository->update($user_id, $data);

        if (!$user_repository) {
          $result_response  = $this->response_body['FUNCTION_NOT_EXCUTE'];
          $result_response['msg']    = 'Save data fails';
        } else {
          $result_response['msg']    = 'User updated';
        }
      } catch(Exception $e) {
        $result_response  = $this->response_body['UNKNOWN'];
      }
      return response()->json($result_response, $result_response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
      $result_response  = $this->response_body['SUCCESS'];
      try {
        $user = $this->user_repository->delete($user_id);
        if (!$user) {
          $result_response  = $this->response_body['FUNCTION_NOT_EXCUTE'];
          $result_response['msg']     = 'Delete user is fails!';
        } else {
          $result_response['msg']     = 'User is deleted!';
        }
      } catch (Exception $e) {
        $result_response  = $this->response_body['UNKNOWN'];
      }
      return response()->json($result_response, $result_response['code']);
    }

    public function login(Request $request)
    {
      $result_response  = $this->response_body['SUCCESS'];
      $input = $request->only('email', 'password');
      $token = null;

      try {
        if (!$token = JWTAuth::attempt($input)) {
          $result_response = $this->response_body['UNAUTHEN'];
          $result_response['msg'] = 'Invalid Email or Password';
        }
      }catch (JWTException $e) {
        $result_response = $this->response_body['UNKNOWN'];
      }

      $result_response['token'] = $token;
      return response()->json($result_response, $result_response['code']);
    }

    public function logout(Request $request)
    {
      $result_response  = $this->response_body['SUCCESS'];
      $this->validate($request, [
          'token' => 'required'
      ]);

      try {
          JWTAuth::invalidate($request->token);
          $result_response['msg'] = 'User logged out successfully';
      } catch (JWTException $exception) {
        $result_response = $this->response_body['UNKNOWN'];
        $result_response['msg'] = 'Sorry, the user cannot be logged out, Unknown error';
      }

      return response()->json($result_response, $result_response['code']);
    }
}
