<?php

namespace App\Http\Controllers\Api;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class MessageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $this->lang();
        $auth = $this->auth();
        $rules =  [
            'message'  => 'required'
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        if (request('conversation_id'))
        {

            $message = Message::create([
                'user_id' => $auth,
                'conversation_id' => request('conversation_id'),
                'message' => request('message')
            ]);

            return $this->successResponse($message, __('api.MessageSentSuccessfully'));
        }
        else if (request('user_id'))
        {

            $conversation1 = Conversation::where('user_one_id', $auth)->where('user_two_id', request('user_id'))->first();

            $conversation2 = Conversation::where('user_two_id', $auth)->where('user_one_id', request('user_id'))->first();

            if($conversation1)
            {
                $message = Message::create([
                    'user_id' => $auth,
                    'conversation_id' => $conversation1->id,
                    'message' => request('message')
                ]);

                return $this->successResponse($message, __('api.MessageSentSuccessfully'));
            }
            else if($conversation2)
            {
                $message = Message::create([
                    'user_id' => $auth,
                    'conversation_id' => $conversation2->id,
                    'message' => request('message')
                ]);

                return $this->successResponse($message, __('api.MessageSentSuccessfully'));
            }
            else
            {
                $conversation = Conversation::create([
                    'user_one_id' => $auth,
                    'user_two_id' => request('user_id')
                ]);

                $message = Message::create([
                    'user_id' => $auth,
                    'conversation_id' => $conversation->id,
                    'message' => request('message')
                ]);

                return $this->successResponse($message, __('api.MessageSentSuccessfully'));
            }
        }
        else
        {
            return $this->errorResponse('conversation_id or user_id required');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $auth = $this->auth();

        $conversation1 = Conversation::where('user_one_id', $auth)->where('user_two_id', $id)->first();

        $conversation2 = Conversation::where('user_two_id', $auth)->where('user_one_id', $id)->first();

        $data['messages'] = [];

        if($conversation1)
        {
            $data['messages'] = $conversation1->Message()->with('User:id,name,image')->select('id', 'message', 'created_at', 'user_id')->orderByDesc('id')->paginate(10);
        }
        else if($conversation2)
        {
            $data['messages'] = $conversation2->Message()->with('User:id,name,image')->select('id', 'message', 'created_at', 'user_id')->orderByDesc('id')->paginate(10);
        }
        else
        {
            $data['messages'] = Message::where('id', '-1')->paginate(10);
        }

        return $this->successResponse($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
