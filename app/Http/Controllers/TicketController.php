<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Carbon;

class TicketController extends Controller
{
    function addTicket(Request $request){
        $ticket = new Ticket;
        $ticket->t_id = $request->input('T_ID');
        $ticket->cccd = $request->input('CCCD');
        $ticket->name = $request->input('Name');
        $ticket->fly_id = $request->input('Fly_ID');
        $ticket->kg_id = $request->input('Kg_ID');
        $ticket->seat_id = $request->input('Seat_ID');
        $ticket->food_id = $request->input('Food_ID');
        $ticket->ticket_price = $request->input('Ticket_Price');
        $ticket->mail = $request->input('Mail');
        $ticket->dis_id = $request->input('Dis_ID');
        $ticket->save();

        return $ticket;
    }

    function getTickets()
    {
        $tickets = Ticket::all();
         return response()->json($tickets);
    }
    function updateTicket(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'T_ID' => 'required',
                'CCCD' => 'required',
                'Name' => 'required',
                'Ticket_Price' => 'required',
                'Mail' => 'required'
            ]);

            $departureDate = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
         ->where('T_ID', $request->input('T_ID'))
         ->select('chuyenbay.departureDay')
         ->first();

     // Chuyển định dạng ngày từ chuỗi sang đối tượng Carbon để so sánh
     $departureDate = Carbon::parse($departureDate->departureDay);

     // Lấy ngày hiện tại
     $currentDate = Carbon::now();

     // So sánh ngày hiện tại với ngày chuyến bay
     if ($currentDate->greaterThan($departureDate)) {
         return response()->json(['error' => 'Khong the sua. Chuyen bay da hoan tat.'], 401);
     }

            // Find the Ticket by cId
            $ticket = Ticket::where('T_ID', $request->input('T_ID'))->first();

            if (!$ticket) {
                return response()->json(['error' => 'Ticket not found'], 404);
            }

            // Update Ticket data
            $ticket->CCCD = $request->input('CCCD');
            $ticket->Name = $request->input('Name');
            $ticket->Fly_ID = $request->input('Fly_ID');
            $ticket->Seat_ID = $request->input('Seat_ID');
            $ticket->Food_ID = $request->input('Food_ID');
            $ticket->Kg_ID = $request->input('Kg_ID');
            $ticket->Mail = $request->input('Mail');
            $ticket->Dis_ID = $request->input('Dis_ID');
            $ticket->Ticket_Price = $request->input('Ticket_Price');
            $ticket->save();

            return response()->json(['message' => 'Ticket updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getTicketDetails(Request $request)
    {
        $selectedTickets = $request->input('tIds');

        // Chuyển chuỗi cIds thành mảng
        $selectedTicketIds = explode(',', $selectedTickets);

        // Lấy chi tiết của các khách hàng được chọn
        $TicketDetails = Ticket::whereIn('T_ID', $selectedTicketIds)->get();

        return response()->json($TicketDetails);
    }

    function deleteTicket($cId)
{
    try {
        // Tìm khách hàng dựa trên C_ID
        $ticket = Ticket::where('T_ID', $cId)->first();

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

         // Lấy ngày chuyến bay từ cơ sở dữ liệu
         $departureDate = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
         ->where('T_ID', $cId)
         ->select('chuyenbay.departureDay')
         ->first();

     // Chuyển định dạng ngày từ chuỗi sang đối tượng Carbon để so sánh
     $departureDate = Carbon::parse($departureDate->departureDay);

     // Lấy ngày hiện tại
     $currentDate = Carbon::now();

     // So sánh ngày hiện tại với ngày chuyến bay
     if ($currentDate->greaterThan($departureDate)) {
         return response()->json(['error' => 'Cannot delete. Departure date has passed.'], 400);
     }

     // Nếu ngày chuyến bay chưa đến, thực hiện xóa vé máy bay
     $ticket->delete();

     return response()->json(['message' => 'Ticket deleted successfully'], 200);
 } catch (\Exception $e) {
     // Xử lý lỗi
     return response()->json(['error' => $e->getMessage()], 500);
 }
}


    function searchTickets(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search Tickets by name containing the provided keyword
            $searchResults = Ticket::where('Name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('Ticket_Price', 'like', '%' . $searchKeyword . '%')
                ->orWhere('Dis_ID', 'like', '%' . $searchKeyword . '%')
                ->orWhere('T_ID', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }

    public function GetTicketReviewDetails(Request $request)
    {
        try {
            $name = $request->query('name');
            $flyId = $request->query('flyId');

            if (empty($name)) {
                return response()->json(['error' => 'Year parameter is required.'], 400);
            }

            $result = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
                ->whereRaw('Name = ?', [$name])
                ->whereRaw('ticket.Fly_ID = ?', [$flyId])
                ->select('ticket.T_ID', 'ticket.CCCD', 'ticket.Name', 'ticket.Fly_ID', 'chuyenbay.departureDay','chuyenbay.departureTime','chuyenbay.arrivalTime','ticket.Seat_ID')
                ->get();

            $totalRevenue = $result->sum('Ticket_Price');

            $details = Ticket::join('chuyenbay', 'ticket.Fly_ID', '=', 'chuyenbay.flyID')
                ->whereRaw('Name = ?', [$name])
                
                ->get();

            return response()->json($result);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }



}
