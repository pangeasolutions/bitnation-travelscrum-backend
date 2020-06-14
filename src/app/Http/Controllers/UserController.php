<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\AskPermissionDocument;
use Illuminate\Support\Facades\Redis;
use App\Events\GrantPermissionDocument;
use App\Events\RejectPermissionDocument;

class UserController extends Controller
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
        //
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


    // Handler for user asking permission to see document
    public function askPermission(Request $request)
    {
        // Get the post data
        $reqArray = $request->json()->all();
        // Get the data out of the postData key and move it up a level in the object
        $permissionObject = $reqArray['postData'];
        // Emit event asking to see document
        event(new AskPermissionDocument($permissionObject));
        return response('', 200);
    }

    public function receivePermission(Request $request)
    {
        // Get the post data
        $reqArray = $request->json()->all();
        // Get the data out of the postData key and move it up a level in the object
        $permissionObject = $reqArray['postData'];

        // If permission was rejected emit a RejectPermission event
        if ($permissionObject['rejected']) {
            event(new RejectPermissionDocument($permissionObject));
            return response('', 200);
        }
        // If permission was granted emit a GrantPermission event
        if (!$permissionObject['rejected']) { {
                // Store the document in a local variable and take it out of the array
                $documentData = $permissionObject['documentData'];
                unset($permissionObject['documentData']);

                // PUT $documentData in redis with a key format of "document-for-ID"
                $userId = Auth::id();
                Redis::setex('document-for-' . strVal($userId), 90, $documentData);

                // Notify user he has a document waiting for him
                event(new GrantPermissionDocument($permissionObject));
                return response('', 200);
            }
        }
    }

    public function fetchDocument()
    {
        $userId = Auth::id();
        $encryptedDocument =  Redis::get('document-for-' . strVal($userId));
        Redis::del('document-for-' . strVal($userId));
        return json_encode(["encryptedDocument" => $encryptedDocument]);
    }
}
