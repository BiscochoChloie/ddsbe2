<?php

    namespace App\Http\Controllers;

    use App\Models\UserJob;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response; 
    use App\Models\User;
    use App\Traits\ApiResponser;

Class UserController extends Controller {
    use ApiResponser;
    private $request;

    public function __construct(Request $request){
    $this->request = $request;
    }

    public function getUsers(){
        $users = app('db') ->select ("SELECT * FROM users");
        return $this->successResponse($users);
 }

    function Login()
    {
    return view('login');
    }

    public function test(Request $request)
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $users = app('db')->select("SELECT * FROM users WHERE username='$username' and password='$password'");

        if(!$users || !$password){
            return 'Invalid credentials!';
        }else{
            return 'Successfully Log-In!';
        }   
    }
    
    public function index()
    {
    $users = User::all();
    return $this->successResponse($users);
    }

    public function create(Request $request ){
        $rules = [
            'username' => 'required',
            'password' => 'required|min:8',
            'email' =>'required|email|unique:users,email',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request,$rules);

        // validate if Jobid is found in the table tbluserjob

        $userjob =UserJob::findOrFail($request->jobId);

        $users = User::create($request->all());

        return $this->successResponse($users, Response::HTTP_CREATED);
    }

    public function read($id)
    {
        $users = User::find($id);
        return $this->successResponse($users);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
        'username' => 'filled',
        'password' => 'filled',
        'email' => 'filled',
        'jobid' => 'required|numeric|min:1|not_in:0',

         ]);
        // validate if Jobid is found in the table tbluserjob
 
        $userjob = UserJob::findOrFail($request->jobId);

        $users = User::find($id);

        if($users->fill($request->all())->save()){

            return $this->successResponse(['status' => 'success',$users]);
        }

        return $this->errorResponse(['status' => 'failed','result' =>$users]);
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return $this->successResponse(['Deleted successfully!',$users]);
    }
}