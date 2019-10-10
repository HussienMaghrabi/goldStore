<?php

namespace App\Http\Controllers\Api;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ConversationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $auth = $this->auth();

        if ($auth)
        {
            $data['conversations'] = Conversation::select('id', 'user_one_id', 'user_two_id')->where('user_one_id', $auth)->orWhere('user_two_id', $auth)->paginate(10);

            $data['conversations']->map(function ($item) use ($auth)
            {
                if ($auth == $item->user_one_id)
                {
                    $item->user = User::select('id', 'name', 'image')->where('id', $item->user_two_id)->first();
                }
                else
                {
                    $item->user = User::select('id', 'name', 'image')->where('id', $item->user_one_id)->first();
                }

                $item->message = Message::with('User:id,name,image')->select('id', 'message', 'created_at', 'user_id')->where('conversation_id', $item->id)->orderBy('id', 'DESC')->first();

                unset($item->message->user_id);
                unset($item->user_one_id);
                unset($item->user_two_id);
            });

            return $this->successResponse($data);
        }
        else
        {
            return $this->errorResponse(__('api.Authorization'));
        }
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
    public function store(Request $request)
    {
        //
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

        if ($auth)
        {
            $conversation = Conversation::find($id);

            if ($conversation)
            {
                $data['messages'] = $conversation->Message()->with('User:id,name,image')->select('id', 'message', 'created_at', 'user_id')->orderByDesc('id')->paginate(10);

                return $this->successResponse($data);
            }
            else
            {
                return $this->errorResponse('no conversation founded');
            }
        }
        else
        {
            return $this->errorResponse(__('api.Authorization'));
        }
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
