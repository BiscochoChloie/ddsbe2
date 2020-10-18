<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Model\User;
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
}
?>
