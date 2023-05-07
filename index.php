<?php

$token = "TOKEN_BOT_TELEGRAM";
$apiURL = "https://api.telegram.org/bot{$token}/";

$update = json_decode(file_get_contents("php://input"), true);

// Fungsi untuk mengirim pesan ke grup
function sendMessage($chatID, $message) {
    global $apiURL;
    $url = $apiURL . "sendMessage?chat_id=" . $chatID . "&text=" . urlencode($message);
    file_get_contents($url);
}

// Fungsi untuk mengirim pesan dan foto ke grup
function sendPhotoWithCaption($chatID, $photoURL, $caption) {
    global $apiURL;
    $url = $apiURL . "sendPhoto";
    $data = array(
        "chat_id" => $chatID,
        "photo" => $photoURL,
        "caption" => $caption
    );
    $options = array(
        "http" => array(
            "header" => "Content-Type:multipart/form-data",
            "method" => "POST",
            "content" => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// Mendapatkan informasi tentang anggota baru yang bergabung atau pesan yang diterima
if (isset($update["message"])) {
    $message = $update["message"];
    $chatID = $message["chat"]["id"];
    $text = $message["text"];

    // Memeriksa apakah pesan adalah "/start"
    if ($text == "/start") {
        // Mengirimkan informasi penggunaan bot
        $usageInfo = "Halo! Saya adalah bot sambutan di grup ini.\n\n"
            . "Saat Anda bergabung dengan grup, saya akan memberikan pesan sambutan kepada Anda bersama dengan foto profil Anda.\n\n"
            . "Jika Anda membutuhkan bantuan atau informasi tambahan, jangan ragu untuk menghubungi admin grup.\n\n"
            . "Terima kasih!";
        sendMessage($chatID, $usageInfo);
    } elseif (isset($message["new_chat_members"])) {
        // Mendapatkan informasi tentang anggota baru yang bergabung
        $members = $message["new_chat_members"];

        // Mengirim pesan welcome dengan foto profil
        foreach ($members as $member) {
            $userID = $member["id"];
            $firstName = $member["first_name"];
            $profilePhoto = $member["photo"]["big_file_id"]; // Menggunakan foto profil besar

            // Mendapatkan URL foto profil
            $getFileURL = $apiURL . "getUserProfilePhotos?user_id=" . $userID . "&limit=1";
            $getFileResponse = json_decode(file_get_contents($getFileURL), true);
            $photoFileID = $getFileResponse["result"]["photos"][0][0]["file_id"];
            $getPhotoURL = $apiURL . "getFile?file_id=" . $photoFileID;
            $getPhotoResponse = json_decode(file_get_contents($getPhotoURL), true);
            $photoURL = $apiURL . $getPhotoResponse["result"]["file_path"];

            $welcomeMessage = "Halo, {$firstName}! Selamat datang di grup ini. Terima kasih sudah bergabung!";
            sendPhotoWithCaption($chatID, $photoURL, $welcomeMessage);
        }
    }
}
