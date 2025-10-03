<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
  
    function find(string $code): Model
    {
        return User::where('id', $code)->firstOrFail();
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
        $user = new User();
        $user->fill($data);
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->save();
        return redirect()->route('users.list');
    }

    function delete(string $user): RedirectResponse
    {
        $user = $this->find($user);
        /* Gate::authorize('delete',$product);  */
        $user->delete();
        Gate::authorize('delete', User::class);
        return redirect(
            session()->get('bookmarks.user.view', route('users.list'))
        )
        ->with('status','User '.$user->name.' was Deleted');
    }

    function UpdateForm(string $user): View
    {
         Gate::authorize('update', User::class);
        $user = $this->find($user);
        /* Gate::authorize('update', $product);  */ 
       
        return view('users.updateForm', [
            'user' => $user,
            
        ]);
    }

    function update(
        ServerRequestInterface $request,
        string $user,
    ): RedirectResponse {
        Gate::authorize('update', User::class);
        $data = $request->getParsedBody();
        $user = $this->find($user);
        /* Gate::authorize('update', $product);  */
       

        $user->fill($data);
        $user->email = $data['email'];
        $user->save();
        /* $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save(); */ //mass update

        return redirect()->route('users.view', [
            'user' => $user->id,
        ])->with('status','User '.$user->name.' was updated');
    }
    function selvesUpdateForm(string $user): View
    {
         
        $user = $this->find($user);
        /* Gate::authorize('update', $product);  */ 
       
        return view('users.selve.update', [
            'user' => $user,
            
        ]);
    }

    function selvesUpdate(
        ServerRequestInterface $request,
        string $user,
    ): RedirectResponse {
        $data = $request->getParsedBody();
        $user = $this->find($user);
        /* Gate::authorize('update', $product);  */
       

        $user->fill($data);
        $user->email = $data['email'];
        $user->save();
        /* $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save(); */ //mass update

        return redirect()->route('users.selve.view')->with('status','User '.$user->name.' was updated');
    }
}
