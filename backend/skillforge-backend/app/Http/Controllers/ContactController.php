<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Requests\StoreContactRequest;

class ContactController extends Controller
{
    public function store(StoreContactRequest $req) {
        $contactMessage = ContactMessage::create($req->validated());
        
        return response()->json([
            'message' => 'Üzenet sikeresen elküldve!',
            'data' => $contactMessage
        ], 201);
    }

    public function index() {
        return ContactMessage::latest()->paginate(10);
    }
}
