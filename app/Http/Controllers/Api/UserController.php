<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WelcomeEmailService;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::with('emails')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'phone_number' => 'required|string',
        'emails' => 'required|array',
        'emails.*' => 'required|email',
        ]);

        $user = User::create($data);
        foreach ($data['emails'] as $email) {
            $user->emails()->create(['email' => $email]);
        }

        return (new UserResource($user->load('emails')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user->load('emails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
        'firstname' => 'sometimes|required|string',
        'lastname' => 'sometimes|required|string',
        'phone_number' => 'sometimes|required|string',
        'emails' => 'sometimes|required|array',
        'emails.*' => 'required|email',
        ]);

        $user->update($data);
        if (isset($data['emails'])) {
            $user->emails()->delete();
            foreach ($data['emails'] as $email) {
                $user->emails()->create(['email' => $email]);
            }
        }

        return new UserResource($user->load('emails'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => "User with ID $id not found."
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => "User with ID $id successfully deleted."
        ], 200);
    }


    public function sendWelcomeMessage(User $user)
    {
        (new WelcomeEmailService())->send($user);

        return response()->json([
            'message' => 'Welcome email sent to all user emails.'
        ]);
    }
}
