<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\Contract;
use App\Domain\Services\UserService;
use App\Rules\ReCaptcha;
use Backpack\CRUD\app\Http\Controllers\Auth\LoginController as BackPackLoginController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BackPackLoginController
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService  =   $userService;
    }

    public function login(Request $request): Factory|View|Response|JsonResponse|Redirector|RedirectResponse|Application
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);
        $user   =   $this->userService->userRepository->firstByEmail($request->input(Contract::EMAIL));
        if (Hash::check($request->input(Contract::PASSWORD), $user->{Contract::PASSWORD})) {
            backpack_auth()->login($user);
            if (backpack_user()->{Contract::ROLE} === 'lawyer' || backpack_user()->{Contract::ROLE} === 'moderator') {
                return redirect('question');
            }
            return redirect('dashboard');
        }
        return view('vendor.backpack.base.auth.login',['username'=>'email']);
    }
}
