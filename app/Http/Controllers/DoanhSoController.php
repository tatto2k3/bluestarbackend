<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Chuyenbay;
use Illuminate\Http\Request;

class DoanhSoController extends Controller
{
    public function GetDoanhSo(Request $request)
{
    try {
        $year = $request->query('year');
        $monthCount = array_fill(1, 12, 0);

        $results = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
            ->whereRaw('SUBSTRING(chuyenbay.departureDay, 1, 4) = ?', [$year])
            ->select('chuyenbay.departureDay')
            ->get();

        foreach ($results as $item) {
            $monthNumber = (int)substr($item->departureDay, 5, 2);
            $monthCount[$monthNumber]++;
        }

        return response()->json($monthCount);
    } catch (\Exception $ex) {
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}


    public function GetDoanhThuNam(Request $request)
    {
        try {
            $year = $request->query('year');

            if (empty($year)) {
                return response()->json(['error' => 'Year parameter is required.'], 400);
            }

            $result = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
                ->whereRaw('SUBSTRING(chuyenbay.departureDay, 1, 4) = ?', [$year])
                ->select('ticket.Fly_ID', 'chuyenbay.departureDay', 'ticket.Ticket_Price')
                ->get();

            $totalRevenue = $result->sum('Ticket_Price');

            $details = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
                ->whereRaw('SUBSTRING(chuyenbay.departureDay, 1, 4) = ?', [$year])
                ->select('ticket.T_ID', 'ticket.CCCD', 'ticket.Name', 'ticket.Fly_ID', 'chuyenbay.departureDay')
                ->get();

            return response()->json(['TotalRevenue' => $totalRevenue, 'Details' => $details]);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function GetDoanhThuThang(Request $request)
    {
        try {
            $year = $request->query('year');
            $month = $request->query('month');

            if (empty($year) || empty($month)) {
                return response()->json(['error' => 'Year and month parameters are required.'], 400);
            }

            $result = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
                ->whereRaw('SUBSTRING(chuyenbay.departureDay, 1, 4) = ?', [$year])
                ->whereRaw('SUBSTRING(chuyenbay.departureDay, 6, 2) = ?', [$month])
                ->select('ticket.Fly_ID', 'chuyenbay.departureDay', 'ticket.Ticket_Price')
                ->get();

            $totalRevenue = $result->sum('Ticket_Price');

            $details = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
            ->whereRaw('SUBSTRING(chuyenbay.departureDay, 1, 4) = ?', [$year])
            ->whereRaw('SUBSTRING(chuyenbay.DepartureDay, 6, 2) = ?', [$month])
            ->select('ticket.T_ID', 'ticket.CCCD', 'ticket.Name', 'ticket.Fly_ID', 'chuyenbay.departureDay')
            ->get();

            return response()->json(['TotalRevenue' => $totalRevenue, 'Details' => $details]);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function GetDetails(Request $request)
    {
        try {
            $details = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
                ->select('ticket.T_ID', 'ticket.CCCD', 'ticket.Name', 'chuyenbay.flyID', 'chuyenbay.departureDay')
                ->get();

            return response()->json($details);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
