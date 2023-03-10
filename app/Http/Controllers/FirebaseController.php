<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = FirebaseService::connect();
    }

    public function index()
    {
        return response()->json($this->database->getReference('khem/leafbox')->getValue());
    }
}
