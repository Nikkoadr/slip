<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\URL;

class BotController extends Controller
{
    public function webhook()
    {
        $update = Telegram::getWebhookUpdates();
        if ($update->getMessage()) {
            $message = $update->getMessage();
            $text = $message->get('text');
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
        $downloadLink = URL::to('employee/' . $employee->id . '/download-slip');
        if ($employee) {
            $text = "Slip Gaji Guru/Karyawan:\n" .
                    "Nama: {$employee->nama}\n" .
                    "Jumlah Gaji: Rp " . number_format($employee->jumlah_gaji, 0, ',', '.') . "\n" .
                    "Jumlah Hadir: {$employee->jumlah_hadir} hari\n" .
                    "Koprasi: {$employee->koprasi}\n" .
                    "Unduh slip gaji: $downloadLink";
        } else {
            $text = "Guru/Karyawan dengan NIK $nik tidak ditemukan.";
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }
}
