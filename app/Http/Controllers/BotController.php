<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    public function webhook()
    {
        $update = Telegram::getWebhookUpdates();
        // Pastikan untuk memeriksa apakah ada pesan sebelum mengaksesnya
        if ($update->getMessage()) {
            $message = $update->getMessage();
            $text = $message->get('text'); // Menggunakan metode get untuk akses properti
            $chatId = $message->getChat()->getId();

            if ($text === '/start') {
                $this->sendWelcomeMessage($chatId);
            } elseif (str_starts_with($text, '/slip')) {
                $nik = trim(str_replace('/slip', '', $text));
                $this->sendSlipGaji($chatId, $nik);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    protected function sendWelcomeMessage($chatId)
    {
        $text = "Selamat datang! Untuk melihat slip gaji, silakan masukkan NIK dengan format: /slip <NIK>";
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }

    protected function sendSlipGaji($chatId, $nik)
    {
        // Cari data karyawan berdasarkan NIK
        $employee = \App\Models\Employee::where('nik', $nik)->first();

        if ($employee) {
            $text = "Slip Gaji Karyawan:\n" .
                    "Nama: {$employee->nama}\n" .
                    "Jumlah Gaji: {$employee->jumlah_gaji}\n" .
                    "Jumlah Hadir: {$employee->jumlah_hadir} hari";
        } else {
            $text = "Karyawan dengan NIK $nik tidak ditemukan.";
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }
}
