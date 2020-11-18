<?php

    namespace App\Http\Controllers;
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
            'password' => 'required'
        ];

        $this->validate($request,$rules);

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
         ]);
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