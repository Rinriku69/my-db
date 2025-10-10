<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
  
    function find(string $code): Model
    {
        return User::where('id', $code)
        ->orwhere('email',$code)
        ->firstOrFail();
    }
    
    function list(): View{ 
        $user = User::get();
        Gate::authorize('list', User::class);  
        return view('users.list',[
            'users' => $user
        ]);
    }
    function view(string $userID): View{ 
        $user = User::where('id',$userID)
        ->first();
        Gate::authorize('view', User::class);
        return view('users.view',[
            'user' => $user
        ]);
    }
    function selvesview(): View{ 
        $email = Auth::user()->email;
        $user = User::where('email',$email)
        ->firstorfail();
        

        return view('users.selve.view',[
            'user' => $user
        ]);
    }
    function createForm(): View{ 
        Gate::authorize('create', User::class);
        return view('users.create-form');
    }
    function create(ServerRequestInterface $request): RedirectResponse{ 
        $data = $request->getParsedBody();
        Gate::authorize('create', User::class);
        try{
        $user = new User();
        $user->fill($data);
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->save();
        return redirect()->route('users.list')
        ->with('status','User '.$user->name.' was created');
   }catch(QueryException $excp){
        return redirect()->back()
        ->withInput()
        ->withErrors([
            'alert' => $excp->errorInfo[2],//errorInfo is only key for QueryException!!
        ]);
    }catch(ModelNotFoundException $excp){
        return redirect()
        ->back()
        ->withErrors([
            'alert'=>$excp->getMessage()]);
    }
}

    function delete(string $user): RedirectResponse
    {
        $user = $this->find($user);
       Gate::authorize('delete',$user); 
       try{
        $user->delete();
        Gate::authorize('delete', User::class);
        return redirect(
            session()->get('bookmarks.user.view', route('users.list'))
        )
        ->with('status','User '.$user->name.' was Deleted');
   }catch(QueryException $excp){
        return redirect()->back()
        ->withErrors([
            'alert' => $excp->errorInfo[2],//errorInfo is only key for QueryException!!
        ]);
    }catch(ModelNotFoundException $excp){
        return redirect()
        ->back()
        ->withErrors([
            'alert'=>$excp->getMessage()]);
    }
 }

    function UpdateForm(string $user): View
    {
         Gate::authorize('update', User::class);
        $user = $this->find($user);
         Gate::authorize('update', $user); 
       
        return view('users.updateForm', [
            'user' => $user,
            
        ]);
    }

    function update(
        ServerRequestInterface $request,
        string $user,
    ): RedirectResponse {
        
        $data = $request->getParsedBody();
        $user = $this->find($user);
        Gate::authorize('update', $user);
        try{
       $password = $user->password;

        $user->fill($data);
        if(isset($data['role'])){
        $user->role = $data['role'];
        }
         if($data['password'] !== null){
            $user->password = $data['password'];
        }else{
             $user->password = $password;
        } 
      
        $user->save();
      

        return redirect()->route('users.view', [
            'user' => $user->id,
        ])->with('status','User '.$user->name.' was updated');
    }catch(QueryException $excp){
        return redirect()->back()
        ->withInput()
        ->withErrors([
            'alert' => $excp->errorInfo[2],//errorInfo is only key for QueryException!!
        ]);
    }catch(ModelNotFoundException $excp){
        return redirect()
        ->back()
        ->withErrors([
            'alert'=>$excp->getMessage()]);
    }
}

    function selvesUpdateForm(): View
    {
        $user = auth::user()->email;
        $user = $this->find($user);
        /* Gate::authorize('update', $product);  */ 
       
        return view('users.selve.update', [
            'user' => $user,
            
        ]);
    }

    function selvesUpdate(
        ServerRequestInterface $request,
    ): RedirectResponse {
        try{
        $userID = auth::user()->id;
        $data = $request->getParsedBody();
        $user = $this->find($userID);
       $password = $user->password;
        $user->fill($data);
        
        $user->role = $data['role'];
         if($data['password'] !== null){
            $user->password = $data['password'];
        }else{
             $user->password = $password;
        } 
      
        $user->save();
       

        return redirect()->route('users.selves.view'
        )->with('status','User '.$user->name.' was updated');
   }catch(QueryException $excp){
        return redirect()->back()
        ->withInput()
        ->withErrors([
            'alert' => $excp->errorInfo[2],//errorInfo is only key for QueryException!!
        ]);
    }catch(ModelNotFoundException $excp){
        return redirect()
        ->back()
        ->withErrors([
            'alert'=>$excp->getMessage()]);
    } 
}
}
