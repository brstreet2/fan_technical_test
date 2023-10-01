<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;

class AttendanceController extends Controller
{
    public function insertData(Request $request)
    {
        DB::beginTransaction();
        $error      = false;
        $message    = '';

        try {
            $bearerToken = request()->bearerToken();
            if ($bearerToken == null) {
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 401
                ], 401);
            }

            $tokenId    = app(Parser::class)->parse($bearerToken)->claims()->get('jti');
            $revoked    = Token::find($tokenId)->revoked;

            if ($revoked) {
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 401
                ], 401);
            } else {
                $userId     = app(Parser::class)->parse($bearerToken)->claims()->get('sub');

                $user       = User::find($userId);
                $attendanceDb               = new Attendance();
                $attendanceDb->id_users     = $user->id;
                $attendanceDb->type         = $request->type;
                $attendanceDb->waktu        = $request->waktu;
                $attendanceDb->is_approve   = 0;
                $attendanceDb->timestamps   = false;
                $attendanceDb->save();

                DB::commit();
                return response()->json([
                    'error'     => false,
                    'message'   => 'Absensi berhasil, menunggu approval dari supervisor.',
                    'data'      => $attendanceDb,
                    'status'    => 201
                ], 201);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error'     => true,
                'message'   => dd($e),
                'data'      => '',
                'status'    => 407
            ], 407);
        }
    }

    public function approveData(Request $request)
    {
        DB::beginTransaction();
        $error      = false;
        $message    = '';

        try {
            $bearerToken = request()->bearerToken();
            if ($bearerToken == null) {
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 401
                ], 401);
            }

            $tokenId    = app(Parser::class)->parse($bearerToken)->claims()->get('jti');
            $revoked    = Token::find($tokenId)->revoked;

            if ($revoked) {
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 401
                ], 401);
            } else {
                $userId         = app(Parser::class)->parse($bearerToken)->claims()->get('sub');

                $user           = User::find($userId);
                $attendanceDb   = Attendance::where('id', $request->id_attendance)->first();
                if ($attendanceDb->users->npp_supervisor == $user->npp) {
                    $attendanceDb->is_approve   = 1;
                    $attendanceDb->timestamps   = false;
                    $attendanceDb->save();
                    DB::commit();

                    return response()->json([
                        'error'     => false,
                        'message'   => 'Approval absensi berhasil!',
                        'data'      => $attendanceDb,
                        'status'    => 201
                    ], 201);
                } else {
                    return response()->json([
                        'error'     => false,
                        'message'   => 'Anda tidak mempunyai akses!',
                        'data'      => null,
                        'status'    => 403
                    ], 403);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error'     => true,
                'message'   => dd($e),
                'data'      => '',
                'status'    => 407
            ], 407);
        }
    }

    public function getData(Request $request)
    {
        DB::beginTransaction();
        $error      = false;
        $message    = '';

        try {
            $bearerToken = request()->bearerToken();
            if ($bearerToken == null) {
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid Token',
                    'data'      => '',
                    'status'    => 401
                ], 401);
            }

            $tokenId    = app(Parser::class)->parse($bearerToken)->claims()->get('jti');
            $revoked    = Token::find($tokenId)->revoked;

            if ($revoked) {
                DB::rollBack();

                return response()->json([
                    'error'     => true,
                    'message'   => 'Not Allowed',
                    'data'      => '',
                    'status'    => 401
                ], 401);
            } else {
                $attendanceDb = Attendance::get()->groupBy(function ($date) {
                    return Carbon::parse($date->waktu)->format('Y-m-d'); // Mengambil bagian Y-m-d dari kolom 'waktu'
                });

                foreach ($attendanceDb as $key => $attendance) {
                    $data[$key]['id_user']        = $attendance[0]->id_users;
                    $data[$key]['nama_user']      = $attendance[0]->users->nama;
                    $data[$key]['tanggal']        = Carbon::parse($attendance[0]->waktu)->format('Y-m-d');


                    $in                     = Attendance::where('id_users', '=', $attendance[0]->id_users)
                        ->where('type', 'LIKE', '%IN%')
                        ->whereDate('waktu', '=', Carbon::parse($attendance[0]->waktu)->format('Y-m-d'))->first();
                    $out                    = Attendance::where('id_users', '=', $attendance[0]->id_users)
                        ->where('type', 'LIKE', '%OUT%')
                        ->whereDate('waktu', '=', Carbon::parse($attendance[0]->waktu)->format('Y-m-d'))->first();

                    $data[$key]['waktu_masuk']    = date('H:i:s', strtotime($in->waktu));
                    $data[$key]['waktu_pulang']   = date('H:i:s', strtotime($out->waktu));
                    $data[$key]['status_masuk']   = ($in->is_approve = 1) ? "APPROVE" : "REJECT";
                    $data[$key]['status_pulang']  = ($out->is_approve = 1) ? "APPROVE" : "REJECT";
                }


                return response()->json([
                    "message" => "Sucess get data",
                    "data"    => $data
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error'     => true,
                'message'   => dd($e),
                'data'      => '',
                'status'    => 407
            ], 407);
        }
    }
}
