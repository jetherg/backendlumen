<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->Ticket = new Ticket;
    }

    public function index()
    {
        $tickets = $this->Ticket->all();
        return response()->json($tickets);
    }

    public function view($id)
    {
        $ticket = $this->Ticket->find($id);
        return response()->json($ticket);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required',
        ]);

        $ticket = new Ticket();

        $ticket->name = $request->name;
        $ticket->description = $request->description;

        $ticket->save();
        return response()->json('Ticket Added!');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'     => 'required',
        ]);

        $ticket = $this->Ticket->find($id);

        $ticket->name = $request->name;
        $ticket->description = $request->description;

        $ticket->save();
        return response()->json($ticket);
    }

    public function delete($id)
    {
        $ticket = $this->Ticket->find($id);
        $ticket->delete();
        return response()->json('Ticket Deleted!');
    }
}
