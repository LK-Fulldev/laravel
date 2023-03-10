<?php

namespace App\Services;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;

class FirebaseService
{
    public function connect()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('khem-leafbox-firebase-adminsdk-sdaac-998313b4cc.json'))
            ->withDatabaseUri("https://khem-leafbox-default-rtdb.firebaseio.com");
        $auth = $factory->createAuth();
        $realtimeDatabase = $factory->createDatabase();
        $cloudMessaging = $factory->createMessaging();
        $remoteConfig = $factory->createRemoteConfig();
        $cloudStorage = $factory->createStorage();
        $firestore = $factory->createFirestore();
    }
}
